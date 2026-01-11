# COACHTECH_FRIMA  

  
## テーブル設計  
※全体設計として、ER図に基づき「1対多」または「多対多」のリレーションを構成しています。
| Usersテーブル          |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名            | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| name               | varchar(255)     |             |            | ◯        |                |
| email              | varchar(255)     |             | ◯          | ◯        |                |
| password           | varchar(255)     |             |            | ◯        |                |
| image_path         | varchar(255)     |             |            |          |                |
| post_code          | varchar(255)     |             |            | ◯        |                |
| address            | varchar(255)     |             |            | ◯        |                |
| building           | varchar(255)     |             |            |          |                |
| created_at         | timestamp        |             |            |          |                |
| updated_at         | timestamp        |             |            |          |                |


| Productsテーブル       |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| user_id            | unsigned bigint  |             |            | ◯        | users(id)      |
| name               | varchar(255)     |             |            | ◯        |                |
| price              | unsigned integer |             |            | ◯        |                |
| brand_name         | varchar(255)     |             |            |          |                |
| description        | text             |             |            | ◯        |                |
| image_path         | varchar(255)     |             |            | ◯        |                |
| condition_id       | unsigned bigint  |             |            | ◯        | conditions(id) |
| is_sold            | boolean          |             |            | ◯        |                |
| created_at          | timestamp        |             |            |          |                |
| updated_at          | timestamp        |             |            |          |                |


| Categoriesテーブル     |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| name               | varchar(255)     |             |            | ◯        |                |
| created_at          | timestamp        |             |            |          |                |
| updated_at          | timestamp        |             |            |          |                |


| Commentsテーブル |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| user_id            | unsigned bigint  |             |            | ◯        | users(id)      |
| product_id         | unsigned bigint  |             |            | ◯        | products(id)   |
| comment            | varchar(255)     |             |            | ◯        |                |
| created_at          | timestamp        |             |            |          |                |
| updated_at          | timestamp        |             |            |          |                |


| Conditionsテーブル     |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| name               | varchar(255)     |             |            | ◯        |                |
| created_at          | timestamp        |             |            |          |                |
| updated_at          | timestamp        |             |            |          |                |


| Ordersテーブル         |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| user_id            | unsigned bigint  |             |            | ◯        | users(id)      |
| product_id         | unsigned bigint  |             |            | ◯        | products(id)   |
| payment_method     | varchar(255)     |             |            | ◯        |                |
| created_at          | timestamp        |             |            |          |                |
| updated_at          | timestamp        |             |            |          |                |


| Likesテーブル     |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| user_id            | unsigned bigint  |             |            | ◯        | users(id)      |
| product_id         | unsigned bigint  |             |            | ◯        | products(id)   |
| created_at          | timestamp        |             |            |          |                |
| updated_at          | timestamp        |             |            |          |                |


| category_productテーブル     |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| category_id        | unsigned bigint  |             |            | ◯        | categories(id)  |
| product_id         | unsigned bigint  |             |            | ◯        | products(id)   |
| created_at          | timestamp        |             |            |          |                |
| updated_at          | timestamp        |             |            |          |                |


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
   
### メール認証の設定について  
開発環境でのメールテストには、Mailtrapを使用しています。  
  
- [Mailtrap](https://mailtrap.io/)にログインし、SMTP設定の **Integrations** から 「Laravel 9+」 を選択します。
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
ターミナルに表示された whsec_ で始まる署名シークレットを `.env` に追記してください。  
```Bash
STRIPE_WEBHOOK_SECRET=whsec_...
```  
※stripe listen を実行している間のみ、決済後の「Sold」状態への自動更新が機能します。  
  
設定を変更したので、`.env`を保存後に設定を反映させるため、ターミナルで以下のコマンドを打ってください。  
```bash
./vendor/bin/sail artisan config:clear
```
  
## 開発環境　  
- 会員登録画面: http://localhost/register  
- ログイン画面: http://localhost/login  
- 商品一覧画面: http://localhost/  
- phpMyAdmin: http://localhost:8080/
  
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
  
  
## 使用技術（実行環境）  
- php 8.5.0  
- laravel 12.43.1  
- Node.js: v24.11.1
- Stripe API (決済機能)  
- JavaScript (jQuery 3.x.x)  
- MySQL 8.4.7  
- Web Server: Laravel Sail (PHP 8.5.0 Built-in Server) ※将来的にNginx導入予定
  
## 動作確認フロー
1. `http://localhost/register` で新規会員登録を行う。
2. `Mailtrap` に届く認証メール内のリンクをクリックする。
3. プロフィール設定で「画像」、「郵便番号」、「住所」、「建物名」を登録する。
4. 商品を出品し、画像が表示されるか確認する。
5. Stripeのテスト
カード番号 : 4242 4242 4242 4242  
有効期限 : 未来の日付であれば問題ありません。
cvc : 適当な番号で問題ありません。
  
## ER図  
![ER図](images/er_diagram.png)
