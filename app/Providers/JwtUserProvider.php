<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Services\JwtTokenService;
use App\Services\UserService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

final class JwtUserProvider
{
    public function retrieveById(int $identifier): ?Authenticatable
    {
        return User::where('id', $identifier)
            ->first();
    }
    public function retrieveByToken(int $identifier, string $token): ?Authenticatable
    {
        return (new JwtTokenService())->getUserByToken($token);
    }
    public function updateRememberToken(Authenticatable $user, string $token): never
    {
        throw new \Exception('Not implemented');
    }
    /**
     * @param array<string, mixed> $credentials
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        return (new UserService())->getUserByEmail($credentials['email']);
    }
    /**
     * @param Authenticatable $user
     * @param array<string, mixed> $credentials
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return Hash::check($credentials['password'], $user->password);
    }
}
