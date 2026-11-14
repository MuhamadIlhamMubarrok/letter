<?php

namespace App\Admin\Setting\Controller;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display the site settings control center.
     */
    public function index()
    {
        $settings = SiteSetting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the site settings in batch.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        // Explicit boolean toggle handling
        $data['announcement_active'] = $request->has('announcement_active') ? '1' : '0';

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        Cache::forget(SiteSetting::CACHE_KEY);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan informasi atelier & toko berhasil diperbarui.');
    }
}
