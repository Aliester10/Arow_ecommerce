# TROUBLESHOOTING HTTP ERROR 500 DI HOSTING

## 🔍 Penyebab Umum Error 500

### 1. **Missing .env File**
- Pastikan file `.env` ada di root directory hosting
- Copy dari `.env.example` lalu sesuaikan

### 2. **APP_KEY Missing**
- Generate APP_KEY: `php artisan key:generate`
- Pastikan `APP_KEY` tidak kosong di `.env`

### 3. **Folder Permissions**
```bash
# Set permissions untuk storage dan bootstrap/cache
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/
```

### 4. **Database Connection**
- Pastikan database credentials di `.env` benar
- Test connection: `php artisan tinker` → `DB::connection()->getPdo()`

### 5. **Composer Dependencies**
- Run: `composer install --optimize-autoloader --no-dev`
- Atau upload vendor folder dari local

### 6. **Storage Link**
- Run: `php artisan storage:link`
- Pastikan `public/storage` symlink exists

## 🛠️ Commands untuk Debugging

### Check Laravel Status
```bash
# Check Laravel version
php artisan --version

# Check configuration
php artisan config:cache
php artisan config:clear

# Check routes
php artisan route:list

# Check cache
php artisan cache:clear
php artisan view:clear
```

### Check Logs
```bash
# Check Laravel log
tail -50 storage/logs/laravel.log

# Check error log hosting
tail -50 /var/log/apache2/error.log
# atau
tail -50 /var/log/nginx/error.log
```

### Test Database Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

## 📋 Checklist Sebelum Upload

### 1. Environment Setup
- [ ] Copy `.env.example` → `.env`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate `APP_KEY`
- [ ] Set `APP_URL` ke domain hosting

### 2. Database Configuration
- [ ] Import database ke hosting
- [ ] Set database credentials di `.env`
- [ ] Test connection

### 3. File Upload
- [ ] Upload semua file ke hosting
- [ ] Upload vendor folder (atau run composer install)
- [ ] Set permissions

### 4. Final Setup
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `php artisan storage:link`

## 🚨 Error Messages & Solutions

### "No application encryption key has been specified"
```bash
php artisan key:generate
```

### "The storage directory is not writable"
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### "SQLSTATE[HY000] [2002] Connection refused"
- Check database credentials di `.env`
- Pastikan database server running
- Check firewall settings

### "404 Not Found" untuk assets
- Run `php artisan storage:link`
- Check `APP_URL` di `.env`
- Check `.htaccess` configuration

## 📁 .env Template untuk Production

```env
APP_NAME="Arow Ecommerce"
APP_ENV=production
APP_KEY=base64:GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://ayobelanja.co.id

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=username
DB_PASSWORD=password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 🔄 Quick Fix Script

```bash
#!/bin/bash
echo "Starting Laravel deployment fix..."

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Set permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if not exists
if [ ! -L "public/storage" ]; then
    php artisan storage:link
fi

echo "Deployment fix completed!"
```
