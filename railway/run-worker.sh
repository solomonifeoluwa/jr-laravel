#!/bin/bash

echo "🧵 Starting Laravel queue worker..."

php artisan queue:work --tries=3 --timeout=90
