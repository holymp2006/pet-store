<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    use HasUuid;

    protected $casts = [
        'products' => AsArrayObject::class,
        'address' => AsArrayObject::class,
        'shipped_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
