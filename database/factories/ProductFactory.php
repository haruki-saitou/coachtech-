<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            // 商品を作る際、自動でユーザーと状態も作成して紐付ける
            'user_id' => User::factory(),
            'condition_id' => Condition::factory(),

            'name' => 'テスト用商品',
            'price' => 5000,
            'description' => 'テスト用の説明文です。',
            'brand_name' => 'テストブランド',
            'image_path' => 'test_image.jpg',
            'is_sold' => false,
        ];
    }
}
