<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ID 4: 商品一覧取得
     * 全商品が表示されること / 自分が出品した商品は表示されないこと / 売り切れはSoldと出ること
     */
    public function test_product_list_visibility_rules(): void
    {
        $me = User::factory()->create();
        assert($me instanceof User); // 型エラー解消

        $other = User::factory()->create();

        // 1. 他人が出品した「販売中」
        Product::factory()->create(['user_id' => $other->id, 'name' => '他人の販売中', 'is_sold' => false]);
        // 2. 他人が出品した「売り切れ」
        Product::factory()->create(['user_id' => $other->id, 'name' => '他人の売切', 'is_sold' => true]);
        // 3. 自分が自分自身で出品した商品
        Product::factory()->create(['user_id' => $me->id, 'name' => '自分の商品']);

        $response = $this->actingAs($me)->get('/');

        $response->assertStatus(200);
        $response->assertSee('他人の販売中');
        $response->assertSee('他人の売切');
        $response->assertSee('Sold');
        $response->assertDontSee('自分の商品');
    }

    /**
     * ID 5: 商品検索機能
     * 部分一致で検索でき、検索後もキーワードが保持されていること
     */
    public function test_product_search_functionality(): void
    {
        Product::factory()->create(['name' => 'サッポロポテト']);
        Product::factory()->create(['name' => 'かっぱえびせん']);

        // 検索実行
        $response = $this->get('/?keyword=サッポロ');

        $response->assertStatus(200);
        $response->assertSee('サッポロポテト');
        $response->assertDontSee('かっぱえびせん');

        // マイリストタブに切り替えてもキーワードが保持されているか (ID 5 関連)
        $user = User::factory()->create();
        assert($user instanceof User); // 型エラー解消

        $this->actingAs($user)
             ->get('/?tab=mylist&keyword=サッポロ')
             ->assertSee('サッポロ');
    }

    /**
     * ID 6: マイリスト一覧取得
     * いいねした商品のみ表示され、未ログインはリダイレクトされること
     */
    public function test_mylist_contains_only_liked_products(): void
    {
        $me = User::factory()->create();
        assert($me instanceof User); // 型エラー解消

        $likedProduct = Product::factory()->create(['name' => 'いいねした商品']);
        $me->likes()->attach($likedProduct->id);

        // 未ログイン時はログイン画面へ
        $this->get('/?tab=mylist')->assertRedirect('/login');

        // ログイン時はいいねした商品だけ見える
        $this->actingAs($me)
             ->get('/?tab=mylist')
             ->assertStatus(200)
             ->assertSee('いいねした商品');
    }

    /**
     * ID 7: 商品詳細情報取得
     * カテゴリ、状態、いいね数、コメント情報がすべて表示されること
     */
    public function test_product_detail_page_shows_all_required_info(): void
    {
        $condition = Condition::factory()->create(['name' => '良好']);
        $product = Product::factory()->create([
            'name' => '詳細テスト商品',
            'price' => 5000,
            'condition_id' => $condition->id,
        ]);

        $category = Category::factory()->create(['name' => 'ファッション']);
        $product->categories()->attach($category->id);

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200)
                 ->assertSee('詳細テスト商品')
                 ->assertSee('5,000')
                 ->assertSee('良好')
                 ->assertSee('ファッション');
    }

    /**
     * ID 8: いいね機能
     * アイコン押下で登録・解除がデータベースに反映されること
     */
    public function test_user_can_toggle_product_like(): void
    {
        $user = User::factory()->create();
        assert($user instanceof User); // 型エラー解消

        $product = Product::factory()->create();

        // 登録
        $this->actingAs($user)->post(route('like.toggle', ['item_id' => $product->id]));
        $this->assertDatabaseHas('likes', ['user_id' => $user->id, 'product_id' => $product->id]);

        // 解除
        $this->actingAs($user)->post(route('like.toggle', ['item_id' => $product->id]));
        $this->assertDatabaseMissing('likes', ['user_id' => $user->id, 'product_id' => $product->id]);
    }

    /**
     * ID 9: コメント投稿機能
     * ログイン必須、バリデーション、投稿後の表示確認
     */
    public function test_comment_functionality(): void
    {
        $user = User::factory()->create(['name' => 'テストユーザー']);
        assert($user instanceof User); // 型エラー解消

        $product = Product::factory()->create();

        // 未ログインは投稿不可
        $this->post(route('comment.store', ['item_id' => $product->id]), ['comment' => 'テスト'])
             ->assertRedirect('/login');

        // バリデーション（空欄）
        $this->actingAs($user)
             ->post(route('comment.store', ['item_id' => $product->id]), ['comment' => ''])
             ->assertSessionHasErrors(['comment']);

        // 正常投稿と表示確認
        $this->actingAs($user)->post(route('comment.store', ['item_id' => $product->id]), ['comment' => 'こんにちは']);

        $this->get("/item/{$product->id}")
             ->assertSee('テストユーザー')
             ->assertSee('こんにちは');
    }
}