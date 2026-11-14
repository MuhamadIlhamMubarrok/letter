<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Templates;

use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Enums\StoryStatus;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryTemplateTheme;
use App\Domains\DigitalStory\Enums\StoryType;
use App\Domains\DigitalStory\Models\DigitalStory;
use App\Domains\DigitalStory\Models\StoryMedia;
use App\Domains\DigitalStory\Models\StoryRsvp;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StoryTemplateRegistry
{
    /**
     * Retrieve all available story templates.
     *
     * @return Collection<int, StoryTemplateKey>
     */
    public function all(): Collection
    {
        return collect(StoryTemplateKey::cases());
    }

    /**
     * Retrieve templates for a specific story type.
     *
     * @param StoryType $type
     * @return Collection<int, StoryTemplateKey>
     */
    public function forType(StoryType $type): Collection
    {
        return $this->all()->filter(fn (StoryTemplateKey $t) => $t->storyType() === $type)->values();
    }

    /**
     * Resolve default template for a story type.
     */
    public function defaultForType(StoryType $type): StoryTemplateKey
    {
        return match ($type) {
            StoryType::LOVE_LETTER => StoryTemplateKey::ONLINE_LOVE_LETTER,
            StoryType::WEDDING_INVITATION => StoryTemplateKey::ONLINE_WEDDING,
        };
    }

    /**
     * Find a template by key string safely with fallback.
     */
    public function find(?string $key, ?StoryType $fallbackType = null): StoryTemplateKey
    {
        if ($key) {
            $matched = StoryTemplateKey::tryFromWithLegacy($key);
            if ($matched) {
                return $matched;
            }
        }

        return $this->defaultForType($fallbackType ?? StoryType::LOVE_LETTER);
    }

    /**
     * Create an interactive demo story instance with rich, realistic content for client showcasing.
     */
    public function makeDemoStory(StoryTemplateKey $template): DigitalStory
    {
        $isWedding = $template->storyType() === StoryType::WEDDING_INVITATION;

        $story = new DigitalStory();
        $story->id = 999999;
        $story->slug = 'demo-' . $template->value;
        $story->story_type = $template->storyType();
        $story->template_key = $template;
        $story->status = StoryStatus::ACTIVE;
        $story->duration_plan = StoryDurationPlan::LIFETIME;
        $story->order_code = 'MF-DEMO-' . strtoupper(substr(str_replace('_', '', $template->value), 0, 4));
        $story->customer_phone = '081234567890';
        $story->views_count = 342;
        $story->fulfillment_status = StoryFulfillmentStatus::COMPLETED;
        $story->created_at = Carbon::now()->subDays(14);
        $story->expired_at = null;

        if ($isWedding) {
            $isCute = $template === StoryTemplateKey::WEDDING_CUTE_PASTEL;
            $isClassic = $template === StoryTemplateKey::WEDDING_CLASSIC_HERITAGE;
            $isLuxury = $template === StoryTemplateKey::WEDDING_ELEGANT_LUXURY;

            if ($isCute) {
                $story->title = 'The Wedding of Daffa & Caca 💕';
                $story->sender_name = 'Keluarga Bpk. Bambang & Ibu Nur';
                $story->recipient_name = 'Teman-teman & Sahabat Tercinta';
                $story->theme = StoryTemplateTheme::ROMANTIC_ROSE;
                $story->audio_path = 'https://assets.mixkit.co/music/preview/mixkit-romantic-moment-1144.mp3';
                $story->audio_title = 'Sweet Pastel Romance (Acoustic Joy)';
                $story->metadata = [
                    'groom_nickname' => 'Daffa',
                    'bride_nickname' => 'Caca',
                    'groom_full_name' => 'Daffa Ramadhan, S.T.',
                    'groom_parents' => 'Putra bungsu dari Bpk. Bambang Tri & Ibu Nurhayati',
                    'groom_instagram' => '@daffarmdhn',
                    'groom_bio' => 'Pencinta kopi, humor receh, dan sosok paling sabar yang siap menemani setiap langkah Caca.',
                    'bride_full_name' => 'Clarissa Putri, S.I.Kom.',
                    'bride_parents' => 'Putri pertama dari Bpk. Rudi Hartono & Ibu Dewi Anggraeni',
                    'bride_instagram' => '@clarissaptr',
                    'bride_bio' => 'Pecinta bunga pastel, pencipta keceriaan, dan alasan utama Daffa selalu tersenyum setiap hari.',
                    'ceremony_time' => 'Akad Nikah: 08.00 - 10.00 WIB',
                    'reception_time' => 'Resepsi Ceria: 11.00 - 14.00 WIB',
                    'venue_name' => 'Garden Glasshouse Pastel Maja',
                    'venue_address' => 'Jl. Anggrek Ceria No. 12, Kebayoran Baru, Jakarta Selatan',
                    'maps_url' => 'https://maps.google.com/?q=Jakarta',
                ];
            } elseif ($isClassic) {
                $story->title = 'The Wedding of Raden Arya & Dyah Ayu 📜';
                $story->sender_name = 'Keluarga Bpk. Ir. H. Bambang Kusuma & Ibu Hj. Ratna Sari';
                $story->recipient_name = 'Tamu Undangan Yang Terhormat';
                $story->theme = StoryTemplateTheme::RUSTIC_BOTANICAL;
                $story->audio_path = 'https://assets.mixkit.co/music/preview/mixkit-wedding-acoustic-guitar-384.mp3';
                $story->audio_title = 'Canon in D (Classical Heritage Strings)';
                $story->metadata = [
                    'groom_nickname' => 'Arya',
                    'bride_nickname' => 'Dyah',
                    'groom_full_name' => 'Raden Arya Kusuma, S.H.',
                    'groom_parents' => 'Putra pertama dari Bpk. Ir. H. Bambang Kusuma & Ibu Hj. Ratna Sari',
                    'groom_instagram' => '@aryakusuma',
                    'groom_bio' => 'Pribadi bersahaja, pelindung keluarga, dan sosok pemimpin bijaksana.',
                    'bride_full_name' => 'Dyah Sekar Ayu, S.Psi.',
                    'bride_parents' => 'Putri bungsu dari Bpk. H. Suryo Pranoto & Ibu Hj. Siti Rohmah',
                    'bride_instagram' => '@dyahayusekar',
                    'bride_bio' => 'Lemah lembut, anggun, dan senantiasa menyejukkan hati di setiap suasana.',
                    'ceremony_time' => 'Akad Nikah Khidmat: 08.30 - 10.30 WIB',
                    'reception_time' => 'Syukuran Resepsi: 11.30 - 15.00 WIB',
                    'venue_name' => 'Pendopo Heritage Grand Ballroom Maja',
                    'venue_address' => 'Jl. Cendana Asri No. 8, Kebayoran Baru, Jakarta Selatan',
                    'maps_url' => 'https://maps.google.com/?q=Jakarta',
                ];
            } elseif ($isLuxury) {
                $story->title = 'The Royal Wedding of Leonardo & Kimberly ✨';
                $story->sender_name = 'Keluarga Bpk. William Adisurya & Ibu Jessica Widjaja';
                $story->recipient_name = 'Distinguished VIP Guests';
                $story->theme = StoryTemplateTheme::MODERN_EMERALD;
                $story->audio_path = 'https://assets.mixkit.co/music/preview/mixkit-wedding-acoustic-guitar-384.mp3';
                $story->audio_title = 'Grand Nocturne in Gold (Royal Piano)';
                $story->metadata = [
                    'groom_nickname' => 'Leo',
                    'bride_nickname' => 'Kim',
                    'groom_full_name' => 'Leonardo Adisurya, B.B.A.',
                    'groom_parents' => 'Putra pertama dari Bpk. William Adisurya & Ibu Jessica Widjaja',
                    'groom_instagram' => '@leonardo.adisurya',
                    'groom_bio' => 'Visionary leader, world traveler, and fiercely devoted to Kimberly.',
                    'bride_full_name' => 'Kimberly Anastasia, B.Des.',
                    'bride_parents' => 'Putri tunggal dari Bpk. Alexander Tan & Ibu Michelle Kusuma',
                    'bride_instagram' => '@kimberly.anastasia',
                    'bride_bio' => 'Art director, graceful soul, and the golden light of Leonardo’s universe.',
                    'ceremony_time' => 'The Holy Matrimony: 09.00 - 11.00 WIB',
                    'reception_time' => 'The Royal Gala Dinner: 18.30 - 22.00 WIB',
                    'venue_name' => 'The Emerald Grand Ballroom & Glasshouse Maja',
                    'venue_address' => 'Jl. Jenderal Sudirman Kav. 52-53, SCBD, Jakarta Selatan',
                    'maps_url' => 'https://maps.google.com/?q=Jakarta',
                ];
            } else {
                $story->title = 'The Wedding of Adinda & Rian';
                $story->sender_name = 'Keluarga Bpk. Hendra & Ibu Sinta';
                $story->recipient_name = 'Tamu Undangan Yang Berbahagia';
                $story->theme = StoryTemplateTheme::MODERN_EMERALD;
                $story->audio_path = 'https://assets.mixkit.co/music/preview/mixkit-wedding-acoustic-guitar-384.mp3';
                $story->audio_title = 'Canon in D (Acoustic Guitar Romance)';
                $story->metadata = [
                    'groom_nickname' => 'Rian',
                    'bride_nickname' => 'Adinda',
                    'groom_full_name' => 'Rian Pratama, S.Kom.',
                    'groom_parents' => 'Putra pertama dari Bpk. Hendra Wijaya & Ibu Sinta Dewi',
                    'groom_instagram' => '@rianpratama',
                    'bride_full_name' => 'Adinda Kirana, S.Ds.',
                    'bride_parents' => 'Putri kedua dari Bpk. Bambang Surya & Ibu Ratna Sari',
                    'bride_instagram' => '@adindakrn',
                    'ceremony_time' => 'Akad Nikah: 08.00 - 10.00 WIB',
                    'reception_time' => 'Resepsi: 11.00 - 14.00 WIB',
                    'venue_name' => 'Grand Glasshouse Ballroom Maja',
                    'venue_address' => 'Jl. Melati Putih No. 28, Kebayoran Baru, Jakarta Selatan',
                    'maps_url' => 'https://maps.google.com/?q=Jakarta',
                ];
            }
            $story->event_date = Carbon::now()->addDays(28)->setHour(9)->setMinute(0)->setSecond(0);
            $story->message = "Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan. Dengan penuh rasa syukur dan cinta kasih, kami bermaksud menyelenggarakan syukuran pernikahan putra-putri kami.\n\nMerupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai.\n\nAtas kehadiran dan doa tulus Bapak/Ibu sekalian, kami sekeluarga mengucapkan terima kasih yang sebesar-besarnya.";

            // Realistic Wedding Pre-wedding Polaroid Media
            $media1 = new StoryMedia([
                'file_path' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
                'file_name' => 'prewed-1.jpg',
                'mime_type' => 'image/jpeg',
                'caption' => 'The Beginning of Our Forever',
                'sort_order' => 1,
            ]);
            $media2 = new StoryMedia([
                'file_path' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
                'file_name' => 'prewed-2.jpg',
                'mime_type' => 'image/jpeg',
                'caption' => 'Dua Hati, Satu Janji Suci',
                'sort_order' => 2,
            ]);
            $media3 = new StoryMedia([
                'file_path' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=800&q=80',
                'file_name' => 'prewed-3.jpg',
                'mime_type' => 'image/jpeg',
                'caption' => 'Melangkah Bersama Menuju Hari Bahagia',
                'sort_order' => 3,
            ]);
            $story->setRelation('media', collect([$media1, $media2, $media3]));

            // Sample Guest Wishes (RSVP)
            $rsvp1 = new StoryRsvp([
                'guest_name' => 'Dimas & Sarah',
                'attendance_status' => 'attending',
                'guest_count' => 2,
                'wishes' => 'Selamat menempuh hidup baru Rian & Dinda! Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Aamiin!',
            ]);
            $rsvp1->created_at = Carbon::now()->subHours(4);

            $rsvp2 = new StoryRsvp([
                'guest_name' => 'Tante Maya & Keluarga',
                'attendance_status' => 'attending',
                'guest_count' => 3,
                'wishes' => 'Barakallahu lakuma wa baraka alaikuma! Selamat ya anak-anakku tersayang. Sangat bangga dan bahagia melihat kalian berdua.',
            ]);
            $rsvp2->created_at = Carbon::now()->subDays(1);

            $rsvp3 = new StoryRsvp([
                'guest_name' => 'Budi Santoso (Sahabat Kuliah)',
                'attendance_status' => 'attending',
                'guest_count' => 1,
                'wishes' => 'Lancar sampai hari H bro Rian! Doa terbaik untuk kalian berdua, kami pasti datang!',
            ]);
            $rsvp3->created_at = Carbon::now()->subDays(2);
            $story->setRelation('rsvps', collect([$rsvp1, $rsvp2, $rsvp3]));

        } else {
            $story->title = 'Kisah Indah Dua Hati';
            $story->sender_name = 'Rian Pratama';
            $story->recipient_name = 'Adinda Kirana';
            $story->theme = StoryTemplateTheme::ROMANTIC_ROSE;
            // 2 Years, 4 Months, 18 Days ago for the love counter demo
            $story->event_date = Carbon::now()->subYears(2)->subMonths(4)->subDays(18);
            $story->audio_path = 'https://assets.mixkit.co/music/preview/mixkit-romantic-moment-1144.mp3';
            $story->audio_title = 'Acoustic Melody of Love';
            $story->message = "Sayangku Adinda,\n\nTerima kasih telah selalu menjadi alasan di balik setiap senyumanku dan tempat ternyaman untuk pulang di setiap lelahku.\n\nBuket bunga ini mungkin kelak akan mengering, tetapi rasa kagum, kasih sayang, dan komitmenku padamu akan selalu mekar dan bertumbuh setiap hari.\n\nTerima kasih untuk setiap tawa, obrolan larut malam, dan kehangatan yang kamu hadirkan dalam hidupku. Selamat hari jadian kita yang istimewa. Aku mencintaimu, kemarin, hari ini, dan selamanya.";

            // Romantic Polaroid Media
            $media1 = new StoryMedia([
                'file_path' => 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=800&q=80',
                'file_name' => 'polaroid-1.jpg',
                'mime_type' => 'image/jpeg',
                'caption' => 'Kencan Pertama di Taman Bunga',
                'sort_order' => 1,
            ]);
            $media2 = new StoryMedia([
                'file_path' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80',
                'file_name' => 'polaroid-2.jpg',
                'mime_type' => 'image/jpeg',
                'caption' => 'Senja Terbaik Bersamamu',
                'sort_order' => 2,
            ]);
            $media3 = new StoryMedia([
                'file_path' => 'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?auto=format&fit=crop&w=800&q=80',
                'file_name' => 'polaroid-3.jpg',
                'mime_type' => 'image/jpeg',
                'caption' => 'Senyummu Selalu Jadi Favoritku',
                'sort_order' => 3,
            ]);
            $story->setRelation('media', collect([$media1, $media2, $media3]));
            $story->setRelation('rsvps', collect([]));
        }

        return $story;
    }
}
