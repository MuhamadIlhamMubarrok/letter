<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Enums;

enum StoryTemplateKey: string
{
    // ==========================================
    // SURAT CINTA & PESAN (LOVE LETTER) TEMPLATES
    // ==========================================
    case ONLINE_LOVE_LETTER = 'online_love_letter';     // Tema Lucu (Gemas 💌)
    case VINTAGE_ENVELOPE = 'vintage_envelope';         // Tema Klasik (Vintage Botanical 📜)
    case MIDNIGHT_ROSE = 'midnight_rose';               // Tema Elegan (Midnight Rose Luxury 🌹)
    case RETRO_POLAROID = 'retro_polaroid';             // Alternatif: Retro Scrapbook 🎞️
    case MINIMALIST_AESTHETIC = 'minimalist_aesthetic'; // Alternatif: Modern Pastel 🕊️

    // ==========================================
    // UNDANGAN PERNIKAHAN (WEDDING INVITATION) TEMPLATES
    // ==========================================
    case WEDDING_CUTE_PASTEL = 'wedding_cute_pastel';           // Tema Lucu (Pastel Romance 🌸)
    case WEDDING_CLASSIC_HERITAGE = 'wedding_classic_heritage'; // Tema Klasik (Heritage Botanical 📜)
    case WEDDING_ELEGANT_LUXURY = 'wedding_elegant_luxury';     // Tema Elegan (Royal Emerald & Gold ✨)
    case ONLINE_WEDDING = 'online_wedding';                     // Flagship Modern 💍

    /**
     * Resolves key safely, automatically mapping any legacy keys to active templates.
     */
    public static function tryFromWithLegacy(?string $key): ?self
    {
        if (! $key) {
            return null;
        }

        $direct = self::tryFrom($key);
        if ($direct) {
            return $direct;
        }

        // Backward compatibility for legacy keys
        return match ($key) {
            'royal_emerald' => self::WEDDING_ELEGANT_LUXURY,
            'rustic_garden' => self::WEDDING_CLASSIC_HERITAGE,
            'cute_wedding',
            'pastel_wedding' => self::WEDDING_CUTE_PASTEL,
            'editorial_chic',
            'batik_botanical' => self::ONLINE_WEDDING,
            default => null,
        };
    }

    /**
     * Get stylistic theme category for grouping (lucu, klasik, elegan).
     */
    public function themeStyle(): string
    {
        return match ($this) {
            self::ONLINE_LOVE_LETTER,
            self::WEDDING_CUTE_PASTEL => 'lucu',
            self::VINTAGE_ENVELOPE,
            self::WEDDING_CLASSIC_HERITAGE => 'klasik',
            self::MIDNIGHT_ROSE,
            self::WEDDING_ELEGANT_LUXURY => 'elegan',
            self::RETRO_POLAROID => 'retro',
            self::MINIMALIST_AESTHETIC,
            self::ONLINE_WEDDING => 'modern',
        };
    }

    /**
     * Human-readable label for theme category.
     */
    public function themeStyleLabel(): string
    {
        return match ($this->themeStyle()) {
            'lucu' => 'Tema Lucu',
            'klasik' => 'Tema Klasik',
            'elegan' => 'Tema Elegan',
            'retro' => 'Tema Retro',
            'modern' => 'Tema Modern',
            default => 'Tema Desain',
        };
    }

