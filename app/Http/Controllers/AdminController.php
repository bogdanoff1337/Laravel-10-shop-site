<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function delete(int $id): RedirectResponse
    {
        // Знаходження користувача за його ID
        $user = User::findOrFail($id);

        // Перевірка, чи у користувача є замовлення в таблиці "orders"
        $hasOrders = Order::where('user_id', $user->id)->exists();

        if ($hasOrders) {
            // Якщо у користувача є замовлення, встановити флеш-повідомлення про неможливість видалення
            Session::flash('error', 'Користувач має замовлення в таблиці "замовлення" і не може бути видалений.');
            return redirect()->route('admin.dashboard');
        }

        // Виконати видалення користувача
        $user->delete();

        // Встановити флеш-повідомлення про успішне видалення
        Session::flash('success', 'Користувача успішно видалено.');

        return redirect()->route('admin.dashboard');
    }
}
