<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{

    public function delete($id): RedirectResponse
{
    $user = User::findOrFail($id);

    // Перевірка, чи у користувача є замовлення в таблиці "orders"
    $hasOrders = Order::where('user_id', $user->id)->exists();

    if ($hasOrders) {
        Session::flash('error', 'The user has orders in the orders table and cannot be deleted.');
        return redirect()->route('admin.dashboard');
    }

    $user->delete();

    Session::flash('success', 'The user has been deleted successfully.');
    return redirect()->route('admin.dashboard');
}

}
