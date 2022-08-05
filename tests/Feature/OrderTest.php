<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderStatus;

class OrderTest extends TestCase
{
    /** @test */
    public function user_can_view_all_orders()
    {
        $user = User::factory()->create();
        $payment = Payment::factory()->create();
        $orderStatus = OrderStatus::get()->random();
        $product = Product::factory()->create();
        $orders = Order::factory(5)->create([
            'user_id' => $user->id,
            'order_status_id' => $orderStatus->id,
            'payment_id' => $payment->id,
            'products' => [
                [
                    'product_uuid' => $product->uuid,
                    'quantity' => 1,
                ],
            ],
            'address' => [
                'billing' => 'Anytown',
                'shipping' => '123 Main St',
            ],
            'delivery_fee' => 10.00,
            'amount' => 100.00,
        ]);
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
