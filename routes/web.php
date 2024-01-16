<?php


// use App\Http\Controllers\Admin\ProductsController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;

Auth::routes();

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'AuthMiddleware', 'prefix' => 'control'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::delete('/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
    Route::delete('/orders/{orderId}', [DashboardController::class, 'deleteOrder'])->name('admin.deleteOrder');
    Route::put('/{orderId}', [DashboardController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    Route::resource('/products', ProductsController::class);
});

// store page and details 

Route::get('/search', [ProductsController::class, 'search']);
// Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');
Route::get('/load-more-products', [ProductsController::class, 'loadMoreProducts']);

// cart 
Route::post('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');

// Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
// Route::post('/cart/update', [CartController::class, 'updateQuantityProduct'])->name('cart.updateQuantityProduct');
// Route::post('/cart/order', [OrderController::class, 'showOrderForm'])->name('orders.showOrderForm');
// Route::post('/cart/order/placeOrder', [OrderController::class, 'placeOrder'])->name('orders.placeOrder');
 Route::get('/details', [OrderController::class, 'showOrderDetails'])->name('cart.details');
// Route::get('/cart/remove', [OrderController::class, 'removeAll'])->name('cart.removeAll');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/cart', CartController::class);
    // Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    // Route::delete('/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
    // Route::post('/update', [CartController::class, 'updateQuantityProduct'])->name('cart.updateQuantityProduct');
    // Route::post('/order', [OrderController::class, 'showOrderForm'])->name('orders.showOrderForm');
    // Route::post('/order/placeOrder', [OrderController::class, 'placeOrder'])->name('orders.placeOrder');
    // Route::get('/details', [OrderController::class, 'showOrderDetails'])->name('cart.details');
    // Route::get('/remove', [OrderController::class, 'removeAll'])->name('cart.removeAll');   
});