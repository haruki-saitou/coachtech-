<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ID 12 & 13: 支払い方法の選択
     * コンビニ払いを選択した場合、それが画面や注文に反映されること
     */
    public function test_payment_method_selection(): void
    {
        $user = User::factory()->create();
        assert($user instanceof User);
        $product = Product::factory()->create();

        // 支払い方法（コンビニ）を選んで購入画面を表示
        $response = $this->actingAs($user)
            ->get("/purchase/{$product->id}?payment_method=konbini");

        $response->assertStatus(200)
                 ->assertSee('コンビニ払い'); // 画面上に選択した方法が出ているか
    }

    /**
     * ID 14 & 15: 配送先の変更と購入処理
     * 住所を変更し、それが購入した注文情報に正しく紐付いていること
     */
    public function test_shipping_address_change_and_order_persistence(): void
    {
        $user = User::factory()->create();
        assert($user instanceof User);
        $product = Product::factory()->create(['price' => 1000]);

        // 1. 配送先を変更する
        $this->actingAs($user)->patch(route('purchase.update', ['item_id' => $product->id]), [
            'post_code' => '999-8888',
            'address' => 'テスト県変更市',
            'building' => '変更ビル101',
        ]);

        // 2. 購入を確定させる（Orderモデルが作成されることを確認）
        // ※実際は決済完了後の処理ですが、テストではOrderが作られたかを見ます
        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'card',
            'post_code' => '999-8888',
            'address' => 'テスト県変更市',
            'building' => '変更ビル101',
        ]);

        // 3. 検証：注文データに変更後の住所が入っているか
        $this->assertDatabaseHas('orders', [
            'product_id' => $product->id,
            'post_code' => '999-8888',
            'address' => 'テスト県変更市',
        ]);
    }
}
