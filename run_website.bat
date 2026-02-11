@echo off
echo ==========================================
echo      Laravel Project Setup Script
echo ==========================================

REM Check if .env exists, if not copy from example
if not exist .env (
    echo Creating .env file...
    copy .env.example .env
)

REM Install Composer Dependencies
echo.
echo Installing Composer dependencies...
call composer install

REM Install NPM Dependencies
echo.
echo Installing NPM dependencies...
call npm install

REM Generate App Key
echo.
echo Generating Application Key...
php artisan key:generate

REM Run Migrations
echo.
echo Running Database Migrations...
php artisan migrate --force

echo.
echo ==========================================
echo      Starting Development Servers
echo ==========================================
echo.
echo Starting Laravel Server (php artisan serve)...
start "Laravel Server" php artisan serve

echo Starting Vite Server (npm run dev)...
start "Vite Server" npm run dev

echo.
echo Setup complete! The servers should be running in new windows.
pause
