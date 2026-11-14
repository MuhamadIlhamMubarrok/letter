<?php

declare(strict_types=1);

namespace App\Domains\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuckflowUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'buckflow';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'role',
        'avatar_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
