<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'user_id' => 5,
            'product_id' => 3,
            'payment_method' => 'card',
        ]);

        $products = Product::find(3);
        $products->update(['is_sold' => true]);

        Order::create([
            'user_id' => 6,
            'product_id' => 5,
            'payment_method' => 'konbini',
        ]);
        $products = Product::find(5);
        $products->update(['is_sold' => true]);
    }
}
