<?php

namespace App\Admin\Product\Model;

use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'flower_composition',
        'dimensions',
        'is_bestseller',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_bestseller' => 'boolean',
        'is_available' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        if ($this->relationLoaded('primaryImage') && $this->primaryImage) {
            return $this->primaryImage->url;
        }

        $firstImg = $this->images->first();
        if ($firstImg) {
            return $firstImg->url;
        }

        // Return a refined botanical placeholder image
        return 'https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=800&q=80';
    }

    public function getFlowerCompositionArrayAttribute(): array
    {
        if (empty($this->flower_composition)) {
            return [];
        }

        if (str_starts_with($this->flower_composition, '[') || str_starts_with($this->flower_composition, '{')) {
            $decoded = json_decode($this->flower_composition, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return array_map('trim', explode(',', $this->flower_composition));
    }
}