    public function title(): string
    {
        return match ($this) {
            self::ONLINE_LOVE_LETTER => 'Surat Cinta Lucu & Gemas (Playful Romance)',
            self::VINTAGE_ENVELOPE => 'Surat Klasik Vintage Botanical Envelope',
            self::MIDNIGHT_ROSE => 'Surat Elegan Midnight Rose Luxury',
            self::RETRO_POLAROID => 'Retro Polaroid Scrapbook',
            self::MINIMALIST_AESTHETIC => 'Modern Aesthetic Pastel',
            self::WEDDING_CUTE_PASTEL => 'Undangan Lucu & Pastel Romance',
            self::WEDDING_CLASSIC_HERITAGE => 'Undangan Klasik Heritage Botanical',
            self::WEDDING_ELEGANT_LUXURY => 'Undangan Elegan Royal Emerald & Gold',
            self::ONLINE_WEDDING => 'Undangan Pernikahan Online (Modern Flagship)',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::ONLINE_LOVE_LETTER => 'Surat cinta online interaktif & menggemaskan (Mobile-First 480px) dengan amplop segel hati berdetak, foto polaroid 3D flip rahasia, mini-game tombol kabur, 3 kupon cinta siap klaim, dan tombol peluk virtual.',
            self::VINTAGE_ENVELOPE => 'Amplop kertas kraft bertekstur klasik dengan stempel wax seal merah tua, ornamen botani dedaunan antik, tipografi serif tulisan tangan, love days counter romantis, dan pemutar musik vinyl klasik.',
            self::MIDNIGHT_ROSE => 'Nuansa botani malam mewah obsidian (#111711), tipografi serif emas mewah, kelopak bunga berjatuhan bercahaya lembut, glassmorphism frosted glass, dan alunan melodi romantis.',
            self::RETRO_POLAROID => 'Buku kenangan scrapbook penuh estetika retro, selotip washi tape, tumpukan foto polaroid miring, dan catatan tangan tulus.',
            self::MINIMALIST_AESTHETIC => 'Desain majalah modern Jepang & Skandinavia, tipografi bersih, layout kartu melayang, dan nuansa lembut menyejukkan.',
            self::WEDDING_CUTE_PASTEL => 'Undangan pernikahan ceria & manis berpalet soft pastel (strawberry milk & lavender cream), ilustrasi floral doodle gemas, pita interaktif buka undangan, love journey timeline, amplop digital kado 1-klik salin, dan buku tamu RSVP interaktif.',
            self::WEDDING_CLASSIC_HERITAGE => 'Undangan pernikahan agung bernuansa kertas perkamen antik, ornamen ukiran dedaunan botani klasik (Victorian filigree), stempel wax seal mewah, tipografi kaligrafi abadi (Cormorant Garamond), countdown jam saku kuno, dan buku tamu resmi berornamen emas.',
            self::WEDDING_ELEGANT_LUXURY => 'Undangan pernikahan modern haute-couture berlatar midnight obsidian emerald (#091510) dengan aksen kilau emas champagne (#D4AF37), tipografi serif mewah Cinzel, kartu frosted glassmorphism melayang, piringan musik emas berputar, amplop digital VIP, dan buku tamu doa restu eksklusif.',
            self::ONLINE_WEDDING => 'Undangan pernikahan modern Mobile-First (480px di tengah layar), interaksi buka undangan & putar lagu otomatis, amplop digital 1-klik salin, dan buku tamu RSVP interaktif.',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::ONLINE_LOVE_LETTER => 'Tema Lucu 💌',
            self::VINTAGE_ENVELOPE => 'Tema Klasik 📜',
            self::MIDNIGHT_ROSE => 'Tema Elegan 🌹',
            self::RETRO_POLAROID => 'Retro Scrapbook 🎞️',
            self::MINIMALIST_AESTHETIC => 'Clean Pastel 🕊️',
            self::WEDDING_CUTE_PASTEL => 'Tema Lucu 🌸',
            self::WEDDING_CLASSIC_HERITAGE => 'Tema Klasik 📜',
            self::WEDDING_ELEGANT_LUXURY => 'Tema Elegan ✨',
            self::ONLINE_WEDDING => 'Flagship Modern 💍',
        };
    }

    public function storyType(): StoryType
    {
        return match ($this) {
            self::ONLINE_LOVE_LETTER,
            self::VINTAGE_ENVELOPE,
            self::MIDNIGHT_ROSE,
            self::RETRO_POLAROID,
            self::MINIMALIST_AESTHETIC => StoryType::LOVE_LETTER,
            self::WEDDING_CUTE_PASTEL,
            self::WEDDING_CLASSIC_HERITAGE,
            self::WEDDING_ELEGANT_LUXURY,
            self::ONLINE_WEDDING => StoryType::WEDDING_INVITATION,
        };
    }

