#!/bin/bash

echo "🔧 Quick Fix for bootstrap/app.php..."
echo "===================================="

cd /var/www/Arow_ecommerce

# Fix the typo in bootstrap/app.php
cat > bootstrap/app.php << 'EOF'
<?php

use Illuminate\Foundation\Application;

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

echo "✅ bootstrap/app.php fixed!"

echo "🧹 Clearing caches..."
php artisan config:clear 2>/dev/null || echo "Config clear skipped"
php artisan cache:clear 2>/dev/null || echo "Cache clear skipped"
php artisan view:clear 2>/dev/null || echo "View clear skipped"
php artisan route:clear 2>/dev/null || echo "Route clear skipped"

echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔗 Creating storage link..."
php artisan storage:link

echo "🔑 Generating app key..."
php artisan key:generate

echo "🧪 Testing Laravel..."
php artisan --version

echo "🧪 Testing PhpSpreadsheet CSV class..."
php -r "require_once 'vendor/autoload.php'; if (class_exists('PhpOffice\PhpSpreadsheet\Reader\Csv')) { echo '✅ CSV class found!'; } else { echo '❌ CSV class NOT found!'; }"

echo ""
echo "🎉 Fix completed! Try accessing your website now."
