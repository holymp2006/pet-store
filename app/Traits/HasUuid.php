<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;


trait HasUuid
{
    public static function bootHasUUID(): void
    {
        static::creating(function (Builder $model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
