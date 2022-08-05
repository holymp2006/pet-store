<?php

declare(strict_types=1);

namespace App\Guards;

use App\Models\User;
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
        $user = (new UserService())->getUserByEmail($credentials['email']);
        if (is_null($user)) {
            return false;
        }
        if (Hash::check($credentials['password'], $user->password)) {
            dispatch(new Validated($this->name, $user));
            return true;
        }
        dispatch(new Failed($this->name, $user, $credentials));

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

    protected function parse(string $token): Token
    {
        $config = resolve(Configuration::class);
        assert($config instanceof Configuration);

        $token = $config->parser()->parse($token);

        assert($token instanceof UnencryptedToken);

        return $token;
    }
}
