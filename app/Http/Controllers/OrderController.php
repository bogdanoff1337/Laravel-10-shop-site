<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\StatusOrder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{

    public function showOrderForm(): View
    {
        // Отримуємо товари з кошика користувача
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

        // Розраховуємо загальну суму замовлення на основі товарів у кошику
        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem->product->price * $cartItem->quantity;
        }

        // Отримуємо кількість товарів у кошику користувача
        $cartCount = $this->getCartQuantity(Auth::id());

        return view('cart.order', compact('cartItems', 'total', 'cartCount'));
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        // Отримуємо товари з кошика користувача
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        // Створюємо нове замовлення
        $order = new Order;
        $order->order_number = Order::count() + 1;
        $order->user_id = Auth::id();
        $order->first_name = $request->input('first_name');
        $order->last_name = $request->input('last_name');
        $order->payment_method = $request->input('payment_method');
        $order->delivery_city = $request->input('delivery_city');

        // Створюємо новий статус замовлення
        $statusOrder = new StatusOrder();
        $statusOrder->status = 'pending';

        $order->save();
        $order->statusOrder()->save($statusOrder);

        // Зберігаємо товари з кошика як елементи замовлення
        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
            ]);
        }

        // Видаляємо товари з кошика
        $cartItems->each->delete();

        return Redirect()->route('cart.details')->with('success', 'Замовлення успішно оформлено.');
    }

    public function showOrderDetails(): View
    {
        // Отримуємо користувача, який увійшов в систему
        $user = auth()->user();
        
        // Отримуємо всі замовлення цього користувача
        $orders = Order::where('user_id', $user->id)->get();

        // Завантажуємо деталі кожного замовлення, включаючи товари
        foreach ($orders as $order) {
            $order->load('items.product');
        }

        // Отримуємо товари у кошику користувача
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        // Розраховуємо загальну суму товарів у кошику
        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem->product->price * $cartItem->quantity;
        }

        // Отримуємо кількість товарів у кошику користувача
        $cartCount = $this->getCartQuantity(Auth::id());

        return view('cart.details', compact('orders', 'cartCount', 'total'));
    }

    public function removeAll(): RedirectResponse
    {
        // Знаходимо всі елементи кошика для поточного користувача
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        // Виконуємо видалення всіх елементів кошика
        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }

        return Redirect()->back()->with('success', 'Всі товари успішно видалено з кошика.');
    }

    public function getCartQuantity(int $userId): int
    {
        // Отримуємо всі елементи кошика для користувача за його ідентифікатором
        $cartItems = CartItem::where('user_id', $userId)->get();

        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return $totalQuantity;
    }

}
