<?php

declare(strict_types=1);

namespace App\Guards;

use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

final class JwtGuard implements Guard
{
    use GuardHelpers;

    public function __construct(
        protected UserProvider $provider,
        protected Request $request
    ) {
    }

    public function user(): Authenticatable | null
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();

        if (!is_null($token)) {
            $user = $this->provider->retrieveByCredentials([
                $this->storageKey => $this->hash ? hash('sha256', $token) : $token,
            ]);
        }

        return $this->user = $user;
    }
    public function getTokenForRequest(): string | null
    {
        return $this->request->bearerToken();
    }
    public function validate(array $credentials = []): bool
    {
        if (!isset($credentials['email'])) {
            return false;
        }
        if (!isset($credentials['password'])) {
            return false;
        }

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }
}
