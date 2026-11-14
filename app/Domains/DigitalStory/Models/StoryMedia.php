<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class StoryMedia extends Model
{
    use HasFactory;

    protected $table = 'story_media';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'digital_story_id',
        'file_path',
        'file_name',
        'mime_type',
        'caption',
        'sort_order',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Story relation.
     *
     * @return BelongsTo<DigitalStory, $this>
     */
    public function story(): BelongsTo
    {
        return $this->belongsTo(DigitalStory::class, 'digital_story_id');
    }

    /**
     * Public URL for media image.
     */
    public function getFileUrlAttribute(): string
    {
        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }

        if (str_starts_with($this->file_path, 'general/') || str_starts_with($this->file_path, '/')) {
            return asset(ltrim($this->file_path, '/'));
        }

        return Storage::disk('public')->url($this->file_path);
    }
}
