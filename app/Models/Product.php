<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasUuid;

    protected $casts = [
        'metadata' => AsArrayObject::class,
    ];
    protected $fillable = [
        'category_id',
        'title',
        'price',
        'description',
        'metadata',
    ];
}
