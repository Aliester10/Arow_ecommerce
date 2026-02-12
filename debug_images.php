<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$kernel->bootstrap();

$products = \App\Models\Produk::all();

foreach ($products as $product) {
    echo "ID: " . $product->id_produk . "\n";
    echo "Name: " . $product->nama_produk . "\n";
    echo "Image: " . $product->gambar_produk . "\n";
    echo "Path: " . public_path('storage/images/produk/' . $product->gambar_produk) . "\n";
    echo "Exists: " . (file_exists(public_path('storage/images/produk/' . $product->gambar_produk)) ? 'YES' : 'NO') . "\n";
    echo "------------------------\n";
}
