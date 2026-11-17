<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin CMS User (Sistem Undangan & Surat)
        User::firstOrCreate(
            ['email' => 'admin@majaflower.com'],
            [
                'name' => 'Florist Lead Maja',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Showcase & Demo Stories for Surat Cinta & Undangan Pernikahan
        $this->call(DigitalStorySeeder::class);
    }
}
