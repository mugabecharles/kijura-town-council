#!/bin/bash
# ============================================================
# Kijura Town Council — Docker entrypoint
# 1. Initialise MySQL data dir (first boot only)
# 2. Start MySQL temporarily
# 3. Create DB + user, run Laravel migrations/seed
# 4. Stop temporary MySQL
# 5. Hand off to Supervisor (MySQL + Apache permanently)
# ============================================================
set -e

echo "==> [entrypoint] Starting Kijura Town Council container..."

# ── Render injects PORT; Apache must listen on it ───────────
APP_PORT="${PORT:-80}"
sed -i "s/*:80/*:${APP_PORT}/g" /etc/apache2/sites-available/000-default.conf
echo "Listen ${APP_PORT}" > /etc/apache2/ports.conf

# ── Update supervisord Apache command with correct port ─────
sed -i "s|apache2ctl -D FOREGROUND|apache2ctl -D FOREGROUND|g" \
    /etc/supervisor/conf.d/supervisord.conf

# ── Set up .env from template if not present ────────────────
if [ ! -f /var/www/html/.env ]; then
    echo "==> [entrypoint] Copying .env.render → .env"
    cp /var/www/html/.env.render /var/www/html/.env
fi

# Inject APP_KEY from environment if Render provides it
if [ -n "${APP_KEY}" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" /var/www/html/.env
fi

# Inject APP_URL
if [ -n "${APP_URL}" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" /var/www/html/.env
fi

# ── MySQL credentials (use env vars or safe defaults) ───────
MYSQL_ROOT_PASSWORD="${MYSQL_ROOT_PASSWORD:-KijuraRoot2026!}"
MYSQL_DATABASE="${MYSQL_DATABASE:-kijura_council}"
MYSQL_USER="${MYSQL_USER:-kijura}"
MYSQL_PASSWORD="${MYSQL_PASSWORD:-KijuraDb2026!}"

# Patch .env with DB credentials
sed -i "s|^DB_HOST=.*|DB_HOST=127.0.0.1|"           /var/www/html/.env
sed -i "s|^DB_PORT=.*|DB_PORT=3306|"                 /var/www/html/.env
sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${MYSQL_DATABASE}|" /var/www/html/.env
sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${MYSQL_USER}|" /var/www/html/.env
sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${MYSQL_PASSWORD}|" /var/www/html/.env
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=mysql|"    /var/www/html/.env

# ── Initialise MySQL data directory (first boot only) ───────
MYSQL_DATA_DIR="/var/lib/mysql"
if [ ! -d "${MYSQL_DATA_DIR}/mysql" ]; then
    echo "==> [entrypoint] Initialising MySQL data directory..."
    mysqld --initialize-insecure --user=root --datadir="${MYSQL_DATA_DIR}"
    echo "==> [entrypoint] MySQL data directory initialised."
fi

# ── Start MySQL temporarily for setup ───────────────────────
echo "==> [entrypoint] Starting MySQL for setup..."
mysqld --user=root --skip-networking=0 --daemonize \
    --pid-file=/tmp/mysql-setup.pid

# Wait for MySQL to be ready
for i in $(seq 1 30); do
    if mysqladmin ping -h 127.0.0.1 --silent 2>/dev/null; then
        echo "==> [entrypoint] MySQL is ready."
        break
    fi
    echo "==> [entrypoint] Waiting for MySQL... (${i}/30)"
    sleep 2
done

# ── Create database and application user ────────────────────
echo "==> [entrypoint] Setting up database and user..."
mysql -u root -h 127.0.0.1 <<SQL
ALTER USER 'root'@'localhost' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}';
CREATE DATABASE IF NOT EXISTS \`${MYSQL_DATABASE}\`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${MYSQL_USER}'@'%'
    IDENTIFIED BY '${MYSQL_PASSWORD}';
GRANT ALL PRIVILEGES ON \`${MYSQL_DATABASE}\`.* TO '${MYSQL_USER}'@'%';
FLUSH PRIVILEGES;
SQL
echo "==> [entrypoint] Database ready."

# ── Laravel setup ───────────────────────────────────────────
cd /var/www/html

echo "==> [entrypoint] Generating APP_KEY if missing..."
php artisan key:generate --force --no-interaction

echo "==> [entrypoint] Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "==> [entrypoint] Running migrations..."
php artisan migrate --force --no-interaction

echo "==> [entrypoint] Running seeders (idempotent)..."
php artisan db:seed --force --no-interaction

echo "==> [entrypoint] Creating storage symlink..."
php artisan storage:link || true

echo "==> [entrypoint] Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions after artisan commands
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# ── Stop temporary MySQL (Supervisor will restart it) ───────
echo "==> [entrypoint] Stopping setup MySQL, handing off to Supervisor..."
mysqladmin -u root -p"${MYSQL_ROOT_PASSWORD}" -h 127.0.0.1 shutdown || true
sleep 2

# ── Start Supervisor (MySQL + Apache permanently) ───────────
echo "==> [entrypoint] Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
