<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\StatusOrder;
use App\Models\Phone;

class OrderController extends Controller
{
    public function showOrderForm(Request $request)
    {
        $cartItems = CartItem::with('phone')->where('user_id', Auth::id())->get();

        // Кошик
        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem->phone->price * $cartItem->quantity;
        }

        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item->quantity;
        }

        return view('cart.order', compact('cartItems', 'total', 'totalQuantity'), ['cartItems' => $cartItems, 'total' => $total, 'totalQuantity' => $totalQuantity]);
    }

    public function placeOrder(Request $request)
    {
        // Отримати дані з кошика
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        // Створити нове замовлення
        $order = new Order;
        $order->order_number = Order::count() + 1;
        $order->user_id = Auth::id();
        $order->first_name = $request->input('first_name');
        $order->last_name = $request->input('last_name');
        $order->payment_method = $request->input('payment_method');
        $order->delivery_city = $request->input('delivery_city');

        $statusOrder = new StatusOrder();
        $statusOrder->status = 'pending';

        $order->save();
        $order->statusOrder()->save($statusOrder);
        // Зберегти товари з кошика як елементи замовлення
        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'phone_id' => $cartItem->phone_id,
                'quantity' => $cartItem->quantity,
            ]);
        }

        // Видалити товари з кошика
        $cartItems->each->delete();

        return redirect()->route('cart.details')->with('success', 'Order placed successfully.');
    }

    public function showOrderDetails()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->get();

        if ($orders->isEmpty()) {
            return redirect()->route('home')->with('error', 'You have no orders.');
        }

        foreach ($orders as $order) {
            $order->load('items.phone');
        }

        // Кошик
        $cartItems = CartItem::with('phone')->where('user_id', $user->id)->get();
        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem->phone->price * $cartItem->quantity;
        }

        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item->quantity;
        }

        return view('cart.details', compact('orders', 'totalQuantity', 'total'));
    }
    public function removeAll()
    {
        // Знайти всі елементи кошика для поточного користувача
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        // Виконати видалення елементів кошика
        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'All products removed from cart successfully.');
    }
}
