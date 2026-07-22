#!/bin/bash

# Hiranya VPS Deployment Script
# Run this on your server to pull changes and reset directory permissions.

set -e

PROJECT_DIR="/var/www/hiranya"
PHP_SERVICE="php8.2-fpm"

echo "=== Starting Hiranya Deployment ==="

cd "$PROJECT_DIR"

# 1. Pull changes
echo "Pulling latest code changes from Git..."
git pull origin main

# 2. Install/update Composer dependencies
if [ -f "composer.json" ]; then
    echo "Installing Composer packages..."
    composer install --no-dev --optimize-autoloader
fi

# 3. Secure permissions for uploads and logs
echo "Verifying permissions for dynamic folders..."
mkdir -p uploads logs
sudo chown -R www-data:www-data uploads logs
sudo chmod -R 775 uploads logs

# 4. Restart services
echo "Restarting PHP-FPM service to clear OPcache..."
sudo systemctl restart "$PHP_SERVICE"

echo "=== Deployment Successfully Completed ==="
exit 0
