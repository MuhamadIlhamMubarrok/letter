<?php

declare(strict_types=1);

namespace App\Domains\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BuckflowProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'buckflow';

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category',
        'series_id',
        'sub_name',
        'dominant_color',
        'stock',
        'selling_price',
        'image_url',
        'image_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'selling_price' => 'float',
        'is_active' => 'boolean',
    ];

    public function getResolvedImageUrlAttribute(): ?string
    {
        if ($this->image_url) {
            return $this->image_url;
        }

        if ($this->image_path) {
            if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
                return $this->image_path;
            }
            $buckflowUrl = rtrim((string) config('services.buckflow.url', env('BUCKFLOW_APP_URL', 'http://127.0.0.1:8000')), '/');
            return "{$buckflowUrl}/storage/{$this->image_path}";
        }

        return null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->selling_price, 0, ',', '.');
    }
}
