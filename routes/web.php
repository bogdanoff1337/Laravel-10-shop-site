<?php


use App\Http\Controllers\Admin\PhoneController;
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


Route::get('/', [PhoneController::class, 'index'])->name('home');
// admin panel
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::delete('/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
Route::delete('/admin/phones/{id}', [PhoneController::class, 'destroy'])->name('admin.phones.delete');
Route::get('/admin/phones/{id}/edit', [PhoneController::class, 'edit'])->name('admin.phones.edit');
Route::put('/admin/phones/{id}', [PhoneController::class, 'update'])->name('admin.phones.update');
Route::delete('/admin/orders/{orderId}', [DashboardController::class, 'deleteOrder'])->name('admin.deleteOrder');
Route::get('/admin/create', [PhoneController::class, 'create'])->name('admin.phones.create');
Route::put('/orders/{orderId}', [DashboardController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
// store page and details 


Route::get('/store', [PhoneController::class, 'index'])->name('admin.phones.index');
Route::post('/phones', [PhoneController::class, 'store'])->name('admin.phones.store');
Route::post('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');

// cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.show');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/increment/{cartItemId}', [CartController::class, 'increment'])->name('cart.increment');
Route::post('cart/decrement/{cartItemId}', [CartController::class, 'decrement'])->name('cart.decrement');
Route::post('/cart/order', [OrderController::class, 'showOrderForm'])->name('orders.showOrderForm');
Route::post('/cart/order/placeOrder', [OrderController::class, 'placeOrder'])->name('orders.placeOrder');
Route::get('/cart/details', [OrderController::class, 'showOrderDetails'])->name('cart.details');
Route::get('/cart/remove', [OrderController::class, 'removeAll'])->name('cart.removeAll');