    public function previewBgColor(): string
    {
        return match ($this) {
            self::ONLINE_LOVE_LETTER => 'from-[#FFF5F7] via-[#FFE3E8] to-[#FFF5F7]',
            self::VINTAGE_ENVELOPE => 'from-[#FAF8E8] to-[#E3DC9E]',
            self::MIDNIGHT_ROSE => 'from-[#111711] via-[#1f1217] to-[#111711]',
            self::RETRO_POLAROID => 'from-[#F5EBE1] to-[#E5D2BF]',
            self::MINIMALIST_AESTHETIC => 'from-[#F7F9F6] to-[#E8EFE5]',
            self::WEDDING_CUTE_PASTEL => 'from-[#FFF0F5] via-[#FFE4E6] to-[#FFF5F7]',
            self::WEDDING_CLASSIC_HERITAGE => 'from-[#FAF6EE] via-[#F4EFE6] to-[#EFE8D8]',
            self::WEDDING_ELEGANT_LUXURY => 'from-[#091510] via-[#13221B] to-[#091510]',
            self::ONLINE_WEDDING => 'from-[#FAF7F2] via-[#F5EFE6] to-[#FAF7F2]',
        };
    }

    public function features(): array
    {
        return match ($this) {
            self::ONLINE_LOVE_LETTER => ['Amplop Segel Hati Berdetak', 'Polaroid 3D Flip Rahasia', 'Mini-Game Tombol Kabur', '3 Kupon Cinta Siap Klaim', 'Kirim Peluk Virtual & Audio'],
            self::VINTAGE_ENVELOPE => ['Amplop Kraft Klasik Interaktif', 'Stempel Wax Seal Merah', 'Love Days Counter', 'Polaroid Washi Tape', 'Vinyl Audio Melodi'],
            self::MIDNIGHT_ROSE => ['Dark Obsidian Luxury', 'Kelopak Mawar Glow', 'Frosted Glass Cards', 'Love Days Counter', 'Floating Music Player'],
            self::RETRO_POLAROID => ['Scrapbook Paper & Washi Tape', 'Polaroid Stack Lightbox', 'Cursive Typography', 'Vinyl Disc'],
            self::MINIMALIST_AESTHETIC => ['Minimalist Floating Card', 'Aesthetic Serif', 'Touch Friendly', 'Clean Audio Bar'],
            self::WEDDING_CUTE_PASTEL => ['Mobile-First Pastel 480px', 'Pita Interaktif Buka Undangan', 'Love Journey Timeline', 'Countdown Balon Ceria', 'BCA/Gopay Salin Cepat', 'Buku Tamu RSVP Lucu'],
            self::WEDDING_CLASSIC_HERITAGE => ['Parchment & Botanical Borders', 'Buka Undangan Stempel Wax Seal', 'Antique Clock Countdown', 'Google Maps & Calendar Rute', 'Tanda Kasih Kertas Antik', 'Buku Doa Restu Formal'],
            self::WEDDING_ELEGANT_LUXURY => ['Midnight Emerald & Gold Shimmer', 'Monogram Crest Buka Undangan', 'Spinning Gold Vinyl Player', 'Frosted Glass Cards', 'Rekening VIP 1-Klik Salin', 'Buku Tamu Doa Restu VIP'],
            self::ONLINE_WEDDING => ['480px Centered Mobile-First', 'Smooth Scroll & Buka Undangan', 'Vinyl Background Audio', 'Countdown & Google Calendar', 'BCA/Mandiri 1-Klik Salin', 'Live RSVP & Doa Restu'],
        };
    }

    public function viewPath(): string
    {
        return match ($this) {
            self::ONLINE_LOVE_LETTER => 'digital-story.templates.love-letter.online-love-letter',
            self::VINTAGE_ENVELOPE => 'digital-story.templates.love-letter.vintage-envelope',
            self::MIDNIGHT_ROSE => 'digital-story.templates.love-letter.midnight-rose',
            self::RETRO_POLAROID => 'digital-story.templates.love-letter.retro-polaroid',
            self::MINIMALIST_AESTHETIC => 'digital-story.templates.love-letter.minimalist-aesthetic',
            self::WEDDING_CUTE_PASTEL => 'digital-story.templates.wedding.cute-pastel',
            self::WEDDING_CLASSIC_HERITAGE => 'digital-story.templates.wedding.classic-heritage',
            self::WEDDING_ELEGANT_LUXURY => 'digital-story.templates.wedding.elegant-luxury',
            self::ONLINE_WEDDING => 'digital-story.templates.wedding.online-wedding',
        };
    }
}
