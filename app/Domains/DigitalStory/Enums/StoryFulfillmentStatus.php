<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Enums;

use App\Domains\DigitalStory\Models\DigitalStory;

enum StoryFulfillmentStatus: string
{
    case PENDING_CONTENT = 'pending_content';
    case DRAFTING = 'drafting';
    case CUSTOMER_REVIEW = 'customer_review';
    case READY_TO_PRINT = 'ready_to_print';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_CONTENT => 'Perlu Konten Pemesan',
            self::DRAFTING => 'Penyusunan di CMS',
            self::CUSTOMER_REVIEW => 'Review Pemesan',
            self::READY_TO_PRINT => 'Siap Cetak QR Buket',
            self::COMPLETED => 'Selesai & Aktif',
        };
    }

    public function labelForStory(?DigitalStory $story = null): string
    {
        if ($story && $story->story_type === StoryType::WEDDING_INVITATION) {
            return match ($this) {
                self::PENDING_CONTENT => 'Perlu Data Mempelai',
                self::DRAFTING => 'Penyusunan Undangan',
                self::CUSTOMER_REVIEW => 'Review Mempelai',
                self::READY_TO_PRINT => 'Siap Disebarkan (Link Aktif)',
                self::COMPLETED => 'Selesai & Aktif',
            };
        }

        return $this->label();
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING_CONTENT => '⏳',
            self::DRAFTING => '✍️',
            self::CUSTOMER_REVIEW => '👀',
            self::READY_TO_PRINT => '🖨️',
            self::COMPLETED => '✅',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING_CONTENT => 'bg-brand-amber/15 text-brand-amber border-brand-amber/30',
            self::DRAFTING => 'bg-brand-indigo/15 text-brand-indigo border-brand-indigo/30',
            self::CUSTOMER_REVIEW => 'bg-secondary/20 text-secondary-dark border-secondary/30',
            self::READY_TO_PRINT => 'bg-primary/20 text-primary border-primary/30 font-bold',
            self::COMPLETED => 'bg-brand-emerald/15 text-accent border-accent/30',
        };
    }

    /**
     * Generate WhatsApp quick follow-up message for florist staff.
     */
    public function generateWaMessage(DigitalStory $story): string
    {
        $orderCode = $story->order_code ? " ({$story->order_code})" : '';
        $typeLabel = $story->story_type->label();
        $isWedding = $story->story_type === StoryType::WEDDING_INVITATION;

        return match ($this) {
            self::PENDING_CONTENT => urlencode(
                $isWedding
                    ? "Halo Kak {$story->sender_name}, terima kasih telah memesan Undangan Pernikahan Online di Maja Flower{$orderCode}! 💍\n\n" .
                      "Untuk melengkapi informasi undangan pernikahan online Kakak, mohon bantu lengkapi data berikut ya:\n" .
                      "1. Nama Lengkap & Panggilan Kedua Mempelai:\n" .
                      "2. Nama Orang Tua Kedua Mempelai:\n" .
                      "3. Waktu & Lokasi Akad Nikah:\n" .
                      "4. Waktu & Lokasi Resepsi (beserta link Google Maps):\n" .
                      "5. Nomor Rekening / Alamat Pengiriman Kado:\n" .
                      "6. Foto Pre-wedding (Galeri Foto):\n" .
                      "7. Lagu Latar Favorit:\n\n" .
                      "Tim kami akan segera menyiapkan undangan online interaktif Kakak. Terima kasih! ✨"
                    : "Halo Kak {$story->sender_name}, terima kasih telah memesan buket di Maja Flower{$orderCode}! 🌸\n\n" .
                      "Untuk pembuatan {$typeLabel} pada kartu buket Kakak, mohon bantu lengkapi data berikut ya:\n" .
                      "1. Nama Penerima: {$story->recipient_name}\n" .
                      "2. Pesan Cinta / Surat Kenangan:\n" .
                      "3. Tanggal Spesial (Jadian/Anniversary/Akad):\n" .
                      "4. Foto kenangan (Maksimal 12 foto)\n" .
                      "5. Judul lagu kenangan favorit:\n\n" .
                      "Tim florist kami akan segera menyusun kartu digital terbaik untuk orang tersayang Kakak. Terima kasih! ✨"
            ),
            self::CUSTOMER_REVIEW => urlencode(
                $isWedding
                    ? "Halo Kak {$story->sender_name}! 💍\n\n" .
                      "Undangan Pernikahan Online Kakak sudah selesai kami siapkan di sistem Maja Flower.\n\n" .
                      "Silakan cek pratinjau tampilannya di smartphone melalui link berikut:\n" .
                      "👉 {$story->public_url}\n\n" .
                      "Apakah susunan nama mempelai, tanggal acara, rute lokasi maps, atau musiknya sudah sesuai? Mohon kabari ya Kak. Terima kasih! ✨"
                    : "Halo Kak {$story->sender_name}! 💌\n\n" .
                      "Surat digital untuk buket Kakak sudah selesai kami susun di sistem CMS Maja Flower.\n\n" .
                      "Silakan cek pratinjaunya terlebih dahulu sebelum kami cetak kartu fisiknya:\n" .
                      "👉 {$story->public_url}\n\n" .
                      "Apakah sudah sesuai atau ada foto/tulisan yang ingin dikoreksi? Mohon kabari ya Kak. Terima kasih! 🌸"
            ),
            self::READY_TO_PRINT, self::COMPLETED => urlencode(
                $isWedding
                    ? "Halo Kak {$story->sender_name}! 💍✨\n\n" .
                      "Undangan Pernikahan Online Kakak kini SUDAH AKTIF dan siap dibagikan ke seluruh tamu undangan!\n\n" .
                      "Link Utama Undangan:\n" .
                      "👉 {$story->public_url}\n\n" .
                      "💡 Tips: Cukup bagikan link langsung via WhatsApp ke para tamu undangan (tanpa barcode). Kakak juga bisa menggunakan Generator Tamu kami untuk membuat link personal untuk tiap tamu secara masal.\n\n" .
                      "Selamat atas pernikahannya dan semoga seluruh acara berjalan lancar & penuh berkah! 🌿"
                    : "Halo Kak {$story->sender_name}! ✨\n\n" .
                      "Kartu QR Code {$typeLabel} untuk buket Kakak sudah selesai dicetak dan disematkan cantik pada rangkaian bunga.\n\n" .
                      "Penerima dapat langsung memindai QR Code untuk membuka kenangan digital ini:\n" .
                      "👉 {$story->public_url}\n\n" .
                      "Terima kasih telah mempercayakan momen berharga Anda bersama Maja Flower! 🌿"
            ),
            default => '',
        };
    }
}
