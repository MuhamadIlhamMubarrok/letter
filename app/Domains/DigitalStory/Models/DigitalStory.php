<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Models;

use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Enums\StoryStatus;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryTemplateTheme;
use App\Domains\DigitalStory\Enums\StoryType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DigitalStory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'digital_stories';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'order_code',
        'customer_phone',
        'fulfillment_status',
        'template_key',
        'slug',
        'story_type',
        'duration_plan',
        'status',
        'theme',
        'title',
        'sender_name',
        'recipient_name',
        'message',
        'event_date',
        'audio_path',
        'audio_title',
        'qr_code_path',
        'views_count',
        'expired_at',
        'notes',
        'metadata',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'story_type' => StoryType::class,
        'duration_plan' => StoryDurationPlan::class,
        'status' => StoryStatus::class,
        'fulfillment_status' => StoryFulfillmentStatus::class,
        'template_key' => StoryTemplateKey::class,
        'theme' => StoryTemplateTheme::class,
        'event_date' => 'datetime',
        'expired_at' => 'datetime',
        'metadata' => 'array',
        'views_count' => 'integer',
    ];

    /**
     * Media relations (Polaroid photos).
     *
     * @return HasMany<StoryMedia, $this>
     */
    public function media(): HasMany
    {
        return $this->hasMany(StoryMedia::class, 'digital_story_id')->orderBy('sort_order', 'asc');
    }

    /**
     * RSVP relations (for wedding invitations).
     *
     * @return HasMany<StoryRsvp, $this>
     */
    public function rsvps(): HasMany
    {
        return $this->hasMany(StoryRsvp::class, 'digital_story_id')->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope only active stories whose duration has not expired.
     *
     * @param Builder<DigitalStory> $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', StoryStatus::ACTIVE->value)
            ->where(function (Builder $q): void {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', Carbon::now());
            });
    }

    /**
     * Scope expired stories.
     *
     * @param Builder<DigitalStory> $query
     */
    public function scopeExpired(Builder $query): void
    {
        $query->where(function (Builder $q): void {
            $q->where('status', StoryStatus::EXPIRED->value)
                ->orWhere(function (Builder $sub): void {
                    $sub->whereNotNull('expired_at')
                        ->where('expired_at', '<=', Carbon::now());
                });
        });
    }

    /**
     * Scope by story type.
     *
     * @param Builder<DigitalStory> $query
     */
    public function scopeType(Builder $query, StoryType|string $type): void
    {
        $value = $type instanceof StoryType ? $type->value : $type;
        $query->where('story_type', $value);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get the public URL for scanning.
     */
    public function getPublicUrlAttribute(): string
    {
        return route('story.public.show', ['slug' => $this->slug]);
    }

    /**
     * Get public URL for QR Code SVG asset.
     */
    public function getQrCodeUrlAttribute(): ?string
    {
        if (! $this->qr_code_path) {
            return null;
        }

        return Storage::disk('public')->url($this->qr_code_path);
    }

    /**
     * Get audio playback URL.
     */
    public function getAudioUrlAttribute(): ?string
    {
        if (! $this->audio_path) {
            return null;
        }

        if (str_starts_with($this->audio_path, 'http://') || str_starts_with($this->audio_path, 'https://')) {
            return $this->audio_path;
        }

        return Storage::disk('public')->url($this->audio_path);
    }

    /**
     * Get audio start time in seconds (for playback trimming).
     */
    public function getAudioStartSecAttribute(): float
    {
        return (float) ($this->metadata['audio_start_sec'] ?? 0);
    }

    /**
     * Get audio end time in seconds (null if play to the end).
     */
    public function getAudioEndSecAttribute(): ?float
    {
        $val = $this->metadata['audio_end_sec'] ?? null;

        return $val !== null && $val !== '' ? (float) $val : null;
    }

    /**
     * Get formatted audio start time (MM:SS).
     */
    public function getAudioStartFormattedAttribute(): string
    {
        $sec = (int) $this->audio_start_sec;
        $m = (int) floor($sec / 60);
        $s = $sec % 60;

        return sprintf('%02d:%02d', $m, $s);
    }

    /**
     * Get formatted audio end time (MM:SS).
     */
    public function getAudioEndFormattedAttribute(): string
    {
        if ($this->audio_end_sec === null) {
            return '';
        }
        $sec = (int) $this->audio_end_sec;
        $m = (int) floor($sec / 60);
        $s = $sec % 60;

        return sprintf('%02d:%02d', $m, $s);
    }

    /**
     * Determine if story is expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        if ($this->status === StoryStatus::EXPIRED) {
            return true;
        }

        if ($this->expired_at !== null && $this->expired_at->isPast()) {
            return true;
        }

        return false;
    }

    /**
     * Number of days remaining before expiration (null if lifetime).
     */
    public function getDaysRemainingAttribute(): ?int
    {
        if ($this->duration_plan === StoryDurationPlan::LIFETIME || $this->expired_at === null) {
            return null;
        }

        if ($this->expired_at->isPast()) {
            return 0;
        }

        return (int) max(0, ceil(Carbon::now()->floatDiffInDays($this->expired_at, false)));
    }

    /**
     * Love days counter: days elapsed since special event date.
     */
    public function getLoveDaysCountAttribute(): int
    {
        if (! $this->event_date) {
            return 0;
        }

        return (int) max(0, $this->event_date->diffInDays(Carbon::now()));
    }

    /**
     * Clean phone number for WhatsApp URL (e.g. 0812 -> 62812).
     */
    public function getCleanCustomerPhoneAttribute(): ?string
    {
        if (! $this->customer_phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $this->customer_phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Get direct WhatsApp follow-up link for florist staff.
     */
    public function getWhatsappFollowUpUrlAttribute(): ?string
    {
        $phone = $this->clean_customer_phone;
        if (! $phone) {
            return null;
        }

        $msg = $this->fulfillment_status instanceof StoryFulfillmentStatus
            ? $this->fulfillment_status->generateWaMessage($this)
            : '';

        return "https://wa.me/{$phone}?text={$msg}";
    }

    /**
     * Wedding details from metadata.
     *
     * @return array<string, mixed>
     */
    public function getWeddingDetailsAttribute(): array
    {
        return is_array($this->metadata) ? $this->metadata : [];
    }

    /**
     * Get Groom Photo URL with graceful fallback.
     */
    public function getGroomPhotoUrl(): string
    {
        $meta = $this->wedding_details;
        if (! empty($meta['groom_photo'])) {
            $path = (string) $meta['groom_photo'];
            return str_starts_with($path, 'http') ? $path : asset($path);
        }

        return 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80';
    }

    /**
     * Get Bride Photo URL with graceful fallback.
     */
    public function getBridePhotoUrl(): string
    {
        $meta = $this->wedding_details;
        if (! empty($meta['bride_photo'])) {
            $path = (string) $meta['bride_photo'];
            return str_starts_with($path, 'http') ? $path : asset($path);
        }

        return 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=600&q=80';
    }

    /**
     * Helper getters for couple details in wedding templates.
     */
    public function getGroomNickname(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['groom_nickname']) ? (string) $meta['groom_nickname'] : ($this->sender_name ?: 'Daffa');
    }

    public function getBrideNickname(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['bride_nickname']) ? (string) $meta['bride_nickname'] : ($this->recipient_name ?: 'Caca');
    }

    public function getGroomFullName(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['groom_full_name']) ? (string) $meta['groom_full_name'] : ($this->sender_name ?: 'Daffa Ramadhan, S.T.');
    }

    public function getBrideFullName(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['bride_full_name']) ? (string) $meta['bride_full_name'] : ($this->recipient_name ?: 'Clarissa Putri, S.I.Kom.');
    }

    public function getGroomParents(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['groom_parents']) ? (string) $meta['groom_parents'] : 'Putra dari Bpk. Bambang Tri & Ibu Nurhayati';
    }

    public function getBrideParents(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['bride_parents']) ? (string) $meta['bride_parents'] : 'Putri dari Bpk. Rudi Hartono & Ibu Dewi Anggraeni';
    }

    public function getCeremonyTime(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['ceremony_time']) ? (string) $meta['ceremony_time'] : '08.00 - 10.00 WIB';
    }

    public function getReceptionTime(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['reception_time']) ? (string) $meta['reception_time'] : '11.00 - 14.00 WIB';
    }

    public function getCeremonyVenue(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['ceremony_venue']) ? (string) $meta['ceremony_venue'] : ($meta['venue_name'] ?? 'Grand Glasshouse Ballroom Maja');
    }

    public function getReceptionVenue(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['venue_name']) ? (string) $meta['venue_name'] : 'Grand Glasshouse Ballroom Maja';
    }

    public function getCeremonyAddress(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['ceremony_venue_address']) ? (string) $meta['ceremony_venue_address'] : ($meta['venue_address'] ?? 'Jl. Anggrek Ceria No. 12, Kebayoran Baru, Jakarta Selatan');
    }

    public function getReceptionAddress(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['venue_address']) ? (string) $meta['venue_address'] : 'Jl. Anggrek Ceria No. 12, Kebayoran Baru, Jakarta Selatan';
    }

    public function getCeremonyMapsUrl(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['ceremony_maps_url']) ? (string) $meta['ceremony_maps_url'] : ($meta['maps_url'] ?? 'https://maps.google.com/?q=Jakarta');
    }

    public function getReceptionMapsUrl(): string
    {
        $meta = $this->wedding_details;
        return ! empty($meta['maps_url']) ? (string) $meta['maps_url'] : 'https://maps.google.com/?q=Jakarta';
    }

    /**
     * Explicit public URL method for blade views & actions.
     */
    public function getPublicUrl(): string
    {
        return route('story.public.show', ['slug' => $this->slug]);
    }

    /**
     * Explicit bouquet card print URL method for blade views & staff actions.
     */
    public function getPrintCardUrl(): string
    {
        return route('admin.digital-stories.print', $this);
    }

    /**
     * Explicit WhatsApp follow-up link method for florist staff.
     */
    public function getWhatsAppFollowUpUrl(): ?string
    {
        return $this->whatsapp_follow_up_url;
    }

    /**
     * Retrieve or generate inline SVG markup for the story's QR Code.
     */
    public function generateQrSvg(): string
    {
        if ($this->qr_code_path && Storage::disk('public')->exists($this->qr_code_path)) {
            $content = Storage::disk('public')->get($this->qr_code_path);
            if ($content && str_contains($content, '<svg')) {
                return $content;
            }
        }

        try {
            /** @var \App\Domains\DigitalStory\Actions\GenerateStoryQrCodeAction $action */
            $action = app(\App\Domains\DigitalStory\Actions\GenerateStoryQrCodeAction::class);
            $path = $action->execute($this->getPublicUrl(), $this->slug);
            $this->updateQuietly(['qr_code_path' => $path]);

            if (Storage::disk('public')->exists($path)) {
                return (string) Storage::disk('public')->get($path);
            }
        } catch (\Throwable) {
            // Graceful fallback to inline placeholder SVG
        }

        return '<svg viewBox="0 0 100 100" class="w-full h-full text-accent" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="#182218"/><text x="50" y="55" fill="#D4AF37" font-size="12" text-anchor="middle" font-family="monospace">QR CODE</text></svg>';
    }

    /**
     * Get saved guest list from story metadata.
     *
     * @return array<int, string>
     */
    public function getGuestList(): array
    {
        $meta = is_array($this->metadata) ? $this->metadata : [];
        $list = $meta['guest_list'] ?? [];

        return is_array($list) ? array_values(array_filter($list, fn ($g) => is_string($g) && trim($g) !== '')) : [];
    }

    /**
     * Generate personal invitation URL for a given guest name.
     */
    public function getGuestInvitationUrl(string $guestName): string
    {
        return route('story.public.show', [
            'slug' => $this->slug,
            'to' => trim($guestName),
        ]);
    }

    /**
     * Default WhatsApp invitation text template.
     */
    public function getDefaultWaInvitationTemplate(): string
    {
        $mempelai = $this->sender_name . ($this->recipient_name ? ' & ' . $this->recipient_name : '');
        $title = $this->title;

        return "Kepada Yth.\nBpk/Ibu/Saudara/i {nama_tamu}\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara hari bahagia pernikahan kami:\n\n*{$title}*\n{$mempelai}\n\nBerikut tautan undangan online kami untuk informasi lengkap acara, peta lokasi, & konfirmasi kehadiran:\n{link_undangan}\n\nMerupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.\n\nTerima kasih kami haturkan 🙏";
    }

    /**
     * Generate personalized WhatsApp message for a given guest.
     */
    public function generateWaMessageForGuest(string $guestName, ?string $customTemplate = null): string
    {
        $meta = is_array($this->metadata) ? $this->metadata : [];
        $template = $customTemplate ?: ($meta['wa_template'] ?? $this->getDefaultWaInvitationTemplate());
        $link = $this->getGuestInvitationUrl($guestName);
        $mempelai = $this->sender_name . ($this->recipient_name ? ' & ' . $this->recipient_name : '');

        return str_replace(
            ['{nama_tamu}', '{link_undangan}', '{judul_acara}', '{nama_mempelai}'],
            [trim($guestName), $link, $this->title, $mempelai],
            $template
        );
    }
}
