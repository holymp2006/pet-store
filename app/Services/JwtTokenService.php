<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\JwtToken;
use App\Models\User;

final class JwtTokenService
{
    public function createTokenForUser(User $user): string
    {
        $this->deleteExpiredTokensForUser($user);

        return $user->tokens()->create([])->unique_id;
    }
    public function getUserByToken(string $token): ?User
    {
        $token = JwtToken::active()->with('user')
            ->where('unique_id', $token)
            ->first();
        if (is_null($token)) {
            return null;
        }
        return $token->user;
    }
    protected function deleteExpiredTokensForUser(User $user): void
    {
        $user->tokens()->expired()->delete();
    }
}
