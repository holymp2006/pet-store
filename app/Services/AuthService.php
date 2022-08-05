<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\JwtToken;

final class AuthService
{
    public function generateJwtToken(): string
    {
        return JwtToken::generateToken();
    }
}
