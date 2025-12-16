<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSellerController;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;

use Illuminate\Support\Facades\Auth; // pastikan ini ada di atas file web.php
use App\Models\Pemesanan;             // nanti dipakai kalau sudah ada model
use App\Models\Wishlist;              // kalau punya tabel wishlist
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================
//       HALAMAN UTAMA
// ==========================
Route::get('/', function () {
    return view('landingPage.welcome');
});

// ==========================
//        AUTH ROUTES
// ==========================
// REGISTER
Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register.form');
Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

// LOGIN CUSTOMER
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
//      PRODUK (PUBLIC)
// ==========================
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('productdetail');
Route::get('/products', [ProductController::class, 'index'])->name('products.page');

// ==========================
//      ADMIN LOGIN
// ==========================
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login')
    ->middleware('guest:admin');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.post')
    ->middleware('guest:admin');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout')
    ->middleware('auth:admin');

// ==========================
//      ADMIN ROUTES
// ==========================
Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Seller management (verifikasi seller)
        Route::get('/sellers', [AdminSellerController::class, 'index'])
            ->name('sellers');

        Route::get('/sellers/{seller}', [AdminSellerController::class, 'show'])
            ->name('sellers.show');

        // Tombol Setujui / Tolak di dashboard admin
        Route::post('/seller/{seller}/approve', [AdminSellerController::class, 'approve'])
            ->name('seller.approve');

        Route::post('/seller/{seller}/reject', [AdminSellerController::class, 'reject'])
            ->name('seller.reject');

        // Produk & transaksi admin
        Route::get('/products', [\App\Http\Controllers\Admin\AdminProductController::class, 'index'])
            ->name('products');

        Route::delete('/products/{id}', [\App\Http\Controllers\Admin\AdminProductController::class, 'destroy'])
            ->name('products.destroy');

        Route::get('/transactions', [\App\Http\Controllers\Admin\AdminTransactionController::class, 'index'])
            ->name('transactions');
    });

// ==========================
//    ROUTE SETELAH LOGIN
//    (CUSTOMER & SELLER)
// ==========================
Route::middleware(['web', 'auth'])->group(function () {

    // ======================
    //   CUSTOMER DASHBOARD
    // ======================
    Route::get('/customer/dashboard', function () {

        // sementara semua 0 dulu
        $totalOrders    = 0;
        $totalFinished  = 0;
        $totalShipped   = 0;
        $wishlistCount  = 0;

        return view('main.customer-dashboard', [
            'totalOrders'   => $totalOrders,
            'totalFinished' => $totalFinished,
            'totalShipped'  => $totalShipped,
            'wishlistCount' => $wishlistCount,
        ]);
    })->name('customer.dashboard');

    // ======================
    //       SELLER ROUTES
    // ======================
    Route::prefix('seller')->name('seller.')->group(function () {

        // Seller kirim ulang permintaan persetujuan setelah data diperbarui
        Route::post('/request-approval-again', [AuthController::class, 'requestApprovalAgain'])
            ->name('request_approval_again');

        // Public seller routes (tidak perlu approved)
        Route::get('/waiting-approval', function () {
            return view('auth.waiting-approval');
        })->name('waiting_approval');

        Route::get('/rejected', function () {
            return view('auth.seller-rejected');
        })->name('rejected');

        // Protected seller routes (harus sudah approved)
        Route::middleware([\App\Http\Middleware\EnsureSellerIsApproved::class])->group(function () {
            Route::get('/dashboard', [SellerDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/products/create', [SellerProductController::class, 'create'])
                ->name('add-product');

            Route::post('/products', [SellerProductController::class, 'store'])
                ->name('products.store');

            Route::get('/products/{product}', [SellerProductController::class, 'show'])
                ->name('products.show');

            Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])
                ->name('products.destroy');

            Route::get('/orders', [SellerOrderController::class, 'index'])
                ->name('orders');

            Route::get('/report', [\App\Http\Controllers\Seller\SellerReportController::class, 'index'])
                ->name('report');

            Route::get('/edit-account', [\App\Http\Controllers\Seller\SellerAccountController::class, 'index'])
                ->name('edit-account');

            Route::post('/upload-logo', [\App\Http\Controllers\Seller\SellerAccountController::class, 'uploadLogo'])
                ->name('upload-logo');

            Route::delete('/delete-logo', [\App\Http\Controllers\Seller\SellerAccountController::class, 'deleteLogo'])
                ->name('delete-logo');
        });
    });

    Route::get('/sellerconfirmation', function () {
        return view('auth.seller-confirmation');
    })->name('seller.confirmation');

    // Fallback untuk form lama
    Route::post('/sellerconfirmation', [AuthController::class, 'upgradeToSeller']);

    Route::post('/seller-registration', [AuthController::class, 'upgradeToSeller'])->name('seller.register');

    // ======================
    //         CART
    // ======================
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/remove/{slug}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

    // ======================
    //         CHAT
    // ======================
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat');
    Route::get('/chat/messages/{userId}', [\App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');

    // ======================
    //        PROFILE
    // ======================
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [\App\Http\Controllers\ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::post('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/address/delete', [\App\Http\Controllers\ProfileController::class, 'deleteAddress'])->name('profile.address.delete');

    // ======================
    //        CHECKOUT
    // ======================
    // Tampilkan halaman checkout berdasarkan isi keranjang (session)
    Route::get('/checkout', [OrderController::class, 'checkoutFromCart'])
        ->name('checkout');

    // Proses ketika tombol "Bayar Sekarang" diklik
    Route::post('/checkout', [OrderController::class, 'storeFromCheckout'])
        ->name('checkout.submit');

    // Halaman menunggu pembayaran + upload bukti
    Route::get('/payment/{order}', [OrderController::class, 'showPayment'])
        ->name('payment.waiting');

    Route::post('/payment/{order}/upload-proof', [OrderController::class, 'uploadProof'])
        ->name('payment.upload-proof');

    // ======================
    //        REVIEWS
    // ======================
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});
