# Racing Registration System

Laravel + React + MySQL + Redisを使用したレース登録システム

## 開発環境セットアップ

### 必要なソフトウェア
- Docker
- Docker Compose

### 環境構築手順

1. リポジトリをクローン
```bash
git clone <repository-url>
cd racing-registration
```

2. 環境設定ファイルを作成
```bash
cp .env.example .env
```

3. .envファイルを編集（Docker環境用の設定）
```
DB_HOST=mysql
DB_DATABASE=racing_registration
DB_USERNAME=user
DB_PASSWORD=password

CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=redis
```

4. Dockerコンテナを起動
```bash
docker compose up -d
```

5. 依存関係をインストール
```bash
docker compose exec app composer install
docker compose exec app npm install
```

6. アプリケーションキーを生成
```bash
docker compose exec app php artisan key:generate
```

7. データベースマイグレーション
```bash
docker compose exec app php artisan migrate
```

8. Vite開発サーバーを起動
```bash
docker compose exec app npm run dev
```

### アクセス方法

- **アプリケーション**: http://localhost:8000
- **Vite開発サーバー**: http://localhost:5173
- **phpMyAdmin**: http://localhost:8080
- **MySQL**: localhost:3306
- **Redis**: localhost:6379

### 開発コマンド

```bash
# コンテナに入る
docker compose exec app bash

# Laravelコマンド実行
docker compose exec app php artisan <command>

# Composerコマンド実行
docker compose exec app composer <command>

# NPMコマンド実行
docker compose exec app npm <command>

# ログ確認
docker compose logs app
docker compose logs mysql

# コンテナ停止
docker compose down

# コンテナとボリュームを完全削除
docker compose down -v --remove-orphans
```

### サービス構成

- **app**: Laravel + React + Node.js開発環境
- **mysql**: MySQL 8.0データベース
- **phpmyadmin**: データベース管理ツール
- **redis**: キャッシュ・セッション・キュー管理

### トラブルシューティング

#### ポートが使用中の場合
```bash
# 使用中のポートを確認
lsof -i :8000
lsof -i :3306
lsof -i :8080

# プロセスを停止
kill -9 <PID>
```

#### 権限エラーの場合
```bash
# ストレージ権限を修正
docker compose exec app chmod -R 775 storage bootstrap/cache
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
```

#### データベース接続エラーの場合
```bash
# MySQLコンテナの状態確認
docker compose logs mysql

# データベース接続テスト
docker compose exec app php artisan tinker
# Tinker内で: DB::connection()->getPdo();
```
