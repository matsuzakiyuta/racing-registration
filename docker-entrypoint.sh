#!/bin/bash
set -e

# .envファイルがない場合は.env.exampleからコピー
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env file from .env.example"
fi

# アプリケーションキーを生成（まだ設定されていない場合）
if grep -q "APP_KEY=$" .env; then
    php artisan key:generate
    echo "Generated application key"
fi

# データベースの準備ができるまで待機
echo "Waiting for database..."
while ! mysqladmin ping -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent; do
    sleep 1
done
echo "Database is ready!"

# マイグレーションを実行
php artisan migrate --force

# ストレージリンクを作成
php artisan storage:link

# キャッシュをクリア
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Viteの開発サーバーをバックグラウンドで起動（開発環境の場合）
if [ "$APP_ENV" = "local" ] || [ "$APP_ENV" = "development" ]; then
    npm run dev &
fi

# Laravelの開発サーバーをバックグラウンドで起動
if [ "$APP_ENV" = "local" ] || [ "$APP_ENV" = "development" ]; then
    php artisan serve --host=0.0.0.0 --port=8000 &
fi

# 元のコマンドを実行
exec "$@"
