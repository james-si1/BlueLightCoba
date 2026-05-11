<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Frontend\OrderController as FrontOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return redirect()->route('frontend.beranda');
});

// Dashboard admin / pegawai / customer
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'customer' || auth()->user()->role === 'pelanggan') {
        return redirect()->route('frontend.beranda');
    }

    return app(DashboardController::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile wajib login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin & Pegawai
Route::middleware(['auth', 'role:admin,pegawai'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);

        Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::post('stocks/update', [StockController::class, 'updateStock'])->name('stocks.update');

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::post('orders/update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::get('orders/print/{id}', [AdminOrderController::class, 'print'])->name('orders.print');
        Route::delete('orders/delete/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('laporan/harian', [AdminOrderController::class, 'laporanHarian'])->name('laporan.harian');
        Route::get('laporan/mingguan', [AdminOrderController::class, 'laporanMingguan'])->name('laporan.mingguan');
        Route::get('laporan/bulanan', [AdminOrderController::class, 'laporanBulanan'])->name('laporan.bulanan');
        Route::get('laporan/tahunan', [AdminOrderController::class, 'laporanTahunan'])->name('laporan.tahunan');

        Route::get('laporan/harian/pdf', [AdminOrderController::class, 'laporanHarianPdf'])->name('laporan.harian.pdf');
        Route::get('laporan/mingguan/pdf', [AdminOrderController::class, 'laporanMingguanPdf'])->name('laporan.mingguan.pdf');
        Route::get('laporan/bulanan/pdf', [AdminOrderController::class, 'laporanBulananPdf'])->name('laporan.bulanan.pdf');
        Route::get('laporan/tahunan/pdf', [AdminOrderController::class, 'laporanTahunanPdf'])->name('laporan.tahunan.pdf');
    });

// Khusus Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

// Frontend bisa diakses tamu
Route::get('/beranda', function () {
    return view('frontend.beranda');
})->name('frontend.beranda');

Route::get('/products', [FrontOrderController::class, 'products'])->name('frontend.products.index');
Route::get('/products/{id}', [FrontOrderController::class, 'productDetail'])->name('frontend.products.detail');

// Frontend wajib login
Route::middleware('auth')->group(function () {
    Route::get('/cart', [FrontOrderController::class, 'cart'])->name('cart.index');
    Route::post('/cart/add', [FrontOrderController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{id}', [FrontOrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/increase/{id}', [FrontOrderController::class, 'increaseCart'])->name('cart.increase');
    Route::post('/cart/decrease/{id}', [FrontOrderController::class, 'decreaseCart'])->name('cart.decrease');

    Route::get('/checkout', [FrontOrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/process', [FrontOrderController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/checkout/success', function () {
        return view('frontend.success');
    })->name('checkout.success');

    Route::get('/my-orders', [FrontOrderController::class, 'myOrders'])->name('my.orders');
    Route::get('/my-orders/{id}', [FrontOrderController::class, 'myOrderDetail'])->name('my.orders.detail');
});
