<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザー情報取得：プロフィール画面に必要な情報が表示される (ID 1, 2)
     */
    public function test_user_profile_page_shows_required_info(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'image_path' => 'profiles/test_user.jpg',
        ]);

        // 出品した商品を1つ作成
        Product::factory()->create(['user_id' => $user->id, 'name' => '私が出品した商品']);

        // 購入した商品は、後の「購入テスト」で詳しくやるので、ここでは存在確認のみ

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('profiles/test_user.jpg');
        $response->assertSee('私が出品した商品');
    }

    /**
     * ユーザー情報変更：変更項目が初期値として設定されている (ID 3)
     */
    public function test_profile_edit_page_contains_existing_data(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'name' => '既存の名前',
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        // inputタグのvalue属性などに、今のデータが入っているか
        $response->assertSee('既存の名前');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
    }

    /**
     * ユーザー情報変更：プロフィール更新が成功し、データベースが書き換わる (ID 3)
     */
    public function test_user_can_update_profile(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $newData = [
            'name' => '新しい名前',
            'post_code' => '987-6543',
            'address' => '大阪府大阪市',
        ];

        // patchメソッドで更新リクエストを送る（web.phpのroute名に合わせる）
        $response = $this->actingAs($user)
            ->patch(route('profile.update'), $newData);

        $response->assertRedirect('/'); // 更新後のリダイレクト先
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '新しい名前',
            'post_code' => '987-6543',
            'address' => '大阪府大阪市',
        ]);
    }
    /**
     * メール認証：会員登録後に認証メールが送信されるか (ID 15)
     */
    public function test_verification_email_is_sent_after_registration(): void
    {
        // 1. メール送信を「フリ（Fake）」にする（実際には送らない）
        \Illuminate\Support\Facades\Notification::fake();

        // 2. 新規ユーザー登録のフリをする（ここは作成済みのルートに合わせてください）
        $userData = [
            'name' => '新規ユーザー',
            'email' => 'new@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // 登録ボタン（POST）を押す
        $this->post('/register', $userData);

        // 3. 認証メール（通知）が送られたことを確認
        // ユーザーを探して、その人に通知が飛んだかチェック
        $user = \App\Models\User::where('email', 'new@example.com')->first();
        \Illuminate\Support\Facades\Notification::assertSentTo(
            $user,
            \Illuminate\Auth\Notifications\VerifyEmail::class
        );
    }

    /**
     * メール認証：認証完了後にプロフィール画面に遷移するか (ID 15)
     */
    public function test_user_is_redirected_to_profile_after_verification(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->unverified()->create(); // 未認証のユーザーを作成

        // 認証用URLを生成（Laravel標準の機能）
        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        // 認証URLをクリックしたことにする
        $response = $this->actingAs($user)->get($verificationUrl);

        // 認証後はプロフィール設定（/mypage/profile）へ行く仕様
        $response->assertRedirect('/mypage/profile');

        // DB上の「認証日時」が記録されているか
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
