<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['cat_ids' => [5,16], 'name' => '腕時計', 'price' => 15000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg', 'brand_name' => 'Rolax', 'condition_id' => 1],
            ['cat_ids' => [20],'name' => 'HDD', 'price' => 5000, 'description' => '高速で信頼性の高いハードディスク', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg', 'brand_name' => '西芝', 'condition_id' => 2],
            ['cat_ids' => [24],'name' => '玉ねぎ3束', 'price' => 300, 'description' => '新鮮な玉ねぎ3束のセット', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg', 'brand_name' => 'なし', 'condition_id' => 3],
            ['cat_ids' => [1,5],'name' => '革靴', 'price' => 4000, 'description' => 'クラシックなデザインの革靴', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg', 'brand_name' => null, 'condition_id' => 4],
            ['cat_ids' => [20],'name' => 'ノートPC', 'price' => 45000, 'description' => '高性能なノートパソコン', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg', 'brand_name' => null, 'condition_id' => 1],
            ['cat_ids' => [20],'name' => 'マイク', 'price' => 8000, 'description' => '高音質のレコーディング用マイク', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg', 'brand_name' => 'なし', 'condition_id' => 2],
            ['cat_ids' => [1,4],'name' => 'ショルダーバッグ', 'price' => 3500, 'description' => 'おしゃれなショルダーバッグ', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg', 'brand_name' => null, 'condition_id' => 3],
            ['cat_ids' => [9,10,11],'name' => 'タンブラー', 'price' => 500, 'description' => '使いやすいタンブラー', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg', 'brand_name' => 'なし', 'condition_id' => 4],
            ['cat_ids' => [11,26],'name' => 'コーヒーミル', 'price' => 4000, 'description' => '手動のコーヒーミル', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg', 'brand_name' => 'Starbacks', 'condition_id' => 1],
            ['cat_ids' => [4,6],'name' => 'メイクセット', 'price' => 2500, 'description' => '便利なメイクアップセット', 'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg', 'brand_name' => null, 'condition_id' => 2],



            ['cat_ids' => [15,18],'name' => 'AirPods', 'price' => 21800, 'description' => 'アクティブノイズキャンセル搭載', 'image_path' => 'airPods.jpg', 'brand_name' => 'apple', 'condition_id' => 1],
            ['cat_ids' => [25],'name' => 'アルミホイール', 'price' => 418000, 'description' => '純正アルミホイール', 'image_path' => 'alloy-wheel-1.jpg', 'brand_name' => 'audi', 'condition_id' => 1],
            ['cat_ids' => [25],'name' => 'アルミホイール', 'price' => 518000, 'description' => '純正アルミホイール', 'image_path' => 'alloy-wheel-2.jpg', 'brand_name' => 'porsche', 'condition_id' => 1],
            ['cat_ids' => [25],'name' => 'アルミホイール', 'price' => 818000, 'description' => '純正アルミホイール', 'image_path' => 'alloy-wheel-3.jpg', 'brand_name' => 'bentley', 'condition_id' => 1],
            ['cat_ids' => [25],'name' => 'アルミホイール', 'price' => 318000, 'description' => '純正アルミホイール', 'image_path' => 'alloy-wheel-4.jpg', 'brand_name' => 'audi', 'condition_id' => 1],
            ['cat_ids' => [9],'name' => 'バスケットボール', 'price' => 13800, 'description' => 'バスケットボール', 'image_path' => 'basket-ball.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [9],'name' => 'サッカーボール', 'price' => 9800, 'description' => 'サッカーボール', 'image_path' => 'soccer-ball.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [9],'name' => 'テニスラケット', 'price' => 9800, 'description' => 'テニスラケット', 'image_path' => 'tennis-racket.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [17],'name' => '自転車', 'price' => 106800, 'description' => 'シティーサイクル', 'image_path' => 'bicycle-1.jpg', 'brand_name' => 'hummer', 'condition_id' => 1],
            ['cat_ids' => [17],'name' => '自転車', 'price' => 36800, 'description' => 'シティーサイクル', 'image_path' => 'bicycle-2.jpg', 'brand_name' => 'ブリジストン', 'condition_id' => 1],
            ['cat_ids' => [17],'name' => '自転車', 'price' => 26800, 'description' => 'シティーサイクル', 'image_path' => 'bicycle-3.jpg', 'brand_name' => 'パナソニック', 'condition_id' => 1],
            ['cat_ids' => [25],'name' => 'バイク', 'price' => 426800, 'description' => '250ccバイク', 'image_path' => 'bike-1.jpg', 'brand_name' => 'YAMAHA', 'condition_id' => 2],
            ['cat_ids' => [25],'name' => 'バイク', 'price' => 626800, 'description' => '400ccバイク', 'image_path' => 'bike-2.jpg', 'brand_name' => 'kawasaki', 'condition_id' => 2],
            ['cat_ids' => [25],'name' => 'バイク', 'price' => 326800, 'description' => '250ccバイク', 'image_path' => 'bike-3.jpg', 'brand_name' => 'YAMAHA', 'condition_id' => 3],
            ['cat_ids' => [2,11],'name' => 'ミキサー', 'price' => 8800, 'description' => '電動ミキサー', 'image_path' => 'blender.jpg', 'brand_name' => '日立', 'condition_id' => 3],
            ['cat_ids' => [2],'name' => '掃除機', 'price' => 58800, 'description' => '業務用掃除機、水も吸える', 'image_path' => 'vacuum-cleaner.jpg', 'brand_name' => 'Bosch', 'condition_id' => 2],
            ['cat_ids' => [4,6],'name' => 'チーク', 'price' => 1800, 'description' => '化粧品のチーク', 'image_path' => 'blush.jpg', 'brand_name' => '資生堂', 'condition_id' => 1],
            ['cat_ids' => [7],'name' => '小説', 'price' => 1600, 'description' => 'ダークファンタジー小説', 'image_path' => 'book.jpg', 'brand_name' => 'なし', 'condition_id' => 2],
            ['cat_ids' => [1,4],'name' => 'ブーツ', 'price' => 8600, 'description' => '本革仕様のブーツ', 'image_path' => 'booties.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,4],'name' => 'ブーツ', 'price' => 9200, 'description' => '本革仕様のブーツ', 'image_path' => 'boots.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,4],'name' => 'Tシャツ', 'price' => 1800, 'description' => '女性用Tシャツ', 'image_path' => 't-shirt.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [24],'name' => '食品', 'price' => 630, 'description' => 'トマトの瓶詰め', 'image_path' => 'bottled.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,4,14,15],'name' => 'ブレスレット', 'price' => 5300, 'description' => '手作りのブレスレット', 'image_path' => 'bracelet-1.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,4,14,15],'name' => 'ブレスレット', 'price' => 2400, 'description' => '手作りのブレスレット', 'image_path' => 'bracelet-2.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [19],'name' => '一眼レフカメラ', 'price' => 120000, 'description' => '一眼レフカメラエントリーモデル', 'image_path' => 'camera.jpg', 'brand_name' => 'Canon', 'condition_id' => 1],
            ['cat_ids' => [19],'name' => 'レトロカメラ', 'price' => 8900, 'description' => 'レトロなカメラ', 'image_path' => 'retro-camera.jpg', 'brand_name' => 'nikon', 'condition_id' => 2],
            ['cat_ids' => [19],'name' => 'ヴィンテージカメラ', 'price' => 38900, 'description' => '年季の入ったカメラ', 'image_path' => 'vintage-camera.jpg', 'brand_name' => 'なし', 'condition_id' => 3],
            ['cat_ids' => [19],'name' => 'ビデオカメラ', 'price' => 118900, 'description' => '本格的なビデオカメラ', 'image_path' => 'video-camera.jpg', 'brand_name' => 'nikon', 'condition_id' => 2],
            ['cat_ids' => [10],'name' => 'キャンピングチェア、テーブルセット', 'price' => 8000, 'description' => 'キャンピングに欠かせないキャンピングチェアとテーブルのセット', 'image_path' => 'camping-furniture.jpg', 'brand_name' => 'コールマン', 'condition_id' => 1],
            ['cat_ids' => [10],'name' => 'キャンピング用テント', 'price' => 13000, 'description' => 'キャンピングに欠かせないシングル用テント', 'image_path' => 'tent.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [12,13],'name' => 'ミニカー', 'price' => 500, 'description' => 'ミニカー', 'image_path' => 'car-toy.jpg', 'brand_name' => 'なし', 'condition_id' => 2],
            ['cat_ids' => [12,13],'name' => 'クマのぬいぐるみ', 'price' => 2300, 'description' => 'クマのぬいぐるみ', 'image_path' => 'teddy-bear.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [20,21],'name' => 'PC', 'price' => 198900, 'description' => 'デスクトップPC', 'image_path' => 'desktop-pc-1.jpg', 'brand_name' => 'HITACHI', 'condition_id' => 1],
            ['cat_ids' => [20,21],'name' => 'PC', 'price' => 198900, 'description' => 'デスクトップPC', 'image_path' => 'desktop-pc-2.jpg', 'brand_name' => 'Panasonic', 'condition_id' => 1],
            ['cat_ids' => [20,21],'name' => 'PC', 'price' => 198900, 'description' => 'デスクトップPC', 'image_path' => 'desktop-pc-3.jpg', 'brand_name' => 'apple', 'condition_id' => 1],
            ['cat_ids' => [24],'name' => 'ドライフルーツ', 'price' => 680, 'description' => 'マンゴーのドライフルーツ', 'image_path' => 'dry-fruit.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [24],'name' => 'スナック菓子', 'price' => 128, 'description' => 'スナック菓子', 'image_path' => 'snack.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [8,13],'name' => 'ゲームボーイ', 'price' => 4800, 'description' => 'ゲームボーイアドバンス', 'image_path' => 'game-boy.jpg', 'brand_name' => 'Nintendo', 'condition_id' => 2],
            ['cat_ids' => [8,13],'name' => 'Nintendo Switch', 'price' => 21800, 'description' => 'Switch本体', 'image_path' => 'switch.jpg', 'brand_name' => 'Nintendo', 'condition_id' => 2],
            ['cat_ids' => [8,13],'name' => 'プレイステーションコントローラー', 'price' => 4800, 'description' => 'プレイステーション用コントローラー', 'image_path' => 'gamepad.jpg', 'brand_name' => 'Sony', 'condition_id' => 1],
            ['cat_ids' => [6],'name' => 'ハンドクリーム', 'price' => 780, 'description' => '香りのいいハンドクリーム', 'image_path' => 'hand-cream.jpg', 'brand_name' => 'Curel', 'condition_id' => 1],
            ['cat_ids' => [13],'name' => 'ハンドスピナー', 'price' => 1499, 'description' => 'ストレス解消グッズ', 'image_path' => 'hand-spinner.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,4],'name' => 'ハット', 'price' => 2800, 'description' => 'ファッションスタイルのハット', 'image_path' => 'hat.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,5],'name' => 'ジャケット', 'price' => 8990, 'description' => '秋服、メンズジャケット', 'image_path' => 'jacket.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,5],'name' => 'Yシャツ', 'price' => 4590, 'description' => 'メンズ用Yシャツ', 'image_path' => 'shirt.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,5],'name' => 'サングラス', 'price' => 15890, 'description' => 'メンズサングラス', 'image_path' => 'sunglasses.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,12],'name' => '子供用シューズ', 'price' => 1280, 'description' => '女の子用シューズ', 'image_path' => 'kids-shoes-1.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,12],'name' => '子供用シューズ', 'price' => 1280, 'description' => '男の子用シューズ', 'image_path' => 'kids-shoes-2.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [4,6],'name' => '口紅', 'price' => 2800, 'description' => '口紅', 'image_path' => 'lipstick.jpg', 'brand_name' => '資生堂', 'condition_id' => 1],
            ['cat_ids' => [25],'name' => 'バイク用ヘルメット', 'price' => 9800, 'description' => 'バイク用ヘルメット', 'image_path' => 'motorcyclehelmets-1.jpg', 'brand_name' => 'OGK', 'condition_id' => 1],
            ['cat_ids' => [25],'name' => 'バイク用ヘルメット', 'price' => 12800, 'description' => 'バイク用ヘルメット', 'image_path' => 'motorcyclehelmets-2.jpg', 'brand_name' => 'デイトナ', 'condition_id' => 1],
            ['cat_ids' => [25],'name' => 'バイク用ヘルメット', 'price' => 8800, 'description' => 'バイク用ヘルメット', 'image_path' => 'motorcyclehelmets-3.jpg', 'brand_name' => 'ライズ', 'condition_id' => 1],
            ['cat_ids' => [20,21],'name' => 'ノートPC', 'price' => 158900, 'description' => 'ノートブックPC', 'image_path' => 'notebook-pc.jpg', 'brand_name' => '富士通', 'condition_id' => 1],
            ['cat_ids' => [8,21],'name' => 'ゲーミングチェア', 'price' => 28900, 'description' => 'ゲーミングチェア、ゲーム用チェア、オフィスにも適している', 'image_path' => 'office-chair.jpg', 'brand_name' => 'GTRacing', 'condition_id' => 1],
            ['cat_ids' => [18],'name' => 'スマートフォン', 'price' => 58900, 'description' => 'iPhone13中古美品', 'image_path' => 'smartphone.jpg', 'brand_name' => 'apple', 'condition_id' => 1],
            ['cat_ids' => [1,5,16], 'name' => '腕時計', 'price' => 25000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'image_path' => 'watch-1.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,5,16], 'name' => '腕時計', 'price' => 18000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'image_path' => 'watch-2.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,5,16], 'name' => '腕時計', 'price' => 23000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'image_path' => 'watch-3.jpg', 'brand_name' => 'なし', 'condition_id' => 1],
            ['cat_ids' => [1,5,16], 'name' => '腕時計', 'price' => 125000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'image_path' => 'watch-4.jpg', 'brand_name' => 'アルマーニ', 'condition_id' => 1],
            ['cat_ids' => [1,5,16], 'name' => '腕時計', 'price' => 38000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'image_path' => 'watch-5.jpg', 'brand_name' => 'なし', 'condition_id' => 1],


        ];



        foreach ($products as $productData) {
            $product = Product::create([
                'user_id' => rand(1, 10),
                'condition_id' => $productData['condition_id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                'brand_name' => $productData['brand_name'],
                'description' => $productData['description'],
                'image_path' => $productData['image_path'],
                'is_sold' => false,
            ]);
        $product->categories()->attach($productData['cat_ids']);
        }
    }
}
