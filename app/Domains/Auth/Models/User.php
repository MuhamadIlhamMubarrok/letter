<?php

declare(strict_types=1);

namespace App\Domains\Auth\Models;

use App\Domains\Auth\Enums\UserRoleEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Role accessor to Enum.
     */
    public function getRoleEnumAttribute(): UserRoleEnum
    {
        $normalized = strtolower(str_replace([' ', '-'], '_', $this->role ?? 'admin'));
        if (in_array($normalized, ['superadmin', 'super_admin'], true)) {
            return UserRoleEnum::SUPER_ADMIN;
        }
        return UserRoleEnum::tryFrom($normalized) ?? UserRoleEnum::ADMIN;
    }

    /**
     * Check if user has admin / super admin privileges.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role_enum->isAdmin();
    }
}
