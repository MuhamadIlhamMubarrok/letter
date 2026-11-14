<?php

namespace App\Services\Ai;

use App\Admin\Product\Model\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected ?string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');
        $this->model = config('services.gemini.model') ?? env('GEMINI_MODEL', 'gemini-1.5-flash');
    }

    public function isConfigured(): bool
    {
        $key = config('services.gemini.key') ?? $this->apiKey;
        return !empty($key) && trim($key) !== '';
    }

    public function getApiKey(): ?string
    {
        return config('services.gemini.key') ?? $this->apiKey;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function generateReply(string $userMessage, array $conversationHistory = []): string
    {
        if ($this->isConfigured()) {
            try {
                $response = $this->callGeminiApi($userMessage, $conversationHistory);
                if (!empty($response)) {
                    return $response;
                }
            } catch (\Throwable $e) {
                Log::warning('Gemini API call failed, falling back to local florist assistant: ' . $e->getMessage());
            }
        }

        return $this->fallbackFloralAssistant($userMessage);
    }

    protected function callGeminiApi(string $userMessage, array $conversationHistory = []): ?string
    {
        $systemPrompt = $this->buildSystemPrompt();

        $contents = [];
        $firstUserFound = false;

        foreach ($conversationHistory as $turn) {
            $rawRole = $turn['role'] ?? 'user';
            $role = ($rawRole === 'model' || $rawRole === 'assistant') ? 'model' : 'user';
            $text = trim((string) ($turn['content'] ?? ''));

            if ($text === '') {
                continue;
            }

            // Gemini API requires the conversation contents to start with a 'user' turn
            if (!$firstUserFound) {
                if ($role !== 'user') {
                    continue;
                }
                $firstUserFound = true;
            }

            // Merge consecutive messages with identical role to respect API requirements
            if (!empty($contents) && end($contents)['role'] === $role) {
                $lastIndex = array_key_last($contents);
                $contents[$lastIndex]['parts'][0]['text'] .= "\n\n" . $text;
            } else {
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $text]],
                ];
            }
        }

        // Append current user message
        if (!empty($contents) && end($contents)['role'] === 'user') {
            $lastIndex = array_key_last($contents);
            $contents[$lastIndex]['parts'][0]['text'] .= "\n\n" . $userMessage;
        } else {
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $userMessage]],
            ];
        }

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $systemPrompt],
                ],
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 800,
                'topP' => 0.95,
            ],
        ];

        $apiKey = $this->getApiKey();
        $modelsToTry = array_unique([$this->model, 'gemini-3.5-flash-lite', 'gemini-3.1-flash-lite']);

        foreach ($modelsToTry as $currentModel) {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$currentModel}:generateContent?key={$apiKey}";

            try {
                $res = Http::timeout(15)
                    ->withoutVerifying()
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($endpoint, $payload);

                if ($res->successful()) {
                    $data = $res->json();
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if (!empty($reply)) {
                        return trim($reply);
                    }
                } else {
                    Log::warning("Gemini API ({$currentModel}) returned status {$res->status()}: " . substr($res->body(), 0, 300));
                }
            } catch (\Throwable $e) {
                Log::warning("Gemini API ({$currentModel}) call exception: " . $e->getMessage());
            }
        }

        return null;
    }

    protected function buildSystemPrompt(): string
    {
        $catalogSummary = $this->getCatalogKnowledge();

        $waNumber = setting('whatsapp_number', '6285882119900');
        $address = setting('address', 'Jl. Maja Botanical No. 18, Kebayoran Baru, Jakarta Selatan');
        $ig = setting('instagram_url', 'https://www.instagram.com/maja.flwr/');
        $tt = setting('tiktok_url', 'https://www.tiktok.com/@maja_flowers');
        $threads = setting('threads_url', 'https://www.threads.com/@maja.flwr?hl=id');
        $fb = setting('facebook_url', 'https://web.facebook.com/profile.php?id=61570779759134&locale=id_ID');

        return <<<PROMPT
Anda adalah "Maja Assistant", asisten florist botani resmi dan representasi profesional dari Maja Flower boutique florist (dikenal sebagai "Buket No 1 di Maja").

# IDENTITAS & KARAKTER ANDA:
- Ramah, sopan, puitis, anggun, hangat, dan sangat berpengetahuan tentang seni merangkai bunga modern (Korean-French floral aesthetics).
- Anda menyapa pelanggan dengan antusiasme hangat dan membantu mereka memilih atau merancang buket terbaik untuk momen bahagia maupun mengharukan.

# INFORMASI PRODUK & KATALOG TERBARU (LIVE DARI DATABASE MAJA FLOWER):
{$catalogSummary}

# ALUR PEMESANAN CUSTOM BUKET (7 LANGKAH TERSTRUKTUR):
Jika pelanggan bertanya cara memesan atau ingin custom buket, jelaskan 7 langkah mudah & transparan berikut:
1. **KONSULTASI & KONSEP**: Pelanggan memberitahukan momen/acara (wisuda, ulang tahun, anniversary, permohonan maaf, dsb.), referensi foto atau paduan warna favorit, dan pilihan jenis bunga (Fresh Flower, Artificial Flower, atau Preserved Dried Flower).
2. **BUDGET & UKURAN**: Penentuan budget dan ukuran buket (Small, Medium, atau Large) dengan rekomendasi paduan tangkai bunga yang pas dari florist.
3. **DETAIL & REKAP (ORDER FORM)**: Florist mencatat detail penerima, tanggal/jam pengiriman, dan isi pesan kartu ucapan, lalu memberikan rincian pesanan beserta total biaya untuk disetujui pemesan.
4. **DOWN PAYMENT (DP)**: Pelanggan melakukan pembayaran DP untuk mengunci jadwal antrean merangkai di studio dan mengamankan kuota bunga segar.
5. **PROSES RANGKAI & PREVIEW**: Perangkai kami merangkai buket sesuai konsep yang disepakati. Sebelum dikirim atau diambil, florist akan mengirimkan foto/video konfirmasi preview hasil akhir untuk memastikan setiap detail sudah sempurna.
6. **PELUNASAN SISA**: Setelah foto preview disetujui dan sebelum rangkaian diserahterimakan, pelanggan melakukan pelunasan sisa pembayaran.
7. **PENGIRIMAN / AMBIL**:
   - Kurir Instan: Dikirim aman terlindung sesuai jadwal.
   - Self Pick-up: Diambil langsung di studio kami sesuai jam kesepakatan.

# STATUS PENGERJAAN & CEK RESI BUKET:
- Pelanggan dapat memantau status pengerjaan secara transparan dan real-time di halaman **Cek Resi Buket** (/lacak-pesanan).
- Kode resi unik berformat acak dan aman (contoh: MJ-XXXX-XXXX) akan diberikan oleh florist setelah pesanan dibuat.

# KEBIJAKAN PENTING BUNGA SEGAR (FRESH FLOWER):
- **KUOTA HARIAN TERBATAS**: Pasokan bunga potong segar (*fresh flowers*) di Maja Flower sengaja dibatasi kuota hariannya demi menjamin kesegaran tertinggi (grade A). Anjurkan pelanggan untuk memesan H-1 atau konsultasi lebih awal agar slot tidak kehabisan.
- Sebagai alternatif tahan lama, Maja Flower menyediakan **Artificial Flowers** (bunga tiruan premium import bersentuhan alami) dan **Dried Flowers** (bunga kering estetik abadi) yang selalu siap dirangkai.

# MEDIA SOSIAL RESMI & KONTAK:
- Direct WhatsApp Florist: +{$waNumber} (link: https://wa.me/{$waNumber})
- Instagram: @maja.flwr ({$ig})
- Threads: @maja.flwr ({$threads})
- TikTok: @maja_flowers ({$tt})
- Facebook: Maja Flower ({$fb})
- Studio: {$address}

# PANDUAN MENJAWAB:
- Jawab dalam Bahasa Indonesia yang elegan, komunikatif, dan rapi menggunakan markdown (bullet points dan bold).
- Berikan saran yang spesifik sesuai budget dan acara pelanggan.
- Jika pelanggan ingin memesan buket atau berkonsultasi lebih lanjut, arahkan dengan ramah untuk klik tombol WhatsApp Florist.
- Sisipkan emoji botani (🌸, 🌿, 💐, 🎀) secukupnya untuk memberi kesan hangat dan hidup.
PROMPT;
    }

    protected function getCatalogKnowledge(): string
    {
        try {
            $categories = Category::withCount('products')->get();
            $products = Product::where('is_available', true)->with('category')->get();

            $lines = ["Kategori / Series Buket yang Tersedia:"];
            foreach ($categories as $cat) {
                $lines[] = "- **{$cat->name}**: {$cat->description}";
            }

            $lines[] = "\nProduk & Harga Unggulan Saat Ini:";
            foreach ($products as $prod) {
                $series = $prod->category?->name ?? 'General';
                $priceFormatted = $prod->formatted_price;
                $bestseller = $prod->is_bestseller ? ' [Bestseller]' : '';
                $lines[] = "- **{$prod->name}** ({$series}) - {$priceFormatted}{$bestseller}: {$prod->description}";
            }

            return implode("\n", $lines);
        } catch (\Throwable $e) {
            // Safe fallback catalog if DB is momentarily unreachable
            return <<<FALLBACK
- **Teddy Series**: Koleksi buket manis berhias boneka teddy bear. Contoh: Teddy Series - Rose Petite (Rp 70.000), Violette (Rp 70.000), Rose Big Size (Rp 150.000).
- **Lumière Series**: Koleksi buket bunga premium bernuansa cahaya elegan. Contoh: Lumière Series - Sunshine (Rp 185.000), Blanche (Rp 215.000), Aurore (Rp 245.000).
- **Bespoke Custom Series**: Rangkaian buket personal sesuai budget dan selera.
- **Fresh Flower Series**: Bunga segar pilihan (kuota terbatas harian).
- **Dried & Preserved Series**: Bunga kering abadi estetik.
- **Artificial Bloom Series**: Bunga tiruan premium import tahan lama.
FALLBACK;
        }
    }

    protected function fallbackFloralAssistant(string $message): string
    {
        $msg = strtolower($message);

        if (str_contains($msg, 'wisuda') || str_contains($msg, 'graduation')) {
            if (str_contains($msg, '200') || str_contains($msg, 'murah') || str_contains($msg, 'budget') || str_contains($msg, '100') || str_contains($msg, 'bawah')) {
                return "Untuk momen wisuda dengan budget terjangkau, kami merekomendasikan:\n\n- **Lumière Series - Sunshine** (Rp 185.000) dengan bunga matahari import cerah pembawa harapan baru!\n- **Teddy Series - Violette / Rose Petite** (Rp 70.000) berhias boneka beruang wisuda yang manis!\n\nSetiap pesanan sudah termasuk gratis kartu ucapan wisuda & pita sutra elegan 🎓";
            }
            return "Selamat untuk kelulusan orang terkasih! 🎓 Untuk wisuda, buket bunga matahari (**Lumière Series - Sunshine**) atau **Teddy Series** dengan boneka wisuda adalah pilihan terfavorit. Anda juga dapat memesan varian bunga artificial atau dried flowers agar bisa disimpan abadi sebagai kenang-kenangan.";
        }

        if (str_contains($msg, 'maaf') || str_contains($msg, 'sorry')) {
            return "Bunga selalu memiliki cara ajaib untuk melembutkan hati yang terluka. 🌿\n\nUntuk menyampaikan permohonan maaf yang tulus, kami merekomendasikan **Lumière Series - Blanche** (Rp 215.000) dengan mawar putih mekar yang melambangkan kemurnian niat dan ketulusan hati. Florist kami siap menyelipkan kartu ucapan beraksara puitis untuk Anda.";
        }

        if (str_contains($msg, 'rawat') || str_contains($msg, 'awet') || str_contains($msg, 'tahan')) {
            return "Tips menjaga kesegaran buket bunga dari Maja Flower agar awet hingga 7-10 hari:\n\n1. **Potong Tangkai 45°**: Potong ujung batang sekitar 1-2 cm secara menyerong di bawah air mengalir agar penyerapan air maksimal.\n2. **Ganti Air Bersih Tiap Hari**: Gunakan air dingin/suhu ruang dan bersihkan vas.\n3. **Jauhkan dari Terik & Buah Matang**: Letakkan di tempat sejuk berangin. Hindari paparan AC langsung atau sinar matahari terik.\n4. **Spray Embun Halus**: Semprot kelopak bunga di pagi hari dengan spray air halus.";
        }

        if (str_contains($msg, 'anniversary') || str_contains($msg, 'ulang tahun') || str_contains($msg, 'cinta') || str_contains($msg, 'pacar') || str_contains($msg, 'romantis')) {
            return "Untuk momen penuh cinta dan kasih sayang, keindahan **Lumière Series - Aurore** (Rp 245.000) atau **Teddy Series - Rose Big Size** (Rp 150.000) adalah pilihan istimewa untuk hari bahagia Anda. 💕 Tim kami dapat menambahkan foto mini atau kartu ucapan romantis khusus.";
        }

        if (str_contains($msg, 'custom') || str_contains($msg, 'alur') || str_contains($msg, 'pesan') || str_contains($msg, 'order') || str_contains($msg, 'langkah') || str_contains($msg, 'tahap')) {
            return "Alur Pemesanan Custom Buket di Maja Flower sangat mudah & transparan (7 Tahap):\n\n1. **Konsultasi & Konsep**: Beritahu momen/acara, kirim referensi foto & warna favorit, dan pilih jenis bunga (Fresh Flower kuota terbatas, Artificial Flower premium, atau Dried Flower abadi).\n2. **Budget & Ukuran**: Penentuan budget dan opsi ukuran (Small, Medium, atau Large).\n3. **Detail & Rekap**: Pengisian data penerima, jam pengiriman, isi kartu ucapan, dan persetujuan order form.\n4. **Down Payment (DP)**: Pembayaran DP untuk mengunci slot antrean rangkai studio dan kuota bunga segar.\n5. **Proses Rangkai & Preview**: Florist merangkai dan mengirimkan foto/video konfirmasi preview sebelum dikirim.\n6. **Pelunasan Sisa**: Pelunasan dilakukan setelah Anda menyetujui foto preview buket.\n7. **Pengiriman / Ambil**: Pengiriman aman via kurir instan atau self pick-up langsung di studio.\n\nStatus pengerjaan pesanan Anda dapat dipantau langsung di halaman **Cek Resi Buket** (/lacak-pesanan)!";
        }

        if (str_contains($msg, 'segar') || str_contains($msg, 'fresh') || str_contains($msg, 'kuota')) {
            return "Catatan penting untuk bunga segar (*fresh flowers*) di Maja Flower: 🌸\n\nUntuk memastikan kualitas dan kesegaran terbaik, kuota harian bunga potong segar kami **sangat terbatas setiap harinya**. Kami sarankan memesan H-1 atau konfirmasi ketersediaan slot melalui WhatsApp Florist. Bila kuota hari ini penuh, kami juga memiliki varian **Artificial Flowers** premium dan **Dried Flowers** abadi yang selalu siap dirangkai!";
        }

        if (str_contains($msg, 'sosmed') || str_contains($msg, 'instagram') || str_contains($msg, 'tiktok') || str_contains($msg, 'social') || str_contains($msg, 'threads') || str_contains($msg, 'facebook')) {
            return "Ikuti karya dan inspirasi harian Maja Flower di media sosial resmi kami:\n- Instagram: **@maja.flwr** (https://www.instagram.com/maja.flwr/)\n- TikTok: **@maja_flowers** (https://www.tiktok.com/@maja_flowers)\n- Threads: **@maja.flwr** (https://www.threads.com/@maja.flwr?hl=id)\n- Facebook: **Maja Flower** (https://web.facebook.com/profile.php?id=61570779759134&locale=id_ID)";
        }

        if (str_contains($msg, 'harga') || str_contains($msg, 'price') || str_contains($msg, 'berapa') || str_contains($msg, 'katalog') || str_contains($msg, 'teddy') || str_contains($msg, 'lumiere')) {
            return "Berikut pilihan buket unggulan di Maja Flower:\n\n**Teddy Series**:\n- Rose Petite: Rp 70.000\n- Violette: Rp 70.000\n- Rose Big Size: Rp 150.000\n\n**Lumière Series**:\n- Sunshine (Sunflower): Rp 185.000\n- Blanche (White Rose): Rp 215.000\n- Aurore (Pink Bloom): Rp 245.000\n\nAnda juga bisa request **Bespoke Custom** sesuai budget dan konsep Anda via WhatsApp!";
        }

        return "Halo! Terima kasih telah menyapa Maja Flower 🌿 Kami adalah boutique florist terpercaya dengan layanan **Bespoke Custom Buket** (7 langkah transparan dengan live preview foto & cek resi online). Mohon dicatat bahwa kuota bunga segar (*fresh flower*) harian kami terbatas demi menjaga kesegaran maksimal, namun kami juga menghadirkan bunga artificial premium dan dried flowers abadi yang selalu siap dirangkai. Ada momen istimewa yang ingin Anda rayakan?";
    }
}
