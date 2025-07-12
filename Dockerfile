# PHP 8.2 with Apache
FROM php:8.2-apache

# 作業ディレクトリを設定
WORKDIR /var/www/html

# 必要なパッケージとPHP拡張をインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.jsのバージョンを更新（最新LTS）
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Apacheの設定
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# DocumentRootをLaravelのpublicディレクトリに設定
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# プロジェクトファイルをコピー
COPY . /var/www/html

# PHPの設定を確認
RUN php -v && composer --version

# Composer依存関係をインストール（開発環境用）
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader --verbose

# Node.js依存関係をインストール
RUN npm install

# 権限設定
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# 開発用ポートを公開
EXPOSE 8000 5173

# 開発用のスタートアップスクリプト
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["tail", "-f", "/dev/null"]
