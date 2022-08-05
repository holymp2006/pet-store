<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Services\JwtTokenService;

class OrderTest extends TestCase
{
    /** @test */
    public function auth_user_can_view_all_orders()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $payment = Payment::factory()->create();
        $orderStatus = OrderStatus::get()->random();
        $product = Product::factory()->create();
        $orders = Order::factory(2)->create([
            'user_id' => $user->id,
            'order_status_id' => $orderStatus->id,
            'payment_id' => $payment->id,
            'products' => [
                [
                    'product_uuid' => $product->uuid,
                    'quantity' => 1,
                ],
            ],
        ]);
        $token = (new JwtTokenService)->createTokenForUser($user);
        $response = $this->withToken($token)
            ->getJson('api/v1/orders');
        $order = $orders->first();
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $order->uuid,
                        'amount' => $order->amount,
                        'created_at' => $order->created_at->toDateTimeString(),
                    ]
                ]

            ]);
    }
}
