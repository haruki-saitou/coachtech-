<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
        'name' => 'テストユーザー',
        'email' => 'test@example.com',
        'password' => bcrypt('password'), // パスワードを「password」に設定
    ]);
        User::factory(9)->create();

        $this->call([
            CategorySeeder::class,
            ConditionSeeder::class,
            ProductSeeder::class,
            CommentSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
