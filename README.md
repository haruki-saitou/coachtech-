# COACHTECH_FRIMA  

  
## テーブル設計  
※全体設計として、ER図に基づき「1対多」のリレーションを構成しています。
| Usersテーブル          |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| name               | varchar(255)     |             |            | ◯        |                |
| email              | varchar(255)     |             | ◯          | ◯        |                |
| password           | varchar(255)     |             |            | ◯        |                |
| created_at          | timestamp        |             |            |          |                |
| updated_at          | timestamp        |             |            |          |                |


| Productsテーブル       |                  |             |            |          |                |
|--------------------|------------------|-------------|------------|----------|----------------|
| カラム名               | 型                | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| id                 | unsigned bigint  | ◯           |            | ◯        |                |
| user_id            | unsigned bigint  |             |            | ◯        | users(id)      |
| name               | varchar(255)     |             |            | ◯        |                |
| price              | unsigned integer |             |            | ◯        |                |
| brand_name         | verchar(255)     |             |            |          |                |
| description        | text             |             |            | ◯        |                |
| image_path         | varchar(255)     |             |            | ◯        |                |
| category_id        | unsigned bigint  |             |            | ◯        | categories(id) |
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


## 環境構築　　  

### Dockerビルド  
- 作業ディレクトリ上に移動
- ```bash
  git clone git@github.com:haruki-saitou/coachtech-frima.git
  ```  
- ```bash
  docker compose up -d --build
  ```  

### Laravel環境構築  

- ```bash
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
- ```bash
  ./vendor/bin/sail up -d
  ```  
- ```bash
  ./vendor/bin/sail composer install
  ```  
- ```bash
  ./vendor/bin/sail artisan key:generate
  ```
- ```bash
  ./vendor/bin/sail artisan storage:link
- ```bash
  ./vendor/bin/sail artisan migrate:fresh --seed
  ```  
  
## 開発環境　  
- 会員登録画面: http://localhost/register  
- ログイン画面: http://localhost/login  
- phpMyAdmin: http://localhost:8080/  
  
## 使用技術（実行環境）  
- php 8.5.0  
- laravel 12.43.1  
- Node.js: v24.11.1  
- JavaScript (jQuery 3.x.x)  
- MySQL 8.4.7  
- Web Server: Laravel Sail (PHP 8.5.0 Built-in Server) ※将来的にNginx導入予定

## ER図  
![ER図](images/er_diagram.png)
