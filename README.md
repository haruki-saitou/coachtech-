# COACHTECH_FRIMA  


## 使用技術・実行環境  
- **Backend** : PHP 8.5.0 / Laravel 12.43.1
- **Frontend** : JavaScript (Vanilla JS), Tailwind CSS v4.0.0, Vite v7.0.7
- **Database** : MySQL 8.4.7
- **Infrastructure** : Laravel Sail (Docker環境)
- **External APIs** : Stripe API (決済)
- **Tooling** : Node.js v24.11.1, npm
- **Web Server** : Laravel Sail (PHP 8.5.0 Built-in Server) ※将来的にNginx導入予定

---  
## 環境構築　　  

### Dockerビルド  
- 作業ディレクトリ上に移動
```bash
  git clone git@github.com:haruki-saitou/coachtech-frima.git
```  
```bash
  docker compose up -d --build
```  

### Laravel環境構築  

```bash
  cp .env.example .env
```
下記の内容に環境変数を変更  
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```
※Apple Silicon (M1/M2/M3) 及び Intel Mac/Windows の両方に対応済みです。  
```bash
  ./vendor/bin/sail up -d
```  
```bash
  ./vendor/bin/sail composer install
```  
```bash
  ./vendor/bin/sail artisan key:generate
```  
フロントエンドのライブラリ（Tailwindなど）をインストール  
```bash
  ./vendor/bin/sail npm install
```  
CSS/JavaScriptをビルド  
```bash
  ./vendor/bin/sail npm run build
```
```bash
  ./vendor/bin/sail artisan storage:link
```
```bash
  ./vendor/bin/sail artisan migrate:fresh --seed
```
```bash
./vendor/bin/sail npm run dev
```  
※ `./vendor/bin/sail npm run dev` を実行しているターミナルは、閉じずにそのままにしておいてください。  
  
---  
### メール認証の設定について  
開発環境でのメールテストには、Mailtrapを使用しています。  
  
- [Mailtrap](https://mailtrap.io/)にログインし、SMTP設定の Integrations から「Laravel 9+」を選択します。
- 表示された以下の情報を、プロジェクトの `.env` ファイルに反映してください。  
`MAIL_HOST`  
`MAIL_PORT`  
`MAIL_USERNAME`  
`MAIL_PASSWORD`  
- これにより、新規登録時の認証メールが Mailtrap の管理画面上で確認できるようになります。
  
### Stripeの設定  
Stripeへログイン  
```bash
https://dashboard.stripe.com/login
```  
設定 → 開発者 → 下記にある標準キーの  
公開可能キー : STRIPE_KEY  
シークレットキー : STRIPE_SECRET  
Stripeのテスト用APIキー(トークン)を `.env` に設定してください。  
```bash
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
```

---  
### Stripe Webhookの設定（決済状態の自動更新に必要）  
本プロジェクトでは、決済完了（カード・コンビニ等）を正確に検知するためにWebhookを使用しています。  
ローカル環境で動作確認を行うには、以下の手順で Stripe CLI を起動する必要があります。  
   
1. Stripe CLI をインストールしてください。  
2. ターミナルでStripeにログインします。  
```Bash
stripe login
```  
3. Webhookの転送を開始します。  
```Bash
stripe listen --forward-to localhost/stripe/webhook
```
※ stripe listen を実行しているターミナルは、閉じずにそのままにしておいてください。  
  
ターミナルに表示された whsec_ で始まる署名シークレットを `.env` に追記してください。  
```Bash
STRIPE_WEBHOOK_SECRET=whsec_...
```  
※stripe listen を実行している間のみ、決済後の「Sold」状態への自動更新が機能します。  
  
設定を変更したので、`.env`を保存後に設定を反映させるため、新しいターミナルで以下のコマンドを打ってください。  
```bash
./vendor/bin/sail artisan config:clear
```  
※キャッシュをクリアしたので、そのままブラウザで動作確認してください。  
  
--- 
### テスト用ログイン情報  
- name :
```bash
テストユーザー
```
- email :
```bash
test@example.com
```
- password : 
```bash
password
```
※ migrate:fresh --seed 実行後に利用可能になります。  

---   
## テストケース  
本プロジェクトでは、テストケース一覧の要件に基づいた全16項目の自動テストを実装しています。  
  
### テストの実行方法
```Bash
./vendor/bin/sail artisan test
```
  
### テストケース一覧
設計書に基づいた全16項目の自動テストを実装しています。
  
| テストファイル | 対応ID | 検証内容の要約 |
| :--- | :--- | :--- |
| **AuthTest** | 1, 2, 3, 16 | 会員登録・ログイン・ログアウト・メール認証 |
| **ExhibitionTest** | 15 | 商品出品（画像保存・複数カテゴリ・バリデーション） |
| **ProductTest** | 4, 5, 6, 7, 8, 9 | 商品一覧・検索・詳細・いいね・コメント |
| **ProfileTest** | 14 | プロフィール更新処理 |
| **PurchaseTest** | 10, 11, 12 | 購入確定・支払い方法選択・配送先連動 |
| **UserTest** | 13, 14, 16 | マイページ表示・初期値保持・メール認証フロー |
  
---  
## 動作確認フロー
1. `http://localhost/register` で新規会員登録を行う。
2. `Mailtrap` に届く認証メール内のリンクをクリックする。
3. 自動でプロフィール設定画面へ移動することを確認後、「画像」、「郵便番号」、「住所」、「建物名」を登録する。
4. 商品を出品し、画像が表示されるか確認する。
5. Stripeのテスト
カード番号 : 4242 4242 4242 4242  
有効期限 : 未来の日付であれば問題ありません。
cvc : 適当な番号で問題ありません。
  
