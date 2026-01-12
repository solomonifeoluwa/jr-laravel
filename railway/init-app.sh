#!/bin/bash
# Exit immediately if a command exits with a non-zero status
set -e

echo "🚀 Initializing Laravel application..."

# Run migrations
php artisan migrate --force

# Clear caches
php artisan optimize:clear

# Cache Laravel components
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "✅ App initialization complete"
