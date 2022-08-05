<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\OrderService;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{
    public function __construct(
        private OrderResource $orderResource,
        private OrderService $orderService
    ) {
    }

    public function index(): JsonResource
    {
        return $this->orderResource->collection($this->orderService->getAll());
    }
}
