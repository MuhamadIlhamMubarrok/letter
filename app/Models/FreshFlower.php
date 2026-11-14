<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FreshFlower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'botanical_name',
        'origin',
        'color_name',
        'color_hex',
        'stock_stems',
        'status',
        'price_per_stem',
        'vase_life',
        'aroma_note',
        'description',
        'image_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'stock_stems' => 'integer',
        'price_per_stem' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->latest('id');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('catalog-media/lumiere series - 1/lumirere series - 1.png');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        if (file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }

        return Storage::disk('public')->url($this->image_path);
    }

    public function getFormattedPriceAttribute(): string
    {
        if (!$this->price_per_stem) {
            return 'Konsultasi Florist';
        }

        return 'Rp ' . number_format($this->price_per_stem, 0, ',', '.') . ' / tangkai';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'ready' => 'Ready Hari Ini',
            'limited' => 'Sisa Sedikit',
            'sold_out' => 'Habis / Restock Besok',
            default => 'Tersedia',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'ready' => 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
            'limited' => 'bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-800',
            'sold_out' => 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700',
            default => 'bg-cream text-dark border-dark/10',
        };
    }

    public function getStatusDotClassAttribute(): string
    {
        return match ($this->status) {
            'ready' => 'bg-emerald-500',
            'limited' => 'bg-amber-500 animate-pulse',
            'sold_out' => 'bg-slate-400',
            default => 'bg-primary',
        };
    }
}
