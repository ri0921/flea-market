# coachtechフリマ

## 概要

「coachtechフリマ」は、ある企業が開発した独自のフリマアプリです。
10〜30代の社会人をターゲットに、誰でも簡単にアイテムの出品・購入ができることを目的としています。

- **目標**：初年度でユーザー数 1,000人の達成
- **特徴**
  - 出品・購入機能
  - ユーザー認証（Fortify）
  - Stripe による決済機能
  - 開発用メール確認（MailHog）
- **使用技術**：Laravel / Fortify / MySQL / Stripe / Docker

---

## 環境構築

### Dockerビルド
* リポジトリをクローン
```
git clone git@github.com:ri0921/flea-market.git
```
* Dockerをビルド
```
docker-compose up -d --build
```

### Laravel環境構築
* PHPコンテナに入る
```
docker-compose exec php bash
```
* Laravelパッケージのインストール
```
composer install
```
* .envファイル作成、環境変数を変更、基本設計書記載のAPIキーを追加
```
cp .env.example .env
```
```
php artisan config:clear
php artisan config:cache
```
* アプリケーションキーの生成
```
php artisan key:generate
```
* マイグレーションの実行
```
php artisan migrate
```
* シーダーの実行
```
php artisan db:seed
```
* ストレージリンクの作成
```
php artisan storage:link
```
* 画像をstorageディレクトリにコピー
```
mkdir -p src/storage/app/public/img && cp -r src/public/img/* src/storage/app/public/img/
```

### テスト用データベースの作成
* MySQLに接続
```
docker-compose exec mysql bash
```
```
mysql -u root -p
```
* データベース`demo_test`を作成
```
CREATE DATABASE demo_test;
```
* .env.testingファイルに基本設計書記載のAPIキーを追加
```
php artisan config:clear
php artisan config:cache
```
* テスト用アプリケーションキーの生成
```
php artisan key:generate --env=testing
```
* テスト用マイグレーションの実行
```
php artisan migrate --env=testing
```

### MailHog
* MailHogの起動
```
docker compose up -d mailhog
```


## テストアカウント情報

- **user01**
  - name: user01
  - email: user01@example.com
  - password: user01pass

---

- **user02**
  - name: user02
  - email: user02@example.com
  - password: user02pass

---

- **user03**
  - name: user03
  - email: user03@example.com
  - password: user03pass

---


## 使用技術
* PHP 7.4.9
* Laravel 8.83.8
* MySQL 8.0.26
* Stripe 17.1.1
* MailHog 1.0.1

## ER図
![ER図](flea-market.png)

## URL
* 開発環境：<http://localhost/>
* phpMyadmin：<http://localhost:8080/>
* MailHog：<http://localhost:8025/>
