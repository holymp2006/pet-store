<?php

declare(strict_types=1);

namespace App\Guards;

use App\Models\User;
use App\Providers\JwtUserProvider;
use App\Services\JwtTokenService;
use App\Services\UserService;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\UnencryptedToken;

final class JwtGuard
{
    protected string $name = 'jwt';

    public function __construct(
        protected JwtUserProvider $provider,
        protected Request $request,
        protected ?Authenticatable $user = null
    ) {
    }

    public function user(): ?User
    {
        if (!is_null($this->user)) {
            return $this->user;
        }
        $token = $this->getTokenForRequest();
        if (is_null($token)) {
            return $this->user = null;
        }
        $this->parse($token);
        $user = (new JwtTokenService())->getUserByToken($token);

        return $this->user = $user;
    }
    public function getTokenForRequest(): ?string
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
        $user = $this->provider->retrieveByCredentials($credentials);
        if (is_null($user)) {
            return false;
        }
        if ($this->provider->validateCredentials($user, $credentials)) {
            event(new Validated($this->name, $user));
            $this->user = $user;

            return true;
        }
        event(new Failed($this->name, $user, $credentials));

        return false;
    }

    public function check(): bool
    {
        return !is_null($this->user());
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function id(): int | string
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }
    }
    public function attempt(array $credentials = []): bool
    {
        return $this->validate($credentials);
    }
    protected function parse(string $token): Token
    {
        $config = resolve(Configuration::class);
        assert($config instanceof Configuration);

        $token = $config->parser()->parse($token);

        assert($token instanceof UnencryptedToken);

        return $token;
    }
}
