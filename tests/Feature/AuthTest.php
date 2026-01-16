<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ID 1: 会員登録機能のバリデーションと登録処理
     */
    public function test_registration_validation_and_success(): void
    {
        // 1. 全項目が未入力の場合にエラーが出るか確認
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);
        // name, email, password, password_confirmation 各項目にエラーがあることを確認
        $response->assertSessionHasErrors(['name', 'email', 'password', 'password_confirmation']);

        // 2. パスワードが確認用と一致しない場合
        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different_password',
        ]);
        $response->assertSessionHasErrors(['password']);

        // 3. パスワードが7文字以下（8文字未満）の場合
        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);
        $response->assertSessionHasErrors(['password']);

        // 4. 正しい情報を入力した場合、登録されてプロフィール画面へ行くか
        $response = $this->post('/register', [
            'name' => '成功太郎',
            'email' => 'success@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated(); // ログイン状態になったか
        $response->assertRedirect('/mypage/profile'); // 指定の画面へ飛んだか
        $this->assertDatabaseHas('users', ['email' => 'success@example.com']); // DBに保存されたか
    }

    /**
     * ID 2: ログイン機能 / ID 3: ログアウト機能
     */
    public function test_login_logout_flow(): void
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password123')
        ]);

        // ID 2: 未入力バリデーション
        $this->post('/login', [])->assertSessionHasErrors(['email', 'password']);

        // ID 2: ログイン成功
        $response = $this->post('/login', [
            'email' => 'login@example.com',
            'password' => 'password123'
        ]);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/mypage/profile');

        // ID 3: ログアウト成功
        $response = $this->post('/logout');
        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * ID 16: メール認証機能
     */
    public function test_email_verification_flow(): void
    {
        Notification::fake();

        // 会員登録をしてメールが飛ぶか確認
        $this->post('/register', [
            'name' => '認証テスト',
            'email' => 'verify@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'verify@example.com')->first();
        Notification::assertSentTo($user, VerifyEmail::class);

        // 認証URLを叩いてプロフィール画面へ行くか確認
        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
            'id' => $user->id,
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $this->actingAs($user)->get($url)->assertRedirect('/mypage/profile');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
