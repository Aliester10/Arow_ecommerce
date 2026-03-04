# Steps untuk check log di hosting

# Step 1: Check log terbaru
tail -50 storage/logs/laravel.log

# Step 2: Test log baru
php artisan tinker
>>> Log::info('Test log entry - ' . date('Y-m-d H:i:s'));
>>> exit

# Step 3: Check log lagi untuk verifikasi
tail -10 storage/logs/laravel.log

# Step 4: Clear log untuk memudahkan debugging
echo "" > storage/logs/laravel.log

# Step 5: Test update produk dari web, lalu check log
tail -100 storage/logs/laravel.log

# Step 6: Search untuk log yang relevan
grep -i "spesifikasi" storage/logs/laravel.log
grep -i "direct sql" storage/logs/laravel.log
grep -i "check constraint" storage/logs/laravel.log
