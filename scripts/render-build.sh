#!/usr/bin/env bash
# =============================================================
# Kijura Town Council — Render.com build script
# Runs on every deploy. PHP 8.3+ with PostgreSQL.
# =============================================================
set -euo pipefail

echo "==> Installing PHP dependencies (no dev)..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Copying .env from template..."
cp .env.render .env 2>/dev/null || cp .env.example .env

echo "==> Setting APP_KEY..."
php artisan key:generate --force

echo "==> Clearing old caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "==> Running database migrations..."
php artisan migrate --force

echo "==> Running database seeders (first deploy only — idempotent)..."
php artisan db:seed --force

echo "==> Creating storage symlink..."
php artisan storage:link || true

echo "==> Creating required directories..."
mkdir -p storage/app/public \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache/data \
         storage/logs \
         public/css \
         public/js \
         public/images/placeholders
chmod -R 775 storage bootstrap/cache

echo "==> Caching config, routes and views for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Build complete."
