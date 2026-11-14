<?php

declare(strict_types=1);

namespace App\Models;

use App\Domains\Auth\Models\User as DomainUser;

/**
 * Class User
 * Forwarding alias to Domain Model App\Domains\Auth\Models\User
 * Ensuring 100% backward compatibility with Laravel default auth provider and legacy seeder.
 */
class User extends DomainUser
{
}
