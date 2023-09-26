<?php


use App\Http\Controllers\Admin\ProductsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;

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

Route::get('/', [ProductsController::class, 'index'])->name('home');
Route::get('/home', [ProductsController::class, 'index'])->name('home');
// admin panel
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::delete('/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
Route::delete('/admin/products/{id}', [ProductsController::class, 'destroy'])->name('admin.products.delete');
Route::get('/admin/products/{id}/edit', [ProductsController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{id}', [ProductsController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/orders/{orderId}', [DashboardController::class, 'deleteOrder'])->name('admin.deleteOrder');
Route::get('/admin/create', [ProductsController::class, 'create'])->name('admin.products.create');
Route::put('/orders/{orderId}', [DashboardController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');


// store page and details 
Route::get('/store', [ProductsController::class, 'index'])->name('admin.products.index');
Route::post('/products', [ProductsController::class, 'store'])->name('admin.products.store');
Route::get('/search', [ProductsController::class, 'search']);
Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');
Route::get('/load-more-products', [ProductsController::class, 'loadMoreProducts']);



// cart 
Route::post('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.show');
Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/order', [OrderController::class, 'showOrderForm'])->name('orders.showOrderForm');
Route::post('/cart/order/placeOrder', [OrderController::class, 'placeOrder'])->name('orders.placeOrder');
Route::get('/cart/details', [OrderController::class, 'showOrderDetails'])->name('cart.details');
Route::get('/cart/remove', [OrderController::class, 'removeAll'])->name('cart.removeAll');
