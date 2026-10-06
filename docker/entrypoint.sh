#!/bin/bash
# ============================================================
# Kijura Town Council — Docker entrypoint
# MariaDB (Debian native) + Apache + Laravel
# ============================================================
set -e

echo "==> [entrypoint] Kijura Town Council container starting..."

# ── Render injects PORT; Apache must listen on it ───────────
APP_PORT="${PORT:-80}"
sed -i "s/*:80/*:${APP_PORT}/g"  /etc/apache2/sites-available/000-default.conf
echo "Listen ${APP_PORT}"        > /etc/apache2/ports.conf

# ── Copy .env template ───────────────────────────────────────
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.render /var/www/html/.env
fi

# ── Inject runtime env vars into .env ───────────────────────
[ -n "${APP_KEY}" ]  && sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|"   /var/www/html/.env
[ -n "${APP_URL}" ]  && sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|"   /var/www/html/.env

# ── DB credentials ──────────────────────────────────────────
DB_ROOT_PASS="${MYSQL_ROOT_PASSWORD:-KijuraRoot2026!}"
DB_NAME="${MYSQL_DATABASE:-kijura_council}"
DB_USER="${MYSQL_USER:-kijura}"
DB_PASS="${MYSQL_PASSWORD:-KijuraDb2026!}"

sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=mysql|"    /var/www/html/.env
sed -i "s|^DB_HOST=.*|DB_HOST=127.0.0.1|"            /var/www/html/.env
sed -i "s|^DB_PORT=.*|DB_PORT=3306|"                 /var/www/html/.env
sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_NAME}|"   /var/www/html/.env
sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USER}|"   /var/www/html/.env
sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASS}|"   /var/www/html/.env

# ── Initialise MariaDB data dir (first boot only) ────────────
if [ ! -d /var/lib/mysql/mysql ]; then
    echo "==> [entrypoint] Initialising MariaDB data directory..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql > /dev/null
    echo "==> [entrypoint] MariaDB data directory initialised."
fi

# ── Fix MariaDB directory ownership ──────────────────────────
chown -R mysql:mysql /var/lib/mysql /var/run/mysqld 2>/dev/null || \
    (mkdir -p /var/run/mysqld && chown -R mysql:mysql /var/run/mysqld /var/lib/mysql)

# ── Start MariaDB temporarily for setup ──────────────────────
echo "==> [entrypoint] Starting MariaDB for setup..."
mysqld_safe --skip-networking=OFF --user=mysql &
MYSQL_PID=$!

# Wait until MariaDB is ready
for i in $(seq 1 40); do
    if mysqladmin ping -h 127.0.0.1 -u root --silent 2>/dev/null; then
        echo "==> [entrypoint] MariaDB is ready."
        break
    fi
    echo "==> [entrypoint] Waiting for MariaDB... (${i}/40)"
    sleep 2
done

# ── Create database and application user ─────────────────────
echo "==> [entrypoint] Creating database and user..."
mysql -u root -h 127.0.0.1 <<SQL
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'%'
    IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'%';
ALTER USER 'root'@'localhost' IDENTIFIED BY '${DB_ROOT_PASS}';
FLUSH PRIVILEGES;
SQL
echo "==> [entrypoint] Database ready."

# ── Laravel setup ────────────────────────────────────────────
cd /var/www/html

echo "==> [entrypoint] Generating APP_KEY..."
php artisan key:generate --force --no-interaction

echo "==> [entrypoint] Running package discovery..."
php artisan package:discover --ansi

echo "==> [entrypoint] Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "==> [entrypoint] Running migrations..."
php artisan migrate --force --no-interaction

echo "==> [entrypoint] Running seeders..."
php artisan db:seed --force --no-interaction

echo "==> [entrypoint] Creating storage symlink..."
php artisan storage:link || true

echo "==> [entrypoint] Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions after artisan writes
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# ── Stop setup MariaDB — Supervisor takes over ───────────────
echo "==> [entrypoint] Handing off to Supervisor..."
mysqladmin -u root -p"${DB_ROOT_PASS}" -h 127.0.0.1 shutdown 2>/dev/null || kill $MYSQL_PID
sleep 2

# ── Start Supervisor (MariaDB + Apache permanently) ──────────
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
