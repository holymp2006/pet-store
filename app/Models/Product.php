<?php

namespace App\Models;

use App\Casts\ProductMetadataCast;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasUuid;

    protected $casts = [
        'metadata' => ProductMetadataCast::class,
    ];
}
