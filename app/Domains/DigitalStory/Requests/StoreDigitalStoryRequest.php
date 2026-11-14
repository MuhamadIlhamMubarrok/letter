<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Requests;

use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryTemplateTheme;
use App\Domains\DigitalStory\Enums\StoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreDigitalStoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
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
            'template_key' => ['nullable', new Enum(StoryTemplateKey::class)],
            'fulfillment_status' => ['nullable', new Enum(StoryFulfillmentStatus::class)],
            'notes' => ['nullable', 'string', 'max:2000'],
            'story_type' => ['required', new Enum(StoryType::class)],
            'duration_plan' => ['required', new Enum(StoryDurationPlan::class)],
            'theme' => ['required', new Enum(StoryTemplateTheme::class)],
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
            'photos' => ['nullable', 'array', 'max:12'],
            'photos.*' => ['file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:5120'],
            'photo_captions' => ['nullable', 'array'],
            'photo_captions.*' => ['nullable', 'string', 'max:255'],
            'wedding_venue_name' => ['nullable', 'string', 'max:150'],
            'wedding_venue_address' => ['nullable', 'string', 'max:255'],
            'wedding_maps_url' => ['nullable', 'url', 'max:500'],
            'wedding_ceremony_time' => ['nullable', 'string', 'max:50'],
            'wedding_reception_time' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * Custom attribute names for clear Indonesian validation errors.
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
            'audio_file' => 'File Musik Kenangan',
            'audio_url' => 'URL Musik Kenangan',
            'audio_title' => 'Judul Lagu Kenangan',
            'photos' => 'Foto Polaroid',
            'wedding_venue_name' => 'Nama Tempat Resepsi',
            'wedding_venue_address' => 'Alamat Lengkap Lokasi',
            'wedding_maps_url' => 'Tautan Google Maps',
        ];
    }

    /**
     * Custom Indonesian messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute tidak boleh lebih dari :max.',
            'photos.*.image' => 'Setiap foto wajib berupa gambar yang valid (JPG, PNG, WEBP).',
            'photos.*.max' => 'Ukuran setiap foto maksimal 5MB.',
            'audio_file.max' => 'Ukuran file audio maksimal 15MB.',
        ];
    }
}
