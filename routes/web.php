<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\ProfileController;

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

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Public Informasi Details
Route::get('/informasi/{promoDetailId}', [App\Http\Controllers\PromoDetailController::class, 'show'])->name('informasi.show');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/products/{slug}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

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
    Route::post('/orders/{id}/upload-transfer-proof', [OrderController::class, 'uploadTransferProof'])->name('orders.uploadTransferProof');
});

// Simple Admin Product Upload & Management
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');

    // Payment Accounts
    Route::get('/payment-accounts', [App\Http\Controllers\AdminPaymentAccountController::class, 'index'])->name('payment_accounts.index');
    Route::get('/payment-accounts/create', [App\Http\Controllers\AdminPaymentAccountController::class, 'create'])->name('payment_accounts.create');
    Route::post('/payment-accounts', [App\Http\Controllers\AdminPaymentAccountController::class, 'store'])->name('payment_accounts.store');
    Route::get('/payment-accounts/{id}/edit', [App\Http\Controllers\AdminPaymentAccountController::class, 'edit'])->name('payment_accounts.edit');
    Route::put('/payment-accounts/{id}', [App\Http\Controllers\AdminPaymentAccountController::class, 'update'])->name('payment_accounts.update');
    Route::delete('/payment-accounts/{id}', [App\Http\Controllers\AdminPaymentAccountController::class, 'destroy'])->name('payment_accounts.destroy');

    // Orders & Payment Confirmation
    Route::get('/orders/transfer', [App\Http\Controllers\AdminOrderPaymentController::class, 'transferIndex'])->name('orders.transfer');
    Route::get('/orders/quotation', [App\Http\Controllers\AdminOrderPaymentController::class, 'quotationIndex'])->name('orders.quotation');
    Route::get('/orders/{id}', [App\Http\Controllers\AdminOrderPaymentController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/approve', [App\Http\Controllers\AdminOrderPaymentController::class, 'approvePayment'])->name('orders.approve');
    Route::post('/orders/{id}/reject', [App\Http\Controllers\AdminOrderPaymentController::class, 'rejectPayment'])->name('orders.reject');

    // Quotation Editor (Admin)
    Route::get('/quotations/{orderId}/edit', [App\Http\Controllers\AdminQuotationController::class, 'edit'])->name('quotations.edit');
    Route::put('/quotations/{orderId}', [App\Http\Controllers\AdminQuotationController::class, 'update'])->name('quotations.update');
    Route::get('/quotations/{orderId}/download', [App\Http\Controllers\AdminQuotationController::class, 'downloadExcel'])->name('quotations.download');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.users.admins.index');
        })->name('index');

        Route::get('/admins', [App\Http\Controllers\AdminUserController::class, 'adminsIndex'])->name('admins.index');
        Route::get('/admins/create', [App\Http\Controllers\AdminUserController::class, 'adminsCreate'])->name('admins.create');
        Route::post('/admins', [App\Http\Controllers\AdminUserController::class, 'adminsStore'])->name('admins.store');

        Route::get('/members', [App\Http\Controllers\AdminUserController::class, 'membersIndex'])->name('members.index');
        Route::get('/members/create', [App\Http\Controllers\AdminUserController::class, 'membersCreate'])->name('members.create');
        Route::post('/members', [App\Http\Controllers\AdminUserController::class, 'membersStore'])->name('members.store');
    });

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
    // Slider Banner Routes (Display Only)
    Route::get('/slider-banners', [App\Http\Controllers\AdminBannerController::class, 'sliderIndex'])->name('slider-banners.index');
    Route::get('/slider-banners/create', [App\Http\Controllers\AdminBannerController::class, 'sliderCreate'])->name('slider-banners.create');
    Route::post('/slider-banners', [App\Http\Controllers\AdminBannerController::class, 'sliderStore'])->name('slider-banners.store');
    Route::get('/slider-banners/{id}/edit', [App\Http\Controllers\AdminBannerController::class, 'sliderEdit'])->name('slider-banners.edit');
    Route::put('/slider-banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'sliderUpdate'])->name('slider-banners.update');
    Route::delete('/slider-banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'sliderDestroy'])->name('slider-banners.destroy');

    // Promo Banner Routes (Clickable with Links)
    Route::get('/promo-banners', [App\Http\Controllers\AdminBannerController::class, 'promoIndex'])->name('promo-banners.index');
    Route::get('/promo-banners/create', [App\Http\Controllers\AdminBannerController::class, 'promoCreate'])->name('promo-banners.create');
    Route::post('/promo-banners', [App\Http\Controllers\AdminBannerController::class, 'promoStore'])->name('promo-banners.store');
    Route::get('/promo-banners/{id}/edit', [App\Http\Controllers\AdminBannerController::class, 'promoEdit'])->name('promo-banners.edit');
    Route::put('/promo-banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'promoUpdate'])->name('promo-banners.update');
    Route::delete('/promo-banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'promoDestroy'])->name('promo-banners.destroy');

    // Promo Details Routes
    Route::get('/promo-details', [App\Http\Controllers\AdminPromoDetailController::class, 'index'])->name('promo-details.index');
    Route::get('/promo-details/banner/{promoBannerId}', [App\Http\Controllers\AdminPromoDetailController::class, 'bannerIndex'])->name('promo-details.banner-index');
    Route::get('/promo-details/{promoBannerId}/create', [App\Http\Controllers\AdminPromoDetailController::class, 'create'])->name('promo-details.create');
    Route::post('/promo-details/{promoBannerId}', [App\Http\Controllers\AdminPromoDetailController::class, 'store'])->name('promo-details.store');
    Route::get('/promo-details/{promoBannerId}/{promoDetailId}', [App\Http\Controllers\AdminPromoDetailController::class, 'show'])->name('promo-details.show');
    Route::get('/promo-details/{promoBannerId}/{promoDetailId}/edit', [App\Http\Controllers\AdminPromoDetailController::class, 'edit'])->name('promo-details.edit');
    Route::put('/promo-details/{promoBannerId}/{promoDetailId}', [App\Http\Controllers\AdminPromoDetailController::class, 'update'])->name('promo-details.update');
    Route::delete('/promo-details/{promoBannerId}/{promoDetailId}', [App\Http\Controllers\AdminPromoDetailController::class, 'destroy'])->name('promo-details.destroy');

    // Legacy Banner Routes (for backward compatibility)
    Route::get('/banners', [App\Http\Controllers\AdminBannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [App\Http\Controllers\AdminBannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [App\Http\Controllers\AdminBannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [App\Http\Controllers\AdminBannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'destroy'])->name('banners.destroy');
});
