<?php

namespace Database\Seeders;

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
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => '渋谷マンション101',
        ]);

        $product = Product::find(3, ['*']);
        $product->update(['is_sold' => true]);

        Order::create([
            'user_id' => 6,
            'product_id' => 5,
            'payment_method' => 'konbini',
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => '渋谷マンション109',
        ]);
        $product = Product::find(5, ['*']);
        $product->update(['is_sold' => true]);
    }
}