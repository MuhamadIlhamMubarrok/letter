<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Requests;

use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Enums\StoryStatus;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryTemplateTheme;
use App\Domains\DigitalStory\Enums\StoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateDigitalStoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Prepare data before validation to streamline wedding invitations vs love letters.
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('story_type') === 'wedding_invitation') {
            $groom = $this->input('groom_nickname') ?: ($this->input('groom_full_name') ?: 'Mempelai Pria');
            $bride = $this->input('bride_nickname') ?: ($this->input('bride_full_name') ?: 'Mempelai Wanita');

            if (! $this->filled('sender_name')) {
                $this->merge(['sender_name' => $groom]);
            }
            if (! $this->filled('recipient_name')) {
                $this->merge(['recipient_name' => $bride]);
            }
            if (! $this->filled('title')) {
                $this->merge(['title' => "The Wedding of {$groom} & {$bride}"]);
            }
            if (! $this->filled('message')) {
                $this->merge(['message' => 'Dengan penuh rasa syukur kepada Tuhan Yang Maha Esa, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari bahagia pernikahan kami.']);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_code' => ['nullable', 'string', 'max:60'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'template_key' => ['sometimes', new Enum(StoryTemplateKey::class)],
            'fulfillment_status' => ['sometimes', new Enum(StoryFulfillmentStatus::class)],
            'notes' => ['nullable', 'string', 'max:2000'],
            'story_type' => ['sometimes', new Enum(StoryType::class)],
            'duration_plan' => ['sometimes', new Enum(StoryDurationPlan::class)],
            'status' => ['sometimes', new Enum(StoryStatus::class)],
            'theme' => ['sometimes', new Enum(StoryTemplateTheme::class)],
            'title' => ['required', 'string', 'max:150'],
            'sender_name' => ['required', 'string', 'max:100'],
            'recipient_name' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:5'],
            'event_date' => ['nullable', 'date'],
            'audio_file' => ['nullable', 'file', 'mimes:mp3,wav,ogg,m4a', 'max:15360'],
            'audio_url' => ['nullable', 'url', 'max:500'],
            'audio_title' => ['nullable', 'string', 'max:150'],
            'audio_start_sec' => ['nullable', 'numeric', 'min:0'],
            'audio_end_sec' => ['nullable', 'numeric', 'min:0'],
            'new_photos' => ['nullable', 'array', 'max:12'],
            'new_photos.*' => ['file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:5120'],
            'delete_photos' => ['nullable', 'array'],
            'delete_photos.*' => ['integer'],

            // Wedding Mempelai Pria & Wanita
            'groom_full_name' => ['nullable', 'string', 'max:150'],
            'groom_nickname' => ['nullable', 'string', 'max:60'],
            'groom_parents' => ['nullable', 'string', 'max:255'],
            'groom_instagram' => ['nullable', 'string', 'max:100'],
            'groom_bio' => ['nullable', 'string', 'max:500'],
            'groom_photo' => ['nullable', 'file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:5120'],

            'bride_full_name' => ['nullable', 'string', 'max:150'],
            'bride_nickname' => ['nullable', 'string', 'max:60'],
            'bride_parents' => ['nullable', 'string', 'max:255'],
            'bride_instagram' => ['nullable', 'string', 'max:100'],
            'bride_bio' => ['nullable', 'string', 'max:500'],
            'bride_photo' => ['nullable', 'file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:5120'],

            // Wedding Akad Nikah
            'ceremony_date' => ['nullable', 'date'],
            'wedding_ceremony_time' => ['nullable', 'string', 'max:100'],
            'ceremony_venue_name' => ['nullable', 'string', 'max:150'],
            'ceremony_venue_address' => ['nullable', 'string', 'max:255'],
            'ceremony_maps_url' => ['nullable', 'url', 'max:500'],

            // Wedding Resepsi
            'reception_date' => ['nullable', 'date'],
            'wedding_reception_time' => ['nullable', 'string', 'max:100'],
            'wedding_venue_name' => ['nullable', 'string', 'max:150'],
            'wedding_venue_address' => ['nullable', 'string', 'max:255'],
            'wedding_maps_url' => ['nullable', 'url', 'max:500'],

            // Digital Gift / Amplop & Rekening
            'bank_1_name' => ['nullable', 'string', 'max:50'],
            'bank_1_number' => ['nullable', 'string', 'max:50'],
            'bank_1_holder' => ['nullable', 'string', 'max:100'],
            'bank_2_name' => ['nullable', 'string', 'max:50'],
            'bank_2_number' => ['nullable', 'string', 'max:50'],
            'bank_2_holder' => ['nullable', 'string', 'max:100'],
            'gift_delivery_address' => ['nullable', 'string', 'max:300'],

            // Holy Verse / Quotes
            'holy_verse_text' => ['nullable', 'string', 'max:1000'],
            'holy_verse_source' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * Custom attribute names.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'story_type' => 'Tipe Cerita / Undangan',
            'duration_plan' => 'Paket Durasi Hosting',
            'theme' => 'Tema Desain',
            'title' => 'Judul Surat / Acara',
            'sender_name' => 'Nama Pengirim / Mempelai',
            'recipient_name' => 'Nama Penerima / Pasangan',
            'message' => 'Pesan Emosional / Surat Kenangan',
            'event_date' => 'Tanggal Spesial / Acara',
        ];
    }
}
