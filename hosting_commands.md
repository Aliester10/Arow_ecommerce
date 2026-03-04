# Commands untuk check log di hosting

# 1. Navigasi ke Laravel directory
cd /var/www/aro_ecommerce

# 2. Check log directory
ls -la storage/logs/

# 3. Jika tidak ada, buat directory
mkdir -p storage/logs
chmod 755 storage/logs

# 4. Test log dengan Laravel
php artisan tinker
>>> Log::info('Test log entry from hosting');
>>> exit

# 5. Check log
tail -20 storage/logs/laravel.log

# 6. Setelah coba update produk, check log lagi
tail -50 storage/logs/laravel.log

# 7. Search untuk log spesifik
grep "Spesifikasi_produk" storage/logs/laravel.log
grep "Direct SQL" storage/logs/laravel.log
