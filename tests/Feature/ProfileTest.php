<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ID 11: プロフィール設定（更新機能）
     * 名前、郵便番号、住所、ビル名が正しく保存され、トップページへ戻ること
     */
    public function test_profile_can_be_updated(): void
    {
        // 1. 準備：ログインユーザー
        $user = User::factory()->create();
        assert($user instanceof User);

        // 2. 実行：プロフィール更新リクエスト
        // ※ルート名は route('profile.update') など、あなたの設定に合わせてください
        $response = $this->actingAs($user)->patch('/mypage/profile', [
            'name' => '新しい名前',
            'post_code' => '123-4567',
            'address' => '東京都新宿区...',
            'building' => 'テストビル101',
        ]);

        // 3. 検証：リダイレクト先とデータベースの内容
        $response->assertRedirect('/'); // 設計書の期待値に合わせて調整

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '新しい名前',
            'post_code' => '123-4567',
            'address' => '東京都新宿区...',
            'building' => 'テストビル101',
        ]);
    }
}
