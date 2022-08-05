<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

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
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
