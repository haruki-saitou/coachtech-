<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ID 10: 出品商品情報登録
     * 商品名、ブランド、説明、価格、状態、カテゴリ、画像が正しく保存されること
     */
    public function test_user_can_list_new_product(): void
    {
        // 1. 準備：ログインユーザー、カテゴリ、商品の状態
        $user = User::factory()->create();
        assert($user instanceof User); // 型エラー解消

        $cat1 = Category::factory()->create(['name' => 'ファッション']);
        $cat2 = Category::factory()->create(['name' => 'レディース']);
        $condition = Condition::factory()->create(['name' => '良好']);

        // 画像の保存先をシミュレート（Fake）
        Storage::fake('public');
        $file = UploadedFile::fake()->image('product.jpg');

        // 2. 実行：出品フォームへのPOST送信
        $productData = [
            'name' => 'テスト出品商品',
            'brand_name' => 'ブランドX',
            'description' => 'これはテスト出品の説明文です。',
            'price' => 1500,
            'condition_id' => $condition->id,
            'categories' => [$cat1->id, $cat2->id], // 複数カテゴリ
            'image_path' => $file,
        ];

        $response = $this->actingAs($user)->post('/sell', $productData);

        // 3. 検証：リダイレクトとデータベース確認
        $product = Product::latest('id')->first();
        $response->assertRedirect('/item/' . $product->id);

        $this->assertDatabaseHas('products', [
            'name' => 'テスト出品商品',
            'brand_name' => 'ブランドX',
            'price' => 1500,
            'user_id' => $user->id,
        ]);

        // カテゴリが2つ紐付いているか確認
        $this->assertCount(2, $product->categories()->get());

        // 画像がディスクに保存されているか確認
        $this->assertTrue(Storage::disk('public')->exists($product->image_path));
    }
}
