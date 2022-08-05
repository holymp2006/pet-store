<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'title' => 'Pending',
            ],
            [
                'title' => 'Processing',
            ],
            [
                'title' => 'Completed',
            ],
            [
                'title' => 'Cancelled',
            ],
        ];
        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}