---  
## 一覧表示仕様
- 取得方式：JavaScript (fetch API) による無限スクロール
- 読み込み単位：1ページ 20件 (paginate(20))
      
---  
## 開発環境　  
MacBook Air M4を使用しています。  
- 会員登録画面: http://localhost/register
- ログイン画面: http://localhost/login
- メール認証誘導画面: http://localhost/email/verify
- 商品一覧画面（トップ画面）: http://localhost/
- 商品詳細画面: http://localhost/item/{item_id}
- 商品出品画面: http://localhost/sell
- 商品購入画面: http://localhost/purchase/{item_id}
- 送付先住所変更画面: http://localhost/purchase/address/{item_id}?payment_method=
- プロフィール画面: http://localhost/mypage
- プロフィール編集画面（設定画面）: http://localhost/mypage/profile
- phpMyAdmin: http://localhost:8080/
  
---  
## テーブル設計  
※全体設計として、ER図に基づきリレーションを構成しています。
- Users(1) : Products(0または多)
- Users(1) : Comments(0または多)
- Users(1) : Likes(0または多)
- Products(1) : Orders(0または1)
- Products(多) : Conditions(1)
- Products(1) : Comments(0または多)
- Products(1) : Likes(0または多)
- Products(1) : category_product(1または多)
- category_product(多) : Categories(1)
  
---  
| Usersテーブル       |       |           |             |            |          |                |
|--------------------|-------|------------------|-------------|------------|----------|----------------|
| カラム名            | 論理名 | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | ID    | bigint unsigned  | PK          |            | ◯        |                |
| name               | 氏名   | varchar(255)     |             |            | ◯        |                |
| email              | メールアドレス | varchar(255)     |             | UQ         | ◯        |                |
| email_verified_at  | メール認証日時 | varchar(255)     |             |            |          |                |
| password           | パスワード    | varchar(255)     |             |            | ◯        |                |
| image_path         | プロフィール画像パス | varchar(255)     |             |            |          |                |
| post_code          | 郵便番号      | varchar(255)     |             |            |          |                |
| address            | 住所         | varchar(255)     |             |            |          |                |
| building           | 建物名       | varchar(255)     |             |            |          |                |
| remember_token     | ログイン保持用トークン            |varchar(100)     |             |            | ◯        |                |
| created_at         | 作成日時            |timestamp        |             |            | ◯        |                |
| updated_at         | 更新日時            |timestamp        |             |            | ◯        |                |


| Productsテーブル     |        |                  |             |            |          |                |
|--------------------|--------|------------------|-------------|------------|----------|----------------|
| カラム名            | 論理名 | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | ID | bigint unsigned  | PK          |            | ◯        |                |
| user_id            | 出品者ID | bigint unsigned  |             |            | ◯        | users(id)      |
| condition_id       | 商品の状態ID | bigint unsigned  |             |            | ◯        | conditions(id) |
| name               | 商品名 | varchar(255)     |             |            | ◯        |                |
| price              | 価格 | unsigned integer |             |            | ◯        |                |
| brand_name         | ブランド名 | varchar(255)     |             |            |          |                |
| description        | 商品説明 | text             |             |            | ◯        |                |
| image_path         | 商品画像パス | varchar(255)     |             |            | ◯        |                |
| is_sold            | 販売ステータス | boolean          |             |            | ◯        |                |
| created_at         | 作成日時          |timestamp        |             |            | ◯        |                |
| updated_at         | 更新日時          |timestamp        |             |            | ◯        |                |


