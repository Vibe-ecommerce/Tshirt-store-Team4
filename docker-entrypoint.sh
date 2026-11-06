#!/bin/bash
set -e

# Dynamically adjust Apache listening port for Render ($PORT)
if [ -n "$PORT" ]; then
    echo "Configuring Apache to listen on port $PORT..."
    sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
    sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/*.conf
fi

# Ensure storage and upload directories exist and are writable
mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
mkdir -p public/uploads/{payments,receipts,avatars} public/images/{products,banners}
chown -R www-data:www-data storage bootstrap/cache public/uploads public/images
chmod -R 775 storage bootstrap/cache public/uploads public/images

# Create public storage symlink if missing
php artisan storage:link --force || true

# Auto-run pending database migrations
php artisan migrate --force || true

# Optimize cache for production
if [ -n "$APP_KEY" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "Starting Apache web server..."
exec apache2-foreground

