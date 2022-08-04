<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;


trait HasUuid
{
    public static function bootHasUUID(): void
    {
        static::creating(function (self $model): void {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
