# ============================================================
# Kijura Town Council — Single-container Docker image
# PHP 8.3 + Apache + MariaDB (embedded, Debian Bookworm native)
# ============================================================
FROM php:8.3-apache

# ── Cache bust — increment to force full rebuild ─────────────
ARG CACHE_BUST=3

# ── Environment ──────────────────────────────────────────────
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1 \
    APP_ENV=production

# ── System packages + MariaDB ────────────────────────────────
RUN apt-get update && apt-get install -y --no-install-recommends \
        mariadb-server \
        mariadb-client \
        libpng-dev \
        libjpeg-dev \
        libwebp-dev \
        libfreetype6-dev \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        unzip \
        curl \
        git \
        supervisor \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        gd \
        zip \
        intl \
        mbstring \
        xml \
        bcmath \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ── Composer ─────────────────────────────────────────────────
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# ── Apache ───────────────────────────────────────────────────
RUN a2enmod rewrite headers
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# ── PHP config ───────────────────────────────────────────────
COPY docker/php.ini /usr/local/etc/php/conf.d/kijura.ini

# ── MariaDB config ───────────────────────────────────────────
COPY docker/mysql.cnf /etc/mysql/conf.d/kijura.cnf

# ── Supervisor ───────────────────────────────────────────────
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ── Application code ─────────────────────────────────────────
WORKDIR /var/www/html

# Copy composer files first for layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies — no dev, no scripts at all during build
RUN composer install \
        --no-dev \
        --optimize-autoloader \
        --no-interaction \
        --no-scripts \
        --no-plugins

# Copy the rest of the application
COPY . .

# ── Directories + permissions ────────────────────────────────
RUN mkdir -p \
        storage/app/public \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/cache/data \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# ── Entrypoint ───────────────────────────────────────────────
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
