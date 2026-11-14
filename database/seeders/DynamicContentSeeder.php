<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FlowerPhilosophy;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class DynamicContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. SITE SETTINGS
        $settings = [
            // Topbar & Announcement Strip
            [
                'key' => 'announcement_active',
                'value' => '1',
                'group' => 'announcement',
                'label' => 'Status Pengumuman Topbar (1 = Aktif, 0 = Nonaktif)',
                'type' => 'boolean',
            ],
            [
                'key' => 'announcement_text',
                'value' => '🌸 SAMEDAY DELIVERY SE-JABODETABEK • LIVE PHOTO APPROVAL SEBELUM KIRIM',
                'group' => 'announcement',
                'label' => 'Teks Pengumuman Berjalan',
                'type' => 'text',
            ],
            [
                'key' => 'announcement_link',
                'value' => 'https://wa.me/6285882119900',
                'group' => 'announcement',
                'label' => 'Link Tautan Pengumuman',
                'type' => 'url',
            ],

            // Jam Buka & Operasional
            [
                'key' => 'operating_hours',
                'value' => '08:00 - 20:00 WIB (Buka Setiap Hari)',
                'group' => 'contact',
                'label' => 'Jam Operasional Atelier',
                'type' => 'text',
            ],
            [
                'key' => 'operating_status_text',
                'value' => 'Atelier Buka & Beroperasi Normal',
                'group' => 'contact',
                'label' => 'Status Jam Buka Live',
                'type' => 'text',
            ],

            // Kontak & WhatsApp Florist
            [
                'key' => 'whatsapp_number',
                'value' => '6285882119900',
                'group' => 'contact',
                'label' => 'Nomor WhatsApp Florist (Format: 628...)',
                'type' => 'text',
            ],
            [
                'key' => 'whatsapp_default_message',
                'value' => 'Halo Florist Maja Flower, saya ingin berkonsultasi pemesanan buket no 1 di maja.',
                'group' => 'contact',
                'label' => 'Template Pesan WhatsApp',
                'type' => 'textarea',
            ],
            [
                'key' => 'email',
                'value' => 'florist@majaflower.com',
                'group' => 'contact',
                'label' => 'Alamat Email Studio',
                'type' => 'text',
            ],
            [
                'key' => 'address',
                'value' => 'Jl. Maja Botanical No. 18, Kebayoran Baru, Jakarta Selatan, 12180',
                'group' => 'contact',
                'label' => 'Alamat Fisik Atelier',
                'type' => 'textarea',
            ],
            [
                'key' => 'google_maps_url',
                'value' => 'https://maps.google.com/?q=Jakarta+Selatan',
                'group' => 'contact',
                'label' => 'Link Google Maps',
                'type' => 'url',
            ],

            // Media Sosial Resmi
            [
                'key' => 'instagram_url',
                'value' => 'https://www.instagram.com/maja.flwr/',
                'group' => 'social',
                'label' => 'Akun Instagram Resmi',
                'type' => 'url',
            ],
            [
                'key' => 'tiktok_url',
                'value' => 'https://www.tiktok.com/@maja_flowers',
                'group' => 'social',
                'label' => 'Akun TikTok Resmi',
                'type' => 'url',
            ],
            [
                'key' => 'threads_url',
                'value' => 'https://www.threads.com/@maja.flwr?hl=id',
                'group' => 'social',
                'label' => 'Akun Threads Resmi',
                'type' => 'url',
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://web.facebook.com/profile.php?id=61570779759134&locale=id_ID',
                'group' => 'social',
                'label' => 'Akun Facebook Resmi',
                'type' => 'url',
            ],

            // Hero Ticker & Live Metrics
            [
                'key' => 'hero_ticker_text',
                'value' => 'ATELIER OPEN • KUOTA FRESH FLOWER TERBATAS',
                'group' => 'hero',
                'label' => 'Badge Status Ticker Hero',
                'type' => 'text',
            ],
            [
                'key' => 'hero_stat_curated',
                'value' => '12.4k+ Buket Terkurasi',
                'group' => 'hero',
                'label' => 'Statistik Buket Terkurasi',
                'type' => 'text',
            ],
            [
                'key' => 'hero_stat_rating',
                'value' => '★ 4.9/5 (1.8k+ Ulasan)',
                'group' => 'hero',
                'label' => 'Statistik Rating Ulasan',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // 2. FAQS
        $faqs = [
            [
                'category' => 'Pengiriman & Sameday',
                'question' => 'Apakah Maja Flower melayani pengiriman di hari yang sama (Sameday Delivery)?',
                'answer' => 'Ya, kami melayani sameday delivery untuk seluruh area Jabodetabek. Untuk memastikan bunga segar siap dan terangkai sempurna, kami menyarankan pemesanan dilakukan sebelum pukul 15.00 WIB.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'Pemesanan & Foto Approval',
                'question' => 'Bagaimana cara kerja sistem Live Photo Approval sebelum buket dikirim?',
                'answer' => 'Setelah florist selesai merangkai buket Anda, kami akan mengunggah foto asli buket ke sistem pelacakan (Live Tracking). Anda dapat melihat foto resolusi tinggi dan menekan tombol \'Setujui Foto\' sebelum kurir kami berangkat mengantar pesanan.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'Bunga Segar & Ketahanan',
                'question' => 'Berapa lama ketahanan buket fresh flower dari Maja Flower?',
                'answer' => 'Bunga segar kami disimpan dalam daily cold room bertemperatur 6-8°C dengan hidrasi optimal. Saat diterima, buket dilengkapi floral water sponge dan instruksi perawatan, sehingga mampu bertahan segar 3 hingga 5 hari.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'Custom & Bespoke',
                'question' => 'Bisakah saya memesan buket dengan kombinasi bunga dan warna pembungkus (wrapping) kustom?',
                'answer' => 'Tentu! Anda dapat memilih warna wrapping, kartu ucapan eksklusif, hingga request jenis bunga khusus (misal: mawar putih, baby\'s breath, sunflower) langsung melalui fitur konsultasi WhatsApp florist kami.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'category' => 'Pengiriman & Garansi',
                'question' => 'Bagaimana jika buket mengalami kendala saat di perjalanan?',
                'answer' => 'Maja Flower memberikan Garansi Kesegaran 100%. Setiap pesanan dikirim menggunakan tas pelindung khusus florist. Apabila terjadi kendala di perjalanan, hubungi tim kami dalam 2 jam setelah penerimaan untuk penggantian atau solusi terbaik.',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }

        // 3. FLOWER PHILOSOPHIES
        $philosophies = [
            [
                'flower_name' => 'Red Holland Rose',
                'scientific_name' => 'Rosa hybrida',
                'emoji_or_icon' => '🌹',
                'meaning' => 'Cinta Sejati & Keberanian',
                'description' => 'Mawar merah melambangkan kobaran asmara yang mendalam, rasa hormat yang tulus, dan kesetiaan yang tak lekang oleh waktu.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'flower_name' => 'Casablanca White Lily',
                'scientific_name' => 'Lilium oriental',
                'emoji_or_icon' => '🪷',
                'meaning' => 'Ketulusan & Lembaran Baru',
                'description' => 'Kelopak putih bersih dengan aroma menenangkan, sempurna untuk permohonan maaf, ucapan duka cita, atau awal pernikahan suci.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'flower_name' => 'Helianthus Sunflower',
                'scientific_name' => 'Helianthus annuus',
                'emoji_or_icon' => '🌻',
                'meaning' => 'Harapan, Optimisme & Wisuda',
                'description' => 'Selalu menghadap ke arah cahaya. Simbol pencapaian gemilang, energi keceriaan, dan masa depan yang penuh keberhasilan.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'flower_name' => 'Gypsophila Baby\'s Breath',
                'scientific_name' => 'Gypsophila paniculata',
                'emoji_or_icon' => '🌾',
                'meaning' => 'Kemurnian & Cinta Abadi',
                'description' => 'Bunga-bunga mungil bagai butiran salju musim semi, melambangkan keabadian rasa dan ketulusan jiwa yang tak terikat kata.',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($philosophies as $phil) {
            FlowerPhilosophy::updateOrCreate(
                ['flower_name' => $phil['flower_name']],
                $phil
            );
        }
    }
}
