<?php

declare(strict_types=1);

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Actions\UpdatePasswordAction;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Requests\UpdatePasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Display the change password view for the authenticated admin.
     */
    public function edit(): View
    {
        return view('admin.auth.password', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update the authenticated admin's password with strict security checks.
     */
    public function update(UpdatePasswordRequest $request, UpdatePasswordAction $action): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $action->execute($user, (string) $request->validated('password'));

        return redirect()->route('admin.password.edit')->with('success', 'Kata sandi akun admin berhasil diperbarui dengan aman.');
    }
}
