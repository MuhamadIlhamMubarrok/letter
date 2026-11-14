<?php

use App\Domains\Auth\Controllers\AuthController;
use App\Domains\Auth\Controllers\PasswordController;
use App\Domains\DigitalStory\Controllers\AdminStoryController;
use App\Domains\DigitalStory\Controllers\PublicStoryController;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Dedicated CMS Root Redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.digital-stories.index');
    }
    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Digital Message & Wedding Invitation Public Viewer
| High-Entropy Slug Access Protected with Graceful Expiration
|--------------------------------------------------------------------------
*/
Route::get('/s/{slug}', [PublicStoryController::class, 'show'])->name('story.public.show');
Route::post('/s/{slug}/rsvp', [PublicStoryController::class, 'rsvp'])->middleware('throttle:15,1')->name('story.public.rsvp');

/*
|--------------------------------------------------------------------------
| Template Showcase & Live Demo Previews (Publicly Shareable with Clients)
|--------------------------------------------------------------------------
*/
Route::get('/preview/template/{templateKey}', [PublicStoryController::class, 'previewTemplate'])->name('story.public.preview');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes (Secret Endpoint & Brute-Force Rate Limiting)
|--------------------------------------------------------------------------
*/
$adminSecretPath = env('ADMIN_SECRET_PATH', 'portal-rahasia-florist');

// Secret Login URL with rate limiting protection
Route::get('/' . $adminSecretPath, [AuthController::class, 'showLogin'])->name('login');
Route::post('/' . $adminSecretPath, [AuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login.submit');

// Standard aliases redirected to login
Route::get('/login', fn () => redirect()->route('login'));
Route::get('/admin/login', fn () => redirect()->route('login'))->name('admin.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Backoffice CMS Routes (Khusus Surat & Undangan Digital)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.digital-stories.index'));
    Route::get('/dashboard', fn () => redirect()->route('admin.digital-stories.index'))->name('dashboard');

    // Account Security & Change Password Management
    Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    // Digital Message & Wedding Invitation Engine (CMS Utama)
    Route::get('/templates', [AdminStoryController::class, 'templates'])->name('digital-stories.templates');
    Route::get('/digital-stories/{digitalStory}/guests', [AdminStoryController::class, 'guestLinks'])->name('digital-stories.guests');
    Route::post('/digital-stories/{digitalStory}/guests', [AdminStoryController::class, 'saveGuests'])->name('digital-stories.guests.save');
    Route::get('/digital-stories/{digitalStory}/print', [AdminStoryController::class, 'printCard'])->name('digital-stories.print');
    Route::post('/digital-stories/{digitalStory}/extend', [AdminStoryController::class, 'extendDuration'])->name('digital-stories.extend');
    Route::patch('/digital-stories/{digitalStory}/fulfillment', [AdminStoryController::class, 'updateFulfillmentStatus'])->name('digital-stories.fulfillment');
    Route::resource('digital-stories', AdminStoryController::class);
});
