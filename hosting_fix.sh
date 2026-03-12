#!/bin/bash

echo "🔧 Fixing Laravel Hosting Issues..."
echo "=================================="

# Navigate to project directory
cd /var/www/Arow_ecommerce

echo "📦 Step 1: Reinstall dependencies..."
rm -rf vendor/
composer install --no-dev --optimize-autoloader

echo "📊 Step 2: Install specific packages..."
composer require phpoffice/phpspreadsheet
composer require maatwebsite/excel

echo "🔄 Step 3: Regenerate autoloader..."
composer dump-autoload

echo "🗂️ Step 4: Set permissions..."
chmod -R 755 vendor/
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/

echo "🧹 Step 5: Clear all caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "⚡ Step 6: Optimize for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔗 Step 7: Create storage link..."
php artisan storage:link

echo "🔑 Step 8: Generate app key (if needed)..."
php artisan key:generate

echo "✅ Fix completed!"
echo "=================="
echo "Try accessing your website now."

# Test if CSV class is available
echo "🧪 Testing PhpSpreadsheet CSV class..."
php -r "require_once 'vendor/autoload.php'; if (class_exists('PhpOffice\PhpSpreadsheet\Reader\Csv')) { echo '✅ CSV class found!'; } else { echo '❌ CSV class NOT found!'; }"

echo ""
echo "📋 If still error, check:"
echo "1. PHP version (should be 8.1+ for Laravel 10)"
echo "2. Memory limit in php.ini"
echo "3. File permissions"
echo "4. Error logs: tail -50 storage/logs/laravel.log"
