<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Web Routes - T-Shirt Store Customer Experience
|--------------------------------------------------------------------------
*/

// 1. HOME
Route::get('/', [PageController::class, 'home'])->name('home');

// 2. SHOP / PRODUCTS
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/api/search', [ShopController::class, 'liveSearch'])->name('api.search');

// 3. PRODUCT DETAIL
Route::get('/product/{id}', [ShopController::class, 'show'])->name('product.detail');
Route::post('/product/{id}/review', [ShopController::class, 'storeReview'])->name('product.review.store');

// 4. CART
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buyNow');
Route::post('/cart/update/{key}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::get('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// 5. CHECKOUT (Requires Customer Login)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// 6. ORDER
Route::get('/order/confirmation/{orderNumber}', [OrderController::class, 'confirmation'])->name('order.confirmation');
Route::get('/orders', [OrderController::class, 'history'])->name('order.history');
Route::get('/track-order', [OrderController::class, 'track'])->name('order.track');
Route::get('/order/invoice/{orderNumber}', [OrderController::class, 'invoice'])->name('order.invoice');

// 7. ABOUT US
Route::get('/about', [PageController::class, 'about'])->name('about');

// 8. CONTACT US
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

// 9. LOGIN / REGISTER (Guest Routes)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/auth/google', [AuthController::class, 'googleSignIn'])->name('auth.google');
});

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// 10. CUSTOMER ACCOUNT & WISHLIST
Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile');
    Route::post('/account/avatar', [AccountController::class, 'updateAvatar'])->name('account.avatar');
    Route::post('/account/address', [AccountController::class, 'updateAddress'])->name('account.address');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
});

Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

/*
|--------------------------------------------------------------------------
| Admin Management Suite Routes (Guard: auth + admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // 1. DASHBOARD
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // 2. PRODUCT MANAGEMENT
    Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/inventory', [\App\Http\Controllers\Admin\ProductController::class, 'inventory'])->name('products.inventory');
    Route::post('/products/{id}/toggle-stock', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStock'])->name('products.toggle_stock');
    Route::post('/products/{id}/update-stock', [\App\Http\Controllers\Admin\ProductController::class, 'updateStock'])->name('products.update_stock');

    // 3. ORDER MANAGEMENT
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('/orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');

    // 4. CUSTOMER MANAGEMENT
    Route::get('/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{id}/statement', [\App\Http\Controllers\Admin\CustomerController::class, 'statement'])->name('customers.statement');
    Route::post('/customers/{id}/status', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->name('customers.status');
    Route::delete('/customers/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');

    // 5. PAYMENT MANAGEMENT
    Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{id}/refund', [\App\Http\Controllers\Admin\PaymentController::class, 'refund'])->name('payments.refund');
    Route::post('/payments/{id}/confirm', [\App\Http\Controllers\Admin\PaymentController::class, 'confirm'])->name('payments.confirm');

    // 6. PROMOTION / DISCOUNT
    Route::get('/promotions', [\App\Http\Controllers\Admin\PromotionController::class, 'index'])->name('promotions.index');
    Route::post('/promotions', [\App\Http\Controllers\Admin\PromotionController::class, 'store'])->name('promotions.store');
    Route::put('/promotions/{id}', [\App\Http\Controllers\Admin\PromotionController::class, 'update'])->name('promotions.update');
    Route::post('/promotions/{id}/toggle', [\App\Http\Controllers\Admin\PromotionController::class, 'toggleStatus'])->name('promotions.toggle');
    Route::delete('/promotions/{id}', [\App\Http\Controllers\Admin\PromotionController::class, 'destroy'])->name('promotions.destroy');

    // 7. REVIEW MANAGEMENT
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/status', [\App\Http\Controllers\Admin\ReviewController::class, 'updateStatus'])->name('reviews.status');
    Route::delete('/reviews/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // 8. CONTENT MANAGEMENT
    Route::get('/content', [\App\Http\Controllers\Admin\ContentController::class, 'index'])->name('content.index');
    Route::post('/content', [\App\Http\Controllers\Admin\ContentController::class, 'update'])->name('content.update');

    // 9. REPORTS
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

    // 10. ADMIN ACCOUNT
    Route::get('/account/profile', [\App\Http\Controllers\Admin\AdminAccountController::class, 'profile'])->name('account.profile');
    Route::post('/account/profile', [\App\Http\Controllers\Admin\AdminAccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::post('/account/password', [\App\Http\Controllers\Admin\AdminAccountController::class, 'updatePassword'])->name('account.password');

    // 11. SETTINGS
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/telegram/test', [\App\Http\Controllers\Admin\SettingController::class, 'testTelegram'])->name('settings.telegram.test');
    Route::post('/settings/telegram/detect', [\App\Http\Controllers\Admin\SettingController::class, 'detectTelegramChat'])->name('settings.telegram.detect');
});