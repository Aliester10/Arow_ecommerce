@echo off
cd /d "%~dp0"
echo ==========================================
echo      Composer Setup Script
echo ==========================================

REM Check for PHP
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo PHP is not in your PATH or not installed.
    echo Please ensure XAMPP is installed and PHP is added to PATH.
    pause
    exit /b
)

REM Download Composer if not exists
if not exist composer.phar (
    echo Downloading composer.phar...
    powershell -Command "& { [Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; Invoke-WebRequest -Uri 'https://getcomposer.org/composer.phar' -OutFile 'composer.phar' }"
)

if not exist composer.phar (
    echo.
    echo [ERROR] Failed to download composer.phar.
    echo Please download it manually from https://getcomposer.org/composer.phar
    echo and place it in this folder: %~dp0
    pause
    exit /b
)

REM Install Dependencies
echo.
echo Installing dependencies...
php composer.phar install

REM Run Key Generate
echo.
echo Generating App Key...
php artisan key:generate

REM Run Migrations
echo.
echo Running Migrations...
php artisan migrate --force

echo.
echo ==========================================
echo      Setup Complete!
echo ==========================================
echo You can now run the website using 'run_website.bat' or 'php artisan serve'
pause
