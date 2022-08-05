<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

final class UserService
{
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
