<?php

if (!function_exists('setting')) {
    /**
     * Get or set a site setting dynamically.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function setting(?string $key = null, $default = null)
    {
        if ($key === null) {
            return app(\App\Models\SiteSetting::class);
        }

        try {
            return \App\Models\SiteSetting::get($key, $default);
        } catch (\Throwable $e) {
            return $default;
        }
    }
}
