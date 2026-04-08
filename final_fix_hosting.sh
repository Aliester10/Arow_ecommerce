#!/bin/bash

echo "🔧 Final Fix for Laravel Hosting..."
echo "================================="

# Navigate to project directory
cd /var/www/Arow_ecommerce

echo "📝 Step 1: Fix bootstrap/app.php for Laravel 10..."
# Replace bootstrap/app.php with Laravel 10 compatible version
cat > bootstrap/app.php << 'EOF'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
EOF

echo "📦 Step 2: Update composer.json for Laravel 10 (without configure method)..."
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

echo "🗑️ Step 3: Clean up and reinstall..."
rm -rf vendor/
rm composer.lock

echo "📦 Step 4: Install Laravel 10 compatible packages..."
composer install --no-dev --optimize-autoloader

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

echo "✅ Final fix completed!"
echo "======================"

# Test if Laravel is working
echo "🧪 Testing Laravel..."
php artisan --version

# Test if CSV class is available
echo "🧪 Testing PhpSpreadsheet CSV class..."
php -r "require_once 'vendor/autoload.php'; if (class_exists('PhpOffice\PhpSpreadsheet\Reader\Csv')) { echo '✅ CSV class found!'; } else { echo '❌ CSV class NOT found!'; }"

echo ""
echo "🌐 Testing website access..."
curl -I http://localhost 2>/dev/null | head -1 || echo "❌ Website not accessible"

echo ""
echo "🎉 All done! Try accessing your website now."
