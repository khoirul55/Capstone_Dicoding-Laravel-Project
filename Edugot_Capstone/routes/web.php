<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//route admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');

    Route::resource('admin/product', ProductController::class);

    Route::put('/admin/product/stock-update/{product}', [ProductController::class, 'addStock'])->name('product.updateStock');
    Route::get('/admin/product/stock-add/{product}', [ProductController::class, 'showAddStock'])->name('product.showAddStock');

    Route::resource('admin/article', ArticleController::class);

    Route::resource('admin/order', OrderController::class);
    Route::post('/admin/order/change-status', [OrderController::class, 'changeOrderStatus'])->name('admin.changestatus');
    Route::post('/admin/order/cancel-order', [OrderController::class, 'cancelOrder'])->name('admin.cancelorder');
});

//route pengguna
Route::get('/', [ArticleController::class, 'homepage'])->name('homepage');

Route::get('/layanan', function () {
    return view('service');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/article/{article}', [ArticleController::class, 'showDetail'])->name('article.showDetail');

Route::get('/register', function () {
    return view('registerBuyer');
});

Route::post('/registerbuyer', [BuyerController::class, 'registerBuyer'])->name('register');

Route::get('/service-buy', [OrderController::class, 'showCheckout'])->name('checkout');
Route::post('/service-pay', [OrderController::class, 'showPayment'])->name('payment');
Route::post('/', [OrderController::class, 'orderCreate'])->name('home');

Route::get('/profile', [BuyerController::class, 'showProfile'])->name('profile');
Route::get('/history-order', [OrderController::class, 'showHistoryOrder'])->name('showHistoryOrder');

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
