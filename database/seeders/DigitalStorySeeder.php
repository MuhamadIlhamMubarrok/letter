<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Enums\StoryStatus;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryTemplateTheme;
use App\Domains\DigitalStory\Enums\StoryType;
use App\Domains\DigitalStory\Models\DigitalStory;
use App\Domains\DigitalStory\Models\StoryRsvp;
use Illuminate\Database\Seeder;

class DigitalStorySeeder extends Seeder
{
    public function run(): void
    {
        $stories = [
            // 1. Love Letter - Vintage Envelope (Ready to print)
            [
                'order_code' => 'MF-202611-0001',
                'customer_phone' => '081234567890',
                'fulfillment_status' => StoryFulfillmentStatus::READY_TO_PRINT,
                'template_key' => StoryTemplateKey::VINTAGE_ENVELOPE,
                'slug' => 'nadin-anniversary-3rd',
                'story_type' => StoryType::LOVE_LETTER,
                'duration_plan' => StoryDurationPlan::ONE_YEAR,
                'status' => StoryStatus::ACTIVE,
                'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
                'title' => 'Untuk Nadin Tercinta di Hari Anniversary ke-3',
                'sender_name' => 'Reza Pratama',
                'recipient_name' => 'Nadin Amizah',
                'message' => "Terima kasih sudah menemani perjalananku selama 3 tahun ini. Setiap tawa, tangis, dan canda bersamamu adalah anugerah terindah. Buket mawar ini kurangkai khusus untukmu, dan surat ini akan tersimpan selamanya sebagai bukti cintaku padamu.",
                'event_date' => now()->subYears(3),
                'audio_title' => 'Kahitna - Cantik (Acoustic Cover)',
                'views_count' => 45,
                'notes' => 'Buket mawar merah premium 20 tangkai + cetak kartu buket A6',
                'expired_at' => now()->addYear(),
            ],

            // 2. Love Letter - Midnight Rose (Completed)
            [
                'order_code' => 'MF-202611-0002',
                'customer_phone' => '085712345678',
                'fulfillment_status' => StoryFulfillmentStatus::COMPLETED,
                'template_key' => StoryTemplateKey::MIDNIGHT_ROSE,
                'slug' => 'midnight-memories-clara',
                'story_type' => StoryType::LOVE_LETTER,
                'duration_plan' => StoryDurationPlan::SIX_MONTHS,
                'status' => StoryStatus::ACTIVE,
                'theme' => StoryTemplateTheme::MODERN_EMERALD,
                'title' => 'Midnight Memories with Clara',
                'sender_name' => 'Fajar Nugraha',
                'recipient_name' => 'Clara Sinta',
                'message' => "Di bawah gemerlap malam kota, kamu adalah bintang paling terang yang selalu menerangi langkahku. Selamat ulang tahun sayang, semoga semua mimpimu terwujud!",
                'event_date' => now()->subMonths(6),
                'audio_title' => 'Niki - Every Summertime',
                'views_count' => 128,
                'notes' => 'Buket hydrangea pastel + polaroid kenangan',
                'expired_at' => now()->addMonths(6),
            ],

            // 3. Love Letter - Retro Polaroid (Customer Review)
            [
                'order_code' => 'MF-202611-0003',
                'customer_phone' => '087811223344',
                'fulfillment_status' => StoryFulfillmentStatus::CUSTOMER_REVIEW,
                'template_key' => StoryTemplateKey::RETRO_POLAROID,
                'slug' => 'kisah-kasih-cinta-laura',
                'story_type' => StoryType::LOVE_LETTER,
                'duration_plan' => StoryDurationPlan::ONE_MONTH,
                'status' => StoryStatus::ACTIVE,
                'theme' => StoryTemplateTheme::RUSTIC_BOTANICAL,
                'title' => 'Kisah Kasih Kita Berdua',
                'sender_name' => 'Bagas Pamungkas',
                'recipient_name' => 'Cinta Laura',
                'message' => "Koleksi foto polaroid kenangan liburan kita di Bromo dan Bali. Setiap foto menyimpan ribuan kenangan manis yang takkan pernah pudar.",
                'event_date' => now()->subMonths(1),
                'audio_title' => 'Tulus - Teman Hidup',
                'views_count' => 19,
                'notes' => 'Sedang direview client via WhatsApp',
                'expired_at' => now()->addMonth(),
            ],

            // 4. Love Letter - Minimalist Aesthetic (Pending Content - follow up WA)
            [
                'order_code' => 'MF-202611-0004',
                'customer_phone' => '089912345678',
                'fulfillment_status' => StoryFulfillmentStatus::PENDING_CONTENT,
                'template_key' => StoryTemplateKey::MINIMALIST_AESTHETIC,
                'slug' => 'forever-valentine-dewi',
                'story_type' => StoryType::LOVE_LETTER,
                'duration_plan' => StoryDurationPlan::SIX_MONTHS,
                'status' => StoryStatus::ACTIVE,
                'theme' => StoryTemplateTheme::CLASSIC_GOLD,
                'title' => 'My Forever Valentine',
                'sender_name' => 'Aldi Taher',
                'recipient_name' => 'Dewi Perssik',
                'message' => "Menunggu materi tulisan puisi cinta dan foto kenangan dari pemesan buket.",
                'event_date' => now(),
                'audio_title' => 'Yovie & Nuno - Janji Suci',
                'views_count' => 5,
                'notes' => 'Florist perlu follow up materi via WhatsApp',
                'expired_at' => now()->addMonths(6),
            ],

            // 5. Wedding - Online Wedding Flagship (Ready to Print)
            [
                'order_code' => 'MF-202611-0005',
                'customer_phone' => '081399887766',
                'fulfillment_status' => StoryFulfillmentStatus::READY_TO_PRINT,
                'template_key' => StoryTemplateKey::ONLINE_WEDDING,
                'slug' => 'wedding-sarah-dimas',
                'story_type' => StoryType::WEDDING_INVITATION,
                'duration_plan' => StoryDurationPlan::LIFETIME,
                'status' => StoryStatus::ACTIVE,
                'theme' => StoryTemplateTheme::MODERN_EMERALD,
                'title' => 'The Wedding Celebration of Sarah & Dimas',
                'sender_name' => 'Dimas & Sarah',
                'recipient_name' => 'Tamu Undangan Terhormat',
                'message' => "Dengan penuh rasa syukur kepada Tuhan Yang Maha Esa, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari bahagia pernikahan kami.",
                'event_date' => now()->addWeeks(3),
                'audio_title' => 'Pachelbel - Canon in D Major',
                'views_count' => 312,
                'notes' => 'Cetak 100 kartu standee QR meja tamu & kartu buket mahar',
                'expired_at' => null,
                'metadata' => [
                    'venue_name' => 'Grand Ballroom Hotel Mulia Senayan',
                    'maps_url' => 'https://maps.google.com/?q=Hotel+Mulia+Senayan',
                    'venue_address' => 'Jl. Asia Afrika No. 6, Gelora, Tanah Abang, Jakarta Pusat',
                    'ceremony_time' => '08.00 - 10.00 WIB (Akad Nikah)',
                    'reception_time' => '11.00 - 14.00 WIB (Resepsi Pernikahan)',
                ],
            ],

            // 6. Wedding - Online Wedding Flagship (Drafting)
            [
                'order_code' => 'MF-202611-0006',
                'customer_phone' => '082155443322',
                'fulfillment_status' => StoryFulfillmentStatus::DRAFTING,
                'template_key' => StoryTemplateKey::ONLINE_WEDDING,
                'slug' => 'wedding-anisa-bagas',
                'story_type' => StoryType::WEDDING_INVITATION,
                'duration_plan' => StoryDurationPlan::ONE_YEAR,
                'status' => StoryStatus::ACTIVE,
                'theme' => StoryTemplateTheme::RUSTIC_BOTANICAL,
                'title' => 'The Wedding of Anisa & Bagas',
                'sender_name' => 'Bagas & Anisa',
                'recipient_name' => 'Keluarga & Sahabat',
                'message' => "Momen suci mengikat janji sehidup semati dalam kehangatan taman botanical bernuansa alam terbuka. Kehadiran Anda adalah doa restu terindah.",
                'event_date' => now()->addMonths(2),
                'audio_title' => 'Shane Filan - Beautiful in White',
                'views_count' => 64,
                'notes' => 'Sedang tahap layout konten & susunan acara',
                'expired_at' => now()->addYear(),
                'metadata' => [
                    'venue_name' => 'Plataran Cilandak Garden',
                    'maps_url' => 'https://maps.google.com/?q=Plataran+Cilandak',
                    'venue_address' => 'Jl. Durian No. 26, Jagakarsa, Jakarta Selatan',
                    'ceremony_time' => '15.30 - 17.00 WIB (Akad)',
                    'reception_time' => '18.30 - 21.00 WIB (Sunset Garden Party)',
                ],
            ],

            // 7. Wedding - Online Wedding Flagship (Completed)
            [
                'order_code' => 'MF-202611-0007',
                'customer_phone' => '081299112233',
                'fulfillment_status' => StoryFulfillmentStatus::COMPLETED,
                'template_key' => StoryTemplateKey::ONLINE_WEDDING,
                'slug' => 'wedding-vania-kevin',
                'story_type' => StoryType::WEDDING_INVITATION,
                'duration_plan' => StoryDurationPlan::LIFETIME,
                'status' => StoryStatus::ACTIVE,
                'theme' => StoryTemplateTheme::CLASSIC_GOLD,
                'title' => 'The Wedding Celebration: Vania & Kevin',
                'sender_name' => 'Kevin & Vania',
                'recipient_name' => 'Segenap Tamu Undangan',
                'message' => "Modern, bold, timeless elegance. Kami mengundang Anda menjadi saksi lembaran baru perjalanan cinta kami.",
                'event_date' => now()->addMonth(),
                'audio_title' => 'Elvis Presley - Can\'t Help Falling in Love (Acoustic)',
                'views_count' => 480,
                'notes' => 'Selesai diproduksi, link live dan QR card sudah diserahkan ke client',
                'expired_at' => null,
                'metadata' => [
                    'venue_name' => 'Glasshouse at Fairmont Jakarta',
                    'maps_url' => 'https://maps.google.com/?q=Fairmont+Jakarta',
                    'venue_address' => 'Jl. Asia Afrika No. 8, Gelora Bung Karno, Jakarta Pusat',
                    'ceremony_time' => '10.00 - 11.30 WIB (Pemberkatan)',
                    'reception_time' => '18.00 - 21.30 WIB (Gala Dinner)',
                ],
            ],

            // 8. Wedding - Online Wedding Flagship (Customer Review)
            [
                'order_code' => 'MF-202611-0008',
                'customer_phone' => '087788990011',
                'fulfillment_status' => StoryFulfillmentStatus::CUSTOMER_REVIEW,
                'template_key' => StoryTemplateKey::ONLINE_WEDDING,
                'slug' => 'pawiwahan-sekar-danang',
                'story_type' => StoryType::WEDDING_INVITATION,
                'duration_plan' => StoryDurationPlan::ONE_YEAR,
                'status' => StoryStatus::ACTIVE,
                'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
                'title' => 'Pawiwahan Ageng: Raden Ayu Sekar & Danang',
                'sender_name' => 'Danang & Sekar',
                'recipient_name' => 'Para Pinisepuh & Kerabat',
                'message' => "Nyuwun donga pangestu dhumateng Bapak/Ibu/Sedherek sedaya mugi lampahing pawiwahan lumampah kanthi wilujeng lan tansah pinaringan kabagyan lahir lan batin.",
                'event_date' => now()->addWeeks(5),
                'audio_title' => 'Gamelan Jawa Klasik - Kebo Giro',
                'views_count' => 95,
                'notes' => 'Menunggu persetujuan client untuk ejaan nama keluarga',
                'expired_at' => now()->addYear(),
                'metadata' => [
                    'venue_name' => 'Pendopo Dalem Ngabean',
                    'maps_url' => 'https://maps.google.com/?q=Dalem+Ngabean+Yogyakarta',
                    'venue_address' => 'Jl. Magelang KM 4.5, Sinduadi, Mlati, Sleman, Yogyakarta',
                    'ceremony_time' => '08.00 - 10.00 WIB (Ijab Qobul)',
                    'reception_time' => '11.00 - 13.30 WIB (Resepsi Adat Jawa)',
                ],
            ],
        ];

        foreach ($stories as $storyData) {
            $story = DigitalStory::updateOrCreate(
                ['slug' => $storyData['slug']],
                $storyData
            );

            // Seed sample RSVPs for wedding stories
            if ($story->story_type === StoryType::WEDDING_INVITATION) {
                $sampleRsvps = [
                    [
                        'guest_name' => 'dr. Hendra Kusuma',
                        'attendance_status' => 'attending',
                        'guest_count' => 2,
                        'wishes' => 'Selamat untuk kedua mempelai! Semoga menjadi keluarga yang sakinah, mawaddah, warahmah.',
                    ],
                    [
                        'guest_name' => 'Rina Wijaya, S.E.',
                        'attendance_status' => 'attending',
                        'guest_count' => 1,
                        'wishes' => 'Happy wedding guys! Lancar sampai hari H yaa.',
                    ],
                    [
                        'guest_name' => 'Bambang Soedjarwo',
                        'attendance_status' => 'declined',
                        'guest_count' => 0,
                        'wishes' => 'Mohon maaf belum bisa hadir karena sedang dinas luar kota. Doa terbaik untuk kalian berdua.',
                    ],
                ];

                foreach ($sampleRsvps as $rsvp) {
                    StoryRsvp::firstOrCreate(
                        [
                            'digital_story_id' => $story->id,
                            'guest_name' => $rsvp['guest_name'],
                        ],
                        $rsvp
                    );
                }
            }
        }
    }
}
