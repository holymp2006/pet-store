<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Lcobucci\JWT\Configuration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JwtToken extends Model
{
    use HasFactory;

    protected $casts = [
        'permissions' => AsArrayObject::class,
        'restrictions' => AsArrayObject::class,
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
        'refreshed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model): void {
            $model->buildToken();
        });
    }
    public function buildToken(): void
    {
        $config = resolve(Configuration::class);
        assert($config instanceof Configuration);
        $now = new CarbonImmutable();
        $expiresAt = $now->addHours(24);

        $token = $config->builder()
            ->issuedBy(config('app.url'))
            ->relatedTo($this->user->uuid)
            ->issuedAt($now)
            ->expiresAt($expiresAt)
            ->withClaim('user_uuid', $this->user->uuid)
            ->getToken($config->signer(), $config->signingKey());

        $this->unique_id = $token->toString();
        $this->expires_at = $expiresAt->toDateTimeString();
        $this->buildUserRestrictions();
        $this->buildUserPermissions();
        $this->buildName();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected function buildUserRestrictions(): array
    {
        return $this->restrictions = [];
    }
    protected function buildUserPermissions(): array
    {
        return $this->permissions = [];
    }
    protected function buildName(): string
    {
        return $this->token_title = $this->user->first_name  . '-' . (string)now()->getTimestamp();
    }
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '<', now());
    }
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('expires_at', '>', now());
    }
}
