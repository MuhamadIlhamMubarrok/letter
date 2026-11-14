<?php

declare(strict_types=1);

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordAction
{
    /**
     * Update user password safely inside transaction.
     */
    public function execute(User $user, string $newPassword): void
    {
        DB::transaction(function () use ($user, $newPassword): void {
            $user->forceFill([
                'password' => Hash::make($newPassword),
            ])->save();
        });
    }
}
