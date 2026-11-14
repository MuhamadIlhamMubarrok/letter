<?php

namespace Database\Seeders;

use App\Admin\Product\Model\Product;
use App\Domains\Order\Enums\OrderStatusEnum;
use App\Domains\Order\Models\BuckflowProduct;
use App\Domains\Order\Models\Order;
use App\Domains\Order\Models\OrderItem;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::firstOrCreate(
            ['email' => 'admin@majaflower.com'],
            [
                'name' => 'Florist Lead Maja',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Categories based on Bouquet Series
        $categoriesData = [
            [
                'name' => 'Teddy Series',
                'slug' => 'teddy-series',
                'description' => 'Koleksi buket manis berhias boneka beruang menggemaskan, kelopak mawar mekar, dan sentuhan pita sutra premium khas Maja Flower.',
            ],
            [
                'name' => 'Lumière Series',
                'slug' => 'lumiere-series',
                'description' => 'Rangkaian floral premium bernuansa hangat, anggun, dan berkelas dengan paduan bunga matahari jumbo, mawar avalanche, dan lili istimewa.',
            ],
            [
                'name' => 'Bespoke Custom Series',
                'slug' => 'bespoke-custom-series',
                'description' => 'Layanan buket kustom personal yang dirangkai eksklusif mengikuti konsep momen spesial, palet warna, dan alokasi budget Anda.',
            ],
            [
                'name' => 'Fresh Flower Series',
                'slug' => 'fresh-flower-series',
                'description' => 'Rangkaian bunga potong segar dengan kuota harian terbatas demi menjamin kesegaran dan keharuman alami tertinggi.',
            ],
            [
                'name' => 'Dried & Preserved Series',
                'slug' => 'dried-preserved-series',
                'description' => 'Rangkaian buket bunga kering dan preserved flowers abadi bernuansa vintage rustic yang awet bertahun-tahun.',
            ],
            [
                'name' => 'Artificial Bloom Series',
                'slug' => 'artificial-bloom-series',
                'description' => 'Buket bunga tiruan premium grade A yang tahan selamanya, estetik, dan siap dikirim tanpa khawatir layu.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Clean up obsolete categories that have no products
        Category::whereNotIn('slug', array_keys($categories))->whereDoesntHave('products')->delete();

        // 3. Products
        $productsData = [
            [
                'category_slug' => 'lumiere-series',
                'name' => 'Lumière Series - Sunshine',
                'description' => 'Koleksi eksklusif Lumière Series bernuansa hangat dan cerah dengan 2 Sunflower Jumbo import, aksen wild chamomile, serta balutan Korean cellophane dan pita sutra. Pilihan ideal untuk merayakan kelulusan dan momen pencapaian istimewa.',
                'price' => 185000,
                'flower_composition' => '2 Sunflower Jumbo, Yellow Wild Daisies, Solidago, Korean Cellophane, Silk Ribbon',
                'dimensions' => '45 x 30 cm',
                'is_bestseller' => true,
                'is_available' => true,
                'images' => [
                    'catalog-media/lumiere series - 1/lumirere series - 1.png',
                    'catalog-media/lumiere series - 1/lumirere series - 4.png',
                    'catalog-media/lumiere series - 1/lumirere series - 5.png',
                    'catalog-media/lumiere series - 1/lumirere series - 6.png',
                ],
            ],
            [
                'category_slug' => 'lumiere-series',
                'name' => 'Lumière Series - Blanche',
                'description' => 'Rangkaian anggun Lumière Series bernuansa putih dan pastel lembut. Menghadirkan Mawar Putih Avalanche premium, Mawar Peach Ohara, dan sentuhan Hydrangea Lime Green yang memancarkan aura kemurnian dan keabadian.',
                'price' => 215000,
                'flower_composition' => 'Mawar Putih Premium, Mawar Peach Ohara, Hydrangea Lime Green, Wild Violet & Baby Blue Daisy',
                'dimensions' => '45 x 30 cm',
                'is_bestseller' => true,
                'is_available' => true,
                'images' => [
                    'catalog-media/lumiere series - 2/lumirere series - 2.png',
                    'catalog-media/lumiere series - 2/lumirere series - 4.png',
                    'catalog-media/lumiere series - 2/lumirere series - 5.png',
                    'catalog-media/lumiere series - 2/lumirere series - 6.png',
                ],
            ],
            [
                'category_slug' => 'lumiere-series',
                'name' => 'Lumière Series - Aurore',
                'description' => 'Kreasi romantis penuh pesona dari Lumière Series yang mengombinasikan Pink Stargazer Lily, Peach Garden Rose mekar, serta pom-pom krisan segar. Hadiah sempurna untuk ungkapan cinta dan perayaan ulang tahun tersayang.',
                'price' => 245000,
                'flower_composition' => 'Pink Stargazer Lily, Peach Garden Rose, Green Chrysanthemum Pom-Pom, Red & Violet Wild Cosmos',
                'dimensions' => '48 x 32 cm',
                'is_bestseller' => true,
                'is_available' => true,
                'images' => [
                    'catalog-media/lumiere series - 3/lumirere series - 3.png',
                    'catalog-media/lumiere series - 3/lumirere series - 4.png',
                    'catalog-media/lumiere series - 3/lumirere series - 5.png',
                    'catalog-media/lumiere series - 3/lumirere series - 6.png',
                ],
            ],
            [
                'category_slug' => 'teddy-series',
                'name' => 'Teddy Series - Rose Big Size',
                'description' => 'Buket istimewa berukuran besar (Big Size) yang memadukan boneka Teddy Bear cokelat manis dengan mawar pink mekar dan krisan pom-pom biru. Memberikan kejutan manis tak terlupakan untuk orang tersayang.',
                'price' => 150000,
                'flower_composition' => 'Boneka Teddy Bear Premium, Mawar Pink & Putih Mekar Besar, Blue Pom-Pom Chrysanthemum',
                'dimensions' => '50 x 38 cm',
                'is_bestseller' => true,
                'is_available' => true,
                'images' => [
                    'catalog-media/tedy - rose big/Teddy bloom series - 2.png',
                    'catalog-media/tedy - rose big/Teddy bloom series - 4.png',
                    'catalog-media/tedy - rose big/Teddy bloom series - 5.png',
                    'catalog-media/tedy - rose big/Teddy bloom series - 6.png',
                ],
            ],
            [
                'category_slug' => 'teddy-series',
                'name' => 'Teddy Series - Violette',
                'description' => 'Buket manis compact dengan boneka beruang menggemaskan, kelopak mawar merah beludru berpadu aster ungu dan solidago. Pilihan ekonomis dan berkesan untuk kado spontan atau ucapan selamat.',
                'price' => 70000,
                'flower_composition' => 'Boneka Brown Teddy Bear, Mawar Merah Beludru, Purple & Lavender Aster, Yellow Solidago',
                'dimensions' => '35 x 22 cm',
                'is_bestseller' => false,
                'is_available' => true,
                'images' => [
                    'catalog-media/tedy series - 1/Teddy bloom series - 1.png',
                    'catalog-media/tedy series - 1/lumirere series - 4.png',
                    'catalog-media/tedy series - 1/lumirere series - 5.png',
                    'catalog-media/tedy series - 1/lumirere series - 6.png',
                ],
            ],
            [
                'category_slug' => 'teddy-series',
                'name' => 'Teddy Series - Rose Petite',
                'description' => 'Buket menggemaskan berukuran mungil dengan boneka beruang cream dan mawar pink segar. Ringkas, cantik, dan sangat cocok untuk merayakan pencapaian harian orang tersayang.',
                'price' => 70000,
                'flower_composition' => 'Boneka Cream Teddy Bear, Mawar Pink Mekar, Pink & Red Cosmos, Yellow Solidago',
                'dimensions' => '35 x 22 cm',
                'is_bestseller' => true,
                'is_available' => true,
                'images' => [
                    'catalog-media/tedy series - 2/Teddy bloom series - 2.png',
                    'catalog-media/tedy series - 2/lumirere series - 4.png',
                    'catalog-media/tedy series - 2/lumirere series - 5.png',
                    'catalog-media/tedy series - 2/lumirere series - 6.png',
                ],
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $prod) {
            $cat = $categories[$prod['category_slug']];
            $slug = Str::slug($prod['name']);
            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $cat->id,
                    'name' => $prod['name'],
                    'description' => $prod['description'],
                    'price' => $prod['price'],
                    'flower_composition' => $prod['flower_composition'],
                    'dimensions' => $prod['dimensions'],
                    'is_bestseller' => $prod['is_bestseller'],
                    'is_available' => $prod['is_available'],
                ]
            );

            // Sync images
            ProductImage::where('product_id', $product->id)->delete();
            foreach ($prod['images'] as $idx => $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $img,
                    'is_primary' => ($idx === 0),
                ]);
            }

            $createdProducts[] = $product;
        }

        // Clean up products not in list
        $activeSlugs = array_map(fn($p) => Str::slug($p['name']), $productsData);
        Product::whereNotIn('slug', $activeSlugs)->delete();

        // 4. Sample Orders in Buckflow ERP (Live Order Tracking Sync)
        try {
            $buckflowProduct = BuckflowProduct::firstOrCreate(
                ['name' => 'Lumière Sunshine Bouquet'],
                [
                    'slug' => 'lumiere-sunshine-bouquet',
                    'selling_price' => 185000,
                    'image_path' => 'catalog-media/lumiere series - 1/lumirere series - 1.png',
                    'is_active' => true,
                ]
            );

            $order1 = Order::updateOrCreate(
                ['tracking_code' => 'BF-202610-0001'],
                [
                    'customer_name' => 'Adinda Saraswati',
                    'customer_phone' => '081234567891',
                    'status' => OrderStatusEnum::READY,
                    'payment_status' => 'paid',
                    'total_amount' => 185000,
                    'deadline_at' => now()->addDay()->setTime(14, 0),
                    'production_started_at' => now()->subHours(2),
                    'ready_at' => now()->subMinutes(30),
                    'greeting_card_message' => 'Selamat atas kelulusan spesialisnya sayang! Proud of you always. Menuju babak pengabdian yang mulia.',
                    'qc_photo_path' => 'catalog-media/lumiere series - 1/lumirere series - 1.png',
                    'notes' => 'Diantar kurir instan sebelum jam makan siang.',
                    'courier_name' => 'Kurir Express Maja',
                ]
            );

            OrderItem::firstOrCreate(
                [
                    'order_id' => $order1->id,
                    'product_id' => $buckflowProduct->id,
                ],
                [
                    'quantity' => 1,
                    'unit_price' => 185000,
                    'subtotal' => 185000,
                    'customization_notes' => 'Wrapping Sage Green Earth Tone & Pita Olive',
                ]
            );

            Order::updateOrCreate(
                ['tracking_code' => 'BF-202610-0002'],
                [
                    'customer_name' => 'Bima Arya',
                    'customer_phone' => '081398765432',
                    'status' => OrderStatusEnum::IN_PRODUCTION,
                    'payment_status' => 'paid',
                    'total_amount' => 245000,
                    'deadline_at' => now()->setTime(17, 30),
                    'production_started_at' => now()->subHours(1),
                    'greeting_card_message' => 'Happy 3rd Anniversary Clara tercinta! Terima kasih sudah selalu menjadi rumah ternyaman.',
                    'notes' => 'Apartemen Senopati Suites Tower 2 Unit 18B',
                ]
            );

            Order::updateOrCreate(
                ['tracking_code' => 'BF-202610-0003'],
                [
                    'customer_name' => 'Nadia Utami',
                    'customer_phone' => '081122334455',
                    'status' => OrderStatusEnum::COMPLETED,
                    'payment_status' => 'paid',
                    'total_amount' => 150000,
                    'deadline_at' => now()->subDay()->setTime(10, 0),
                    'production_started_at' => now()->subDay()->setTime(8, 0),
                    'ready_at' => now()->subDay()->setTime(9, 30),
                    'completed_at' => now()->subDay()->setTime(11, 20),
                    'greeting_card_message' => 'Selamat Ulang Tahun Ibu tercinta. Semoga sehat selalu dan penuh berkah.',
                    'notes' => 'Telah diterima di alamat Jl. Bumi Indah No. 45, Kebayoran Baru.',
                ]
            );

            Order::updateOrCreate(
                ['tracking_code' => 'BF-202610-0004'],
                [
                    'customer_name' => 'Dimas Anggara',
                    'customer_phone' => '089911223344',
                    'status' => OrderStatusEnum::READY,
                    'payment_status' => 'paid',
                    'total_amount' => 215000,
                    'deadline_at' => now()->setTime(15, 30),
                    'production_started_at' => now()->subHours(2),
                    'ready_at' => now()->subMinutes(10),
                    'greeting_card_message' => 'Happy Graduation Nabila sayang! Selamat melangkah ke masa depan.',
                    'qc_photo_path' => 'catalog-media/lumiere series - 2/lumirere series - 2.png',
                    'notes' => 'Ambil sendiri di Studio Maja (Self Pick-up)',
                ]
            );
        } catch (\Throwable $e) {
            // Soft fail if buckflow connection is unavailable during early migration/seed
        }

        // 5. Customer Stories / Testimoni Momen Bahagia
        $storiesData = [
            [
                'customer_name' => 'Clara & Rangga',
                'event_title' => 'Wisuda UI',
                'story' => 'Buket bunganya wangi sekali dan wrapping-nya sangat rapi! Fitur approval foto sebelum kirim benar-benar bikin tenang karena hasilnya persis seperti ekspektasi.',
                'image_path' => 'catalog-media/lumiere series - 1/lumirere series - 1.png',
                'rating' => 5,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'customer_name' => 'Kevin Pratama',
                'event_title' => 'Anniversary 4th',
                'story' => 'Pesan buket custom buat anniversary istri. Florist Maja ramah banget waktu konsultasi di WA, bahkan dibantu pilihin kartu ucapan beraksara puitis. Istri terharu!',
                'image_path' => 'catalog-media/lumiere series - 3/lumirere series - 3.png',
                'rating' => 5,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'customer_name' => 'Syifa Aulia',
                'event_title' => 'Graduation ITB',
                'story' => 'Sunflower bouquet-nya segar banget tahan hampir 8 hari di vas! Resi live tracking-nya juga informatif, kurir sameday tiba tepat waktu sebelum acara mulai.',
                'image_path' => 'catalog-media/tedy series - 1/Teddy bloom series - 1.png',
                'rating' => 5,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($storiesData as $story) {
            \App\Models\CustomerStory::updateOrCreate(
                ['customer_name' => $story['customer_name'], 'event_title' => $story['event_title']],
                $story
            );
        }

        // 6. Fresh Flowers Stock (Bunga Segar Ready Hari Ini)
        $freshFlowersData = [
            [
                'name' => 'Ecuadorian Rose "Cappuccino"',
                'botanical_name' => 'Rosa hybrida "Cappuccino"',
                'origin' => 'Ecuador Import (Andean Highland)',
                'color_name' => 'Vintage Nude Cappuccino',
                'color_hex' => '#C49A76',
                'stock_stems' => 14,
                'status' => 'ready',
                'price_per_stem' => 35000,
                'vase_life' => '7 - 10 Hari',
                'aroma_note' => 'Aroma lembut powdery floral',
                'description' => 'Mawar premium impor dengan gradasi warna nude cokelat-krem yang sangat elegan. Kelopak tebal berlapis dan mekar perlahan.',
                'image_path' => 'general/katalog - 7.png',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Casablanca White Lily',
                'botanical_name' => 'Lilium orientalis "Casablanca"',
                'origin' => 'Highland Lembang, Bandung',
                'color_name' => 'Pure Pristine White',
                'color_hex' => '#F8FAFC',
                'stock_stems' => 8,
                'status' => 'limited',
                'price_per_stem' => 45000,
                'vase_life' => '6 - 8 Hari',
                'aroma_note' => 'Wangi semerbak mewah oriental lily',
                'description' => 'Bunga lily putih bersih dengan aroma menenangkan dan kelopak mekar bintang yang sangat anggun untuk buket wisuda atau ungkapan tulus.',
                'image_path' => 'catalog-media/lumiere series - 1/lumirere series - 1.png',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Dutch Hydrangea "Sky Blue"',
                'botanical_name' => 'Hydrangea macrophylla',
                'origin' => 'Netherlands Import',
                'color_name' => 'Pastel Sky Blue',
                'color_hex' => '#7BAFD4',
                'stock_stems' => 5,
                'status' => 'limited',
                'price_per_stem' => 65000,
                'vase_life' => '5 - 7 Hari',
                'aroma_note' => 'Segar alami tanpa aroma tajam',
                'description' => 'Pancawarna kuncup mekar rimbun dengan diameter besar. Memberikan volume mewah dan aksen kelembutan warna langit.',
                'image_path' => 'catalog-media/lumiere series - 3/lumirere series - 3.png',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sunflower Sunrich "Summer Bloom"',
                'botanical_name' => 'Helianthus annuus "Sunrich"',
                'origin' => 'Batu, Malang Floriculture',
                'color_name' => 'Vivid Golden Sun',
                'color_hex' => '#F59E0B',
                'stock_stems' => 18,
                'status' => 'ready',
                'price_per_stem' => 25000,
                'vase_life' => '7 - 9 Hari',
                'aroma_note' => 'Segar herbal khas matahari',
                'description' => 'Bunga matahari varietas non-pollen yang tahan lama dan tidak mudah layu. Simbol keceriaan, semangat baru, dan kesuksesan wisuda.',
                'image_path' => 'catalog-media/tedy series - 1/Teddy bloom series - 1.png',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Baby\'s Breath "Snow White"',
                'botanical_name' => 'Gypsophila paniculata',
                'origin' => 'Cipanas Highland',
                'color_name' => 'Cloud Snow White',
                'color_hex' => '#F3F4F6',
                'stock_stems' => 22,
                'status' => 'ready',
                'price_per_stem' => 20000,
                'vase_life' => '8 - 12 Hari',
                'aroma_note' => 'Aroma ringan & manis lembut',
                'description' => 'Kumpulan kuntum mungil bagai salju musim semi. Sempurna sebagai filler mewah atau dirangkai penuh menjadi cloud bouquet.',
                'image_path' => 'catalog-media/tedy series - 2/Teddy bloom series - 2.png',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Crimson Holland Rose Super',
                'botanical_name' => 'Rosa hybrida "Red Naomi"',
                'origin' => 'Highland Lembang',
                'color_name' => 'Deep Velvet Crimson',
                'color_hex' => '#9F1239',
                'stock_stems' => 12,
                'status' => 'ready',
                'price_per_stem' => 30000,
                'vase_life' => '6 - 8 Hari',
                'aroma_note' => 'Wangi klasik mawar romantis',
                'description' => 'Mawar merah beludru berukuran besar dengan kelopak rapat simetris. Lambang cinta sejati tak lekang waktu.',
                'image_path' => 'catalog-media/tedy - rose big/Teddy bloom series - 2.png',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($freshFlowersData as $flower) {
            \App\Models\FreshFlower::updateOrCreate(
                ['name' => $flower['name']],
                $flower
            );
        }

        // 6. Dynamic Content: Site Settings, FAQs, & Flower Philosophies
        $this->call(DynamicContentSeeder::class);

        // 7. Digital Story & Wedding Invitation Showcase Data
        $this->call(DigitalStorySeeder::class);
    }
}