| Categoriesテーブル   |    |                  |             |            |          |                |
|--------------------|-----|------------------|-------------|------------|----------|----------------|
| カラム名            | 論理名 | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | ID | bigint unsigned  | PK          |            | ◯        |                |
| name               | カテゴリー名 | varchar(255)     |             |            | ◯        |                |
| created_at         | 作成日時 | timestamp        |             |            | ◯        |                |
| updated_at         | 更新日時 | timestamp        |             |            | ◯        |                |


| Commentsテーブル     |      |                  |             |            |          |                |
|--------------------|-------|------------------|-------------|------------|----------|----------------|
| カラム名            | 論理名 | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | ID | bigint unsigned  | PK          |            | ◯        |                |
| user_id            | コメントユーザーID | bigint unsigned  |             |            | ◯        | users(id)      |
| product_id         | コメント商品ID | bigint unsigned  |             |            | ◯        | products(id)   |
| comment            | コメント | varchar(255)     |             |            | ◯        |                |
| created_at         | 作成日時        | timestamp        |             |            | ◯        |                |
| updated_at         | 更新日時        | timestamp        |             |            | ◯        |                |


| Conditionsテーブル   |      |                  |             |            |          |                |
|--------------------|-------|------------------|-------------|------------|----------|----------------|
| カラム名            | 論理名 | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | ID | bigint unsigned  | PK          |            | ◯        |                |
| name               | 商品状態 | varchar(255)     |             |            | ◯        |                |
| created_at         | 作成日時        | timestamp        |             |            | ◯        |                |
| updated_at         | 更新日時        | timestamp        |             |            | ◯        |                |


| Ordersテーブル       |       |                  |             |            |          |                |
|--------------------|--------|------------------|-------------|------------|----------|----------------|
| カラム名            | 論理名 | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | ID | bigint unsigned  | PK          |            | ◯        |                |
| user_id            | 購入者ID | bigint unsigned  |             |            | ◯        | users(id)      |
| product_id         | 購入商品ID | bigint unsigned  |             |            | ◯        | products(id)   |
| payment_method     | 支払い方法 | varchar(255)     |             |            | ◯        |                |
| post_code          | 配送先郵便番号 | varchar(255)     |             |            | ◯        |                |
| address            | 配送先住所 | varchar(255)     |             |            | ◯        |                |
| building           | 配送先建物名 | varchar(255)     |             |            | ◯        |                |
| created_at         | 作成日時           | timestamp        |             |            | ◯        |                |
| updated_at         | 更新日時           | timestamp        |             |            | ◯        |                |


| Likesテーブル        |       |                  |             |            |          |                |
|--------------------|--------|------------------|-------------|------------|----------|----------------|
| カラム名            | 論理名 | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | ID | bigint unsigned  | PK          |            | ◯        |                |
| user_id            | お気に入りしたユーザーID | bigint unsigned  |             |            | ◯        | users(id)      |
| product_id         | お気に入りした商品ID | bigint unsigned  |             |            | ◯        | products(id)   |
| created_at         | 作成日時                  | timestamp        |             |            | ◯        |                |
| updated_at         | 更新日時                  | timestamp        |             |            | ◯        |                |


| category_productテーブル |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名             | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | ID | bigint unsigned  | PK          |            | ◯        |                |
| category_id        | カテゴリーID | bigint unsigned  |             |            | ◯        | categories(id)  |
| product_id         | 商品ID | bigint unsigned  |             |            | ◯        | products(id)   |
| created_at         | 作成日時 | timestamp        |             |            | ◯        |                |
| updated_at         | 更新日時 | timestamp        |             |            | ◯        |                |
  
---  
## ER図  
![ER図](images/er_diagram.png)  
  
---  
## トラブルシューティング
`./vendor/bin/sail npm run dev` 実行時に  
`Cannot find module @rollup/rollup-linux-arm64-gnu` と出る場合  
Docker(Sail)環境とローカル環境の依存関係の不整合が原因です。  
以下の手順で依存関係をリセットしてください。  
  
**1. 念のため、現在動いているSailを停止させます**  
```bash
./vendor/bin/sail stop
```  
**2. 古い部品（フォルダ）と、設定の記録（ファイル）を削除します**  
※ Mac/Linuxのコマンドです。慎重に実行してください。  
```bash
rm -rf node_modules package-lock.json
```  
**3. Sailをバックグラウンドで起動します**  
```bash
./vendor/bin/sail up -d
```   
**4. 改めて部品をインストールし直します（ここが重要です！）**  
```bash
./vendor/bin/sail npm install
```  
**5. 再度、起動を試みます** 
```bash
./vendor/bin/sail npm run dev
```  
   
