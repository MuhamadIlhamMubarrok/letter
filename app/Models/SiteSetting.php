<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
        'type',
    ];

    /**
     * Cache key for all site settings.
     */
    const CACHE_KEY = 'site_settings_all';

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget(self::CACHE_KEY);
        });

        static::deleted(function () {
            Cache::forget(self::CACHE_KEY);
        });
    }

    /**
     * Get a setting by key, or fallback to default value.
     */
    public static function get(string $key, $default = null)
    {
        $settings = Cache::rememberForever(self::CACHE_KEY, function () {
            return self::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting by key.
     */
    public static function set(string $key, $value, ?string $group = null, ?string $label = null, string $type = 'text'): self
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = $value;
        if ($group) $setting->group = $group;
        if ($label) $setting->label = $label;
        if ($type) $setting->type = $type;
        $setting->save();

        return $setting;
    }

    /**
     * Get all settings grouped by group.
     */
    public static function getGrouped()
    {
        return self::all()->groupBy('group');
    }
}
