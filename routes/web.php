<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BannerOrderController;
use App\Http\Controllers\Admin\BannerOrderController as AdminBannerOrderController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- FITUR KHUSUS MAHASISWA / NON-ADMIN (DIBLOK UTK ADMIN) ---
    Route::middleware(['not-admin'])->group(function () {
        
        // Marketplace & Dashboard
        Route::get('/marketplace', [BookController::class, 'marketplace'])->name('marketplace');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Books Resource (Khusus Mahasiswa mengelola buku mereka)
        Route::resource('books', BookController::class)->except(['show', 'destroy']);
        Route::patch('/books/{book}/sold', [BookController::class, 'markAsSold'])->name('books.sold');
        Route::patch('/transactions/{transaction}/cancel', [BookController::class, 'cancelTransaction'])->name('transactions.cancel');
        Route::delete('/book-images/{image}', [BookController::class, 'deleteImage'])->name('book-images.destroy');

        // --- ROUTE CHAT ---
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/{book}/{user}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{book}/{user}', [ChatController::class, 'store'])->name('chat.store');
        Route::post('/chat/{book}/{user}/buy', [ChatController::class, 'buy'])->name('chat.buy');
        Route::post('/chat/{book}/{user}/complete', [ChatController::class, 'complete'])->name('chat.complete');

        // --- ROUTE WISHLIST ---
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/{book}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

        // --- ROUTE TRANSAKSI ---
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

        // --- ROUTE BANNER ORDERS ---
        Route::get('/banner-orders/{bannerOrder}/payment', [BannerOrderController::class, 'payment'])->name('banner.payment');
        Route::post('/banner-orders/{bannerOrder}/payment', [BannerOrderController::class, 'uploadProof'])->name('banner.upload');
    });

    // --- FITUR UMUM AUTH (Bisa diakses Admin & Mahasiswa) ---
    Route::view('/waiting-approval', 'auth.waiting-approval')->name('waiting-approval');

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Approval
        Route::controller(UserApprovalController::class)->group(function () {
            Route::get('/users/pending', 'index')->name('users.pending');
            Route::patch('/users/{user}/approve', 'approve')->name('users.approve');
            Route::patch('/users/{user}/reject', 'reject')->name('users.reject');
        });

        // Kelola User
        Route::resource('users', AdminUserController::class)->except(['show']);

        // Admin Book Management
        Route::get('/books', [BookController::class, 'adminIndex'])->name('books.index');
        Route::delete('/books/{book}', [BookController::class, 'adminDestroy'])->name('books.destroy');

        // Transactions (Admin)
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');

        // Banner Promotion
        Route::get('/banner-orders', [AdminBannerOrderController::class, 'index'])->name('banner-orders.index');
        Route::patch('/banner-orders/{bannerOrder}/approve', [AdminBannerOrderController::class, 'approve'])->name('banner-orders.approve');
        Route::patch('/banner-orders/{bannerOrder}/reject', [AdminBannerOrderController::class, 'reject'])->name('banner-orders.reject');
    });
});

/*
|--------------------------------------------------------------------------
| Detail Buku (PUBLIC)
|--------------------------------------------------------------------------
| Tetap di paling bawah agar tidak bentrok dengan rute Resource /books
|--------------------------------------------------------------------------
*/
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

require __DIR__ . '/auth.php';