<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'ファッション',
            '家電',
            'インテリア',
            'レディース',
            'メンズ',
            'コスメ',
            '本',
            'ゲーム',
            'スポーツ',
            'アウトドア',
            'キッチン',
            'ベビー・キッズ',
            'おもちゃ',
            'ハンドメイド',
            'アクセサリー',
            '時計',
            '自転車',
            'スマホ・タブレット',
            'カメラ',
            'PC・PC周辺機器',
            'オフィス用品',
            '楽器',
            'ペット用品',
            '食品・飲料',
            '車・バイク用品',
            'その他',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }
    }
}
