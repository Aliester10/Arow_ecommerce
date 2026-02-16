<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UlasanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/language/{locale}', function (string $locale) {
    if (!in_array($locale, ['id', 'en'], true)) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/products/{slug}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{id}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    // Checkout & Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/place-order', [OrderController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/checkout/qris/{id}', [OrderController::class, 'qris'])->name('checkout.qris');
    Route::get('/checkout/quotation/{id}', [OrderController::class, 'quotation'])->name('checkout.quotation');
    Route::get('/checkout/quotation/{id}/download', [OrderController::class, 'downloadQuotationExcel'])->name('checkout.quotation.download');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Simple Admin Product Upload & Management
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');

    // Global Settings
    Route::get('/settings', [App\Http\Controllers\AdminSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\AdminSettingsController::class, 'update'])->name('settings.update');

    // Footer Links
    Route::resource('footer_links', App\Http\Controllers\AdminFooterLinkController::class)->names('footer_links');

    Route::get('/products', [App\Http\Controllers\AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [App\Http\Controllers\AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [App\Http\Controllers\AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [App\Http\Controllers\AdminProductController::class, 'destroy'])->name('products.destroy');

    // Appearance Management
    Route::prefix('appearance')->name('appearance.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.appearance.header');
        })->name('index');
        Route::get('/header', [App\Http\Controllers\AdminAppearanceController::class, 'header'])->name('header');
        Route::put('/header', [App\Http\Controllers\AdminAppearanceController::class, 'updateHeader'])->name('header.update');
        Route::get('/footer', [App\Http\Controllers\AdminAppearanceController::class, 'footer'])->name('footer');
        Route::put('/footer', [App\Http\Controllers\AdminAppearanceController::class, 'updateFooter'])->name('footer.update');
    });

    // Admin Brand Management
    Route::get('/brands', [App\Http\Controllers\AdminBrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [App\Http\Controllers\AdminBrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [App\Http\Controllers\AdminBrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{id}/edit', [App\Http\Controllers\AdminBrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{id}', [App\Http\Controllers\AdminBrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [App\Http\Controllers\AdminBrandController::class, 'destroy'])->name('brands.destroy');

    // Admin Banner Management
    Route::get('/banners', [App\Http\Controllers\AdminBannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [App\Http\Controllers\AdminBannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [App\Http\Controllers\AdminBannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [App\Http\Controllers\AdminBannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'destroy'])->name('banners.destroy');
});
