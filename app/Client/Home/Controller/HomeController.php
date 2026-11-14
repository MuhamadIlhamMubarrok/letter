<?php

namespace App\Client\Home\Controller;

use App\Admin\Product\Model\Product;
use App\Admin\Product\Repository\CategoryRepository;
use App\Admin\Product\Service\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\CustomerStory;
use App\Models\Faq;
use App\Models\FlowerPhilosophy;
use App\Models\FreshFlower;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $productService,
        protected CategoryRepository $categoryRepo
    ) {
    }

    public function index(): View
    {
        $bestsellers = $this->productService->getBestsellers(8);
        $categories = $this->categoryRepo->getAllCategories();
        $stories = CustomerStory::published()->get();
        $freshFlowers = FreshFlower::active()->ordered()->get();
        $philosophies = FlowerPhilosophy::active()->get();
        $faqs = Faq::active()->get();

        // 1. Get the lowest priced available bouquet to anchor transparent pricing
        $lowestProduct = Product::where('is_available', true)->orderBy('price', 'asc')->first();
        $startingPrice = $lowestProduct ? $lowestProduct->formatted_price : 'Rp 70.000';

        // 2. Curated Event Recommendations with Florist Reasons & Transparent Pricing
        $eventRecommendations = [
            [
                'id' => 'pasangan',
                'event_name' => 'Kado Buat Pasangan & Anniversary',
                'badge' => '❤️ Paling Romantis',
                'tagline' => 'Ungkapkan Rasa Sayang Tulus',
                'product_slug' => 'teddy-series-rose-petite',
                'product_name' => 'Teddy Series - Rose Petite',
                'price_label' => 'Mulai Rp 70.000',
                'image' => asset('catalog-media/tedy series - 2/Teddy bloom series - 2.png'),
                'flowers' => 'Boneka Teddy Cream + Mawar Pink Mekar',
                'reason' => 'Perpaduan kelopak mawar pink mekar dan boneka beruang berbulu lembut memberikan kesan manis dan romantis tanpa terkesan berlebihan. Pilihan tepat untuk kado anniversary, kencan spesial, atau kejutan pemanis hari agar pasangan tersenyum bahagia.',
                'suitable_for' => ['Pacar & Istri', 'Anniversary', 'Kencan Pertama', 'Hari Kasih Sayang'],
                'wa_text' => 'Halo Florist Maja Flower, saya mau pesan Buket Pasangan (Teddy Series Rose Petite - Mulai Rp 70.000). Apakah bisa request kartu ucapan romantis?',
            ],
            [
                'id' => 'wisuda',
                'event_name' => 'Wisuda & Sidang Kelulusan',
                'badge' => '🎓 Favorit Wisudawan',
                'tagline' => 'Merayakan Pencapaian Istimewa',
                'product_slug' => 'teddy-series-rose-big-size',
                'product_name' => 'Teddy Series - Rose Big Size',
                'price_label' => 'Rp 150.000',
                'image' => asset('catalog-media/tedy - rose big/Teddy bloom series - 2.png'),
                'flowers' => 'Boneka Teddy Besar + Mawar Pink & Putih Mekar',
                'reason' => 'Buket berdimensi besar (50 x 38 cm) yang sangat megah dan mencolok saat sesi foto toga wisuda. Dilengkapi boneka teddy bear premium yang awet disimpan bertahun-tahun sebagai simbol kenang-kenangan perjuangan meraih gelar sarjana.',
                'suitable_for' => ['Wisuda Sarjana', 'Sidang Skripsi', 'Kelulusan Sekolah', 'Foto Toga'],
                'wa_text' => 'Halo Florist Maja Flower, saya mau pesan Buket Wisuda (Teddy Series Big Size - Rp 150.000). Apakah siap dikirim untuk jadwal wisuda?',
            ],
            [
                'id' => 'ulang-tahun',
                'event_name' => 'Ulang Tahun & Apresiasi Sahabat',
                'badge' => '🎂 Ceria & Terjangkau',
                'tagline' => 'Hadiah Berkesan Tanpa Bikin Kantong Kering',
                'product_slug' => 'teddy-series-violette',
                'product_name' => 'Teddy Series - Violette',
                'price_label' => 'Hanya Rp 70.000',
                'image' => asset('catalog-media/tedy series - 1/Teddy bloom series - 1.png'),
                'flowers' => 'Brown Teddy Bear + Mawar Merah Beludru & Aster',
                'reason' => 'Harga sangat bersahabat (hanya Rp 70rb) dengan kombinasi warna bunga aster dan mawar beludru yang playful. Ukuran compact sangat praktis dibawa ke kafe atau kantor untuk kejutan ulang tahun teman tanpa repot.',
                'suitable_for' => ['Bestie & Sahabat', 'Rekan Kantor', 'Tukar Kado', 'Hadiah Spontan'],
                'wa_text' => 'Halo Florist Maja Flower, saya mau pesan Buket Sahabat (Teddy Series Violette - Rp 70.000). Apakah siap kirim hari ini?',
            ],
            [
                'id' => 'sukses',
                'event_name' => 'Ucapan Selamat & Semangat Sukses',
                'badge' => '🌻 Energi & Aura Positif',
                'tagline' => 'Penuh Kehangatan & Prestasi',
                'product_slug' => 'lumiere-series-sunshine',
                'product_name' => 'Lumière Series - Sunshine',
                'price_label' => 'Rp 185.000',
                'image' => asset('catalog-media/lumiere series - 1/lumirere series - 1.png'),
                'flowers' => '2 Sunflower Jumbo + Wild Daisy & Chamomile',
                'reason' => 'Bunga Matahari jumbo memancarkan energi optimisme, keceriaan, dan masa depan cerah. Sangat direkomendasikan untuk pembukaan bisnis baru, promosi jabatan, perayaan prestasi, atau doa lekas sembuh (get well soon).',
                'suitable_for' => ['Grand Opening', 'Naik Pangkat', 'Promosi Jabatan', 'Get Well Soon'],
                'wa_text' => 'Halo Florist Maja Flower, saya mau pesan Buket Sunshine (Lumière Series - Rp 185.000) untuk ucapan selamat.',
            ],
        ];

        return view('client.home.index', compact(
            'bestsellers',
            'categories',
            'stories',
            'freshFlowers',
            'philosophies',
            'faqs',
            'startingPrice',
            'eventRecommendations'
        ));
    }
}
