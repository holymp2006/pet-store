<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use Lcobucci\JWT\Configuration;
use Illuminate\Database\Eloquent\Model;
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
        static::created(function ($model): void {
            $model->token = static::generateToken();
            $model->save();
        });
    }
    public static function generateToken(): string
    {
        // $user = (new self)->user()->first();

        $config = resolve(Configuration::class);
        assert($config instanceof Configuration);

        $now  = new CarbonImmutable();
        $token = $config->builder()
            ->issuedBy(config('app.url'))
            ->relatedTo(Str::random(8))
            ->issuedAt($now)
            ->expiresAt($now->addHours(24))
            ->withClaim('name', Str::random(8))
            ->withClaim('user_uuid', Str::uuid())
            ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
