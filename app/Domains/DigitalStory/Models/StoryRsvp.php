<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryRsvp extends Model
{
    use HasFactory;

    protected $table = 'story_rsvps';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'digital_story_id',
        'guest_name',
        'attendance_status',
        'guest_count',
        'wishes',
        'ip_address',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'guest_count' => 'integer',
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
     * Friendly status label.
     */
    public function getAttendanceLabelAttribute(): string
    {
        return match ($this->attendance_status) {
            'attending' => 'Hadir',
            'not_attending' => 'Tidak Dapat Hadir',
            'tentative' => 'Masih Ragu',
            default => 'Konfirmasi',
        };
    }
}
