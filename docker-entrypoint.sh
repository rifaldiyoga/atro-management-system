#!/bin/sh
set -e

# Install Composer dependencies if vendor is missing (first run or after clean)
if [ ! -f "vendor/autoload.php" ]; then
    echo "[entrypoint] Running composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Fix storage / cache permissions expected by Laravel
chmod -R 775 storage bootstrap/cache

# Create storage symlink if missing
if [ ! -L "public/storage" ]; then
    php artisan storage:link --no-interaction 2>/dev/null || true
fi

# Clear compiled config so Docker env vars are always picked up fresh
php artisan config:clear --no-interaction

echo "[entrypoint] Starting Laravel on 0.0.0.0:8000..."
exec "$@"
