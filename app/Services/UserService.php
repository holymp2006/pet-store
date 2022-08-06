<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

final class UserService
{
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
    public function getAll(): Collection
    {
        return User::all();
    }
    /**
     * @param array<string, string> $data
     */
    public function login(array $data): bool
    {
        return auth('api')->validate(
            Arr::only(
                $data,
                $this->getFillable()
            )
        );
    }
    protected function getFillable(): array
    {
        return [
            'email',
            'password',
        ];
    }
}
