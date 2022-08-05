<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

final class OrderService
{
    public function getAll(): Collection
    {
        return Order::all();
    }
}
