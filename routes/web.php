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
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\AdminPrivacyPolicyController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TrackOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home/top-brand-products/{brandId}', [HomeController::class, 'getTopBrandProducts'])->name('home.top-brand-products');

// Help
Route::get('/bantuan', [HelpController::class, 'index'])->name('help.index');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

// Track Order
Route::get('/lacak-pesanan', [TrackOrderController::class, 'index'])->name('track-order.index');

// Privacy Policy
Route::get('/kebijakan-privasi', [PrivacyPolicyController::class, 'index'])->name('privacy-policy');

// About Us
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about.index');

// Career
Route::get('/karir', [JobController::class, 'index'])->name('karir.index');

// Payment Methods
Route::get('/metode-pembayaran', [PaymentMethodController::class, 'index'])->name('payment-methods.index');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Mitra
Route::get('/mitra', [MitraController::class, 'index'])->name('mitra.index');

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

// Special Deals Public Routes
Route::get('/special-deals', [App\Http\Controllers\SpecialDealController::class, 'index'])->name('special-deals.public.index');


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

    // Shipping (RajaOngkir)
    Route::get('/shipping/provinces', [ShippingController::class, 'getProvinces'])->name('shipping.provinces');
    Route::get('/shipping/cities/{province_id}', [ShippingController::class, 'getCities'])->name('shipping.cities');
    Route::get('/shipping/districts/{city_id}', [ShippingController::class, 'getDistricts'])->name('shipping.districts');
    Route::get('/shipping/villages/{district_id}', [ShippingController::class, 'getVillages'])->name('shipping.villages');
    Route::post('/shipping/cost', [ShippingController::class, 'getCost'])->name('shipping.cost');
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
    Route::get('/products/get-subcategories/{id}', [App\Http\Controllers\AdminProductController::class, 'getSubcategories'])->name('products.getSubcategories');
    Route::get('/products/get-sub-subcategories/{id}', [App\Http\Controllers\AdminProductController::class, 'getSubSubcategories'])->name('products.getSubSubcategories');
    Route::post('/products', [App\Http\Controllers\AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [App\Http\Controllers\AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [App\Http\Controllers\AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [App\Http\Controllers\AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/{productId}/delete-image/{imageId}', [App\Http\Controllers\AdminProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::post('/products/{productId}/set-primary-image/{imageId}', [App\Http\Controllers\AdminProductController::class, 'setPrimaryImage'])->name('products.setPrimaryImage');
    
    // Bulk Actions
    Route::post('/products/bulk-delete', [App\Http\Controllers\AdminProductController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::post('/products/bulk-update-status', [App\Http\Controllers\AdminProductController::class, 'bulkUpdateStatus'])->name('products.bulkUpdateStatus');

    // Product Import
    Route::get('/products/import', [App\Http\Controllers\ProductImportController::class, 'index'])->name('products.import');
    Route::post('/products/import', [App\Http\Controllers\ProductImportController::class, 'import'])->name('products.import.store');
    Route::get('/products/download-template', [App\Http\Controllers\ProductImportController::class, 'downloadTemplate'])->name('products.download-template');
    
    // Image Upload for Import
    Route::post('/products/upload-images', [App\Http\Controllers\ProductImportController::class, 'uploadImages'])->name('products.upload-images');
    Route::post('/products/delete-image', [App\Http\Controllers\ProductImportController::class, 'deleteImage'])->name('products.delete-image');
    Route::post('/products/clear-temp-images', [App\Http\Controllers\ProductImportController::class, 'clearTempImages'])->name('products.clear-temp-images');

    // Appearance Management
    Route::prefix('appearance')->name('appearance.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.appearance.header');
        })->name('index');
        Route::get('/header', [App\Http\Controllers\AdminAppearanceController::class, 'header'])->name('header');
        Route::put('/header', [App\Http\Controllers\AdminAppearanceController::class, 'updateHeader'])->name('header.update');
        Route::get('/footer', [App\Http\Controllers\AdminAppearanceController::class, 'footer'])->name('footer');
        Route::put('/footer', [App\Http\Controllers\AdminAppearanceController::class, 'updateFooter'])->name('footer.update');
        Route::get('/integrated-solutions', [App\Http\Controllers\AdminAppearanceController::class, 'integratedSolutions'])->name('integrated-solutions');
        Route::put('/integrated-solutions', [App\Http\Controllers\AdminAppearanceController::class, 'updateIntegratedSolutions'])->name('integrated-solutions.update');
    });

    // Admin Brand Management
    Route::get('/brands', [App\Http\Controllers\AdminBrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [App\Http\Controllers\AdminBrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [App\Http\Controllers\AdminBrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{id}/edit', [App\Http\Controllers\AdminBrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{id}', [App\Http\Controllers\AdminBrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [App\Http\Controllers\AdminBrandController::class, 'destroy'])->name('brands.destroy');

    // Category Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminCategoryController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AdminCategoryController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\AdminCategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [App\Http\Controllers\AdminCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [App\Http\Controllers\AdminCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [App\Http\Controllers\AdminCategoryController::class, 'destroy'])->name('destroy');
    });

    // Sub Category Management
    Route::prefix('sub-categories')->name('sub-categories.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminSubCategoryController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AdminSubCategoryController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\AdminSubCategoryController::class, 'store'])->name('store');
        Route::get('/{subCategory}/edit', [App\Http\Controllers\AdminSubCategoryController::class, 'edit'])->name('edit');
        Route::put('/{subCategory}', [App\Http\Controllers\AdminSubCategoryController::class, 'update'])->name('update');
        Route::delete('/{subCategory}', [App\Http\Controllers\AdminSubCategoryController::class, 'destroy'])->name('destroy');
    });

    // Sub Sub Category Management
    Route::prefix('sub-sub-categories')->name('sub-sub-categories.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminSubSubCategoryController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AdminSubSubCategoryController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\AdminSubSubCategoryController::class, 'store'])->name('store');
        Route::get('/{subSubCategory}/edit', [App\Http\Controllers\AdminSubSubCategoryController::class, 'edit'])->name('edit');
        Route::put('/{subSubCategory}', [App\Http\Controllers\AdminSubSubCategoryController::class, 'update'])->name('update');
        Route::delete('/{subSubCategory}', [App\Http\Controllers\AdminSubSubCategoryController::class, 'destroy'])->name('destroy');
    });

    // Admin Banner Management
    // Slider Banner Routes (Display Only)
    Route::get('/slider-banners', [App\Http\Controllers\AdminBannerController::class, 'sliderIndex'])->name('slider-banners.index');
    Route::get('/slider-banners/create', [App\Http\Controllers\AdminBannerController::class, 'sliderCreate'])->name('slider-banners.create');
    Route::post('/slider-banners', [App\Http\Controllers\AdminBannerController::class, 'sliderStore'])->name('slider-banners.store');
    Route::get('/slider-banners/{id}/edit', [App\Http\Controllers\AdminBannerController::class, 'sliderEdit'])->name('slider-banners.edit');
    Route::put('/slider-banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'sliderUpdate'])->name('slider-banners.update');
    Route::delete('/slider-banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'sliderDestroy'])->name('slider-banners.destroy');

    // Legacy Banner Routes (for backward compatibility)
    Route::get('/banners', [App\Http\Controllers\AdminBannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [App\Http\Controllers\AdminBannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [App\Http\Controllers\AdminBannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [App\Http\Controllers\AdminBannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [App\Http\Controllers\AdminBannerController::class, 'destroy'])->name('banners.destroy');

    // Special Deals Management
    Route::get('/special-deals', [App\Http\Controllers\AdminSpecialDealController::class, 'index'])->name('special-deals.index');
    Route::get('/special-deals/create', [App\Http\Controllers\AdminSpecialDealController::class, 'create'])->name('special-deals.create');
    Route::post('/special-deals', [App\Http\Controllers\AdminSpecialDealController::class, 'store'])->name('special-deals.store');
    Route::get('/special-deals/{specialDeal}/edit', [App\Http\Controllers\AdminSpecialDealController::class, 'edit'])->name('special-deals.edit');
    Route::put('/special-deals/{specialDeal}', [App\Http\Controllers\AdminSpecialDealController::class, 'update'])->name('special-deals.update');
    Route::delete('/special-deals/{specialDeal}', [App\Http\Controllers\AdminSpecialDealController::class, 'destroy'])->name('special-deals.destroy');

    // FAQ Management
    Route::get('/faqs', [AdminFaqController::class, 'index'])->name('faq.index');
    Route::get('/faqs/create', [AdminFaqController::class, 'create'])->name('faq.create');
    Route::post('/faqs', [AdminFaqController::class, 'store'])->name('faq.store');
    Route::get('/faqs/{faq}/edit', [AdminFaqController::class, 'edit'])->name('faq.edit');
    Route::put('/faqs/{faq}', [AdminFaqController::class, 'update'])->name('faq.update');
    Route::delete('/faqs/{faq}', [AdminFaqController::class, 'destroy'])->name('faq.destroy');
    Route::patch('/faqs/{faq}/toggle-status', [AdminFaqController::class, 'toggleStatus'])->name('faq.toggle-status');

    // Complaint Management
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{id}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/complaints/{id}/download', [ComplaintController::class, 'downloadEvidence'])->name('complaints.download');
    Route::put('/complaints/{id}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.update-status');

    // Privacy Policy Management
    Route::get('/privacy-policy', [AdminPrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::get('/privacy-policy/create', [AdminPrivacyPolicyController::class, 'create'])->name('privacy-policy.create');
    Route::post('/privacy-policy', [AdminPrivacyPolicyController::class, 'store'])->name('privacy-policy.store');
    Route::get('/privacy-policy/{privacyPolicy}/edit', [AdminPrivacyPolicyController::class, 'edit'])->name('privacy-policy.edit');
    Route::put('/privacy-policy/{privacyPolicy}', [AdminPrivacyPolicyController::class, 'update'])->name('privacy-policy.update');
    Route::delete('/privacy-policy/{privacyPolicy}', [AdminPrivacyPolicyController::class, 'destroy'])->name('privacy-policy.destroy');
    Route::patch('/privacy-policy/{privacyPolicy}/toggle-status', [AdminPrivacyPolicyController::class, 'toggleStatus'])->name('privacy-policy.toggle-status');

    // Blog Management
    Route::get('/blog', [AdminBlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [AdminBlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [AdminBlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{blog}/edit', [AdminBlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{blog}', [AdminBlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{blog}', [AdminBlogController::class, 'destroy'])->name('blog.destroy');
    Route::patch('/blog/{blog}/toggle-status', [AdminBlogController::class, 'toggleStatus'])->name('blog.toggle-status');

    // Mitra Management
    Route::resource('mitra', App\Http\Controllers\Admin\MitraController::class)->names('mitra');

    // Job Management
    Route::resource('jobs', App\Http\Controllers\AdminJobController::class)->names('jobs');
});
