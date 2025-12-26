<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['category_id' => 16, 'name' => '腕時計', 'price' => 15000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg', 'brand_name' => 'Rolax', 'condition_id' => 1],
            ['category_id' => 20,'name' => 'HDD', 'price' => 5000, 'description' => '高速で信頼性の高いハードディスク', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg', 'brand_name' => '西芝', 'condition_id' => 2],
            ['category_id' => 24,'name' => '玉ねぎ3束', 'price' => 300, 'description' => '新鮮な玉ねぎ3束のセット', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMA+d.jpg', 'brand_name' => 'なし', 'condition_id' => 3],
            ['category_id' => 1,'name' => '革靴', 'price' => 4000, 'description' => 'クラシックなデザインの革靴', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg', 'brand_name' => null, 'condition_id' => 4],
            ['category_id' => 20,'name' => 'ノートPC', 'price' => 45000, 'description' => '高性能なノートパソコン', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg', 'brand_name' => null, 'condition_id' => 1],
            ['category_id' => 22,'name' => 'マイク', 'price' => 8000, 'description' => '高音質のレコーディング用マイク', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg', 'brand_name' => 'なし', 'condition_id' => 2],
            ['category_id' => 1,'name' => 'ショルダーバッグ', 'price' => 3500, 'description' => 'おしゃれなショルダーバッグ', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg', 'brand_name' => null, 'condition_id' => 3],
            ['category_id' => 11,'name' => 'タンブラー', 'price' => 500, 'description' => '使いやすいタンブラー', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg', 'brand_name' => 'なし', 'condition_id' => 4],
            ['category_id' => 11,'name' => 'コーヒーミル', 'price' => 4000, 'description' => '手動のコーヒーミル', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg', 'brand_name' => 'Starbacks', 'condition_id' => 1],
            ['category_id' => 6,'name' => 'メイクセット', 'price' => 2500, 'description' => '便利なメイクアップセット', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg', 'brand_name' => null, 'condition_id' => 2],
        ];



        foreach ($products as $productData) {
            Product::create([
                'user_id' => rand(1, 10),
                'category_id' => $productData['category_id'],
                'condition_id' => $productData['condition_id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                'brand_name' => $productData['brand_name'],
                'description' => $productData['description'],
                'image_path' => $productData['image_path'],
                'is_sold' => false,
            ]);
        }
    }
}
