#!/bin/bash

echo "🔧 Fixing Laravel for PHP 8.2.30..."
echo "==================================="

# Navigate to project directory
cd /var/www/Arow_ecommerce

echo "📦 Step 1: Update composer.json for PHP 8.2 compatibility..."
# Update composer.json to use compatible versions
cat > composer.json << 'EOF'
{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "require": {
        "php": "^8.1",
        "guzzlehttp/guzzle": "^7.2",
        "laravel/framework": "^10.0",
        "laravel/sanctum": "^3.3",
        "laravel/tinker": "^2.8",
        "maatwebsite/excel": "^3.1",
        "spatie/laravel-image-optimizer": "^1.7",
        "livewire/livewire": "^3.0",
        "intervention/image": "^3.0"
    },
    "require-dev": {
        "fakerphp/faker": "^1.9.1",
        "laravel/pail": "^1.0",
        "laravel/pint": "^1.0",
        "laravel/sail": "^1.18",
        "mockery/mockery": "^1.4.4",
        "nunomaduro/collision": "^7.0",
        "phpunit/phpunit": "^10.1",
        "spatie/laravel-ignition": "^2.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
EOF

echo "🗑️ Step 2: Clean up..."
rm -rf vendor/
rm composer.lock

echo "📦 Step 3: Install compatible packages..."
composer install --no-dev --optimize-autoloader

echo "🔧 Step 4: Install specific compatible versions..."
composer require maatwebsite/excel:"^3.1" --no-update
composer require phpoffice/phpspreadsheet:"^1.29" --no-update
composer update --no-dev --optimize-autoloader

echo "🔄 Step 5: Regenerate autoloader..."
composer dump-autoload

echo "🗂️ Step 6: Set permissions..."
chmod -R 755 vendor/
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/

echo "🧹 Step 7: Clear all caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "⚡ Step 8: Optimize for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔗 Step 9: Create storage link..."
php artisan storage:link

echo "🔑 Step 10: Generate app key..."
php artisan key:generate

echo "✅ Fix completed!"
echo "=================="

# Test if CSV class is available
echo "🧪 Testing PhpSpreadsheet CSV class..."
php -r "require_once 'vendor/autoload.php'; if (class_exists('PhpOffice\PhpSpreadsheet\Reader\Csv')) { echo '✅ CSV class found!'; } else { echo '❌ CSV class NOT found!'; }"

echo ""
echo "📋 PHP Version Info:"
php -v

echo ""
echo "📊 Composer Info:"
composer --version
