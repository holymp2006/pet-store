<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_can_view_all_orders()
    {
        $orders = Order::factory(5)->create();
        $response = $this->getJson('api/v1/orders');
        $order = $orders->first();
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $order->uuid,
                        'title' => $order->title,
                        'price' => $order->price,
                        'description' => $order->description,
                        'created_at' => $order->created_at->toDateTimeString(),
                    ]
                ]

            ]);
    }
}
