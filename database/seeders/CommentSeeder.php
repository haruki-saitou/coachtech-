<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::create([
            'user_id' => 2,
            'product_id' => 1,
            'comment' => 'こちらの商品の購入を検討しているのですが、状態について詳しく教えていただけますか？',
        ]);

        Comment::create([
            'user_id' => 1,
            'product_id' => 1,
            'comment' => 'コメントありがとうございます。 商品は目立った傷や汚れはなく、非常に良好な状態です。もし宜しければご検討よろしくお願いいたします。',
        ]);

        for ($i = 0; $i < 10; $i++) {
            Comment::create([
                'user_id' => rand(1, 10),
                'product_id' => rand(2, 10),
                'comment' => 'この商品の状態について詳しく教えていただけますか？',
            ]);
        }
    }
}