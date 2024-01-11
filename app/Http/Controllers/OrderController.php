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

        return view('cart.order', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

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

        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
            ]);
        }
        
        $cartItems->each->delete();

        return Redirect()->route('cart.details')->with('success', 'Замовлення успішно оформлено.');
    }

    public function showOrderDetails(): View
    {
        $user = auth()->user();

        $orders = Order::where('user_id', $user->id)->get();

        foreach ($orders as $order) {
            $order->load('items.product');
        }

        // // Отримуємо товари у кошику користувача
        // $cartItems = OrderItem::with('product')->where('user_id', $user->id)->get();

        // // Розраховуємо загальну суму товарів у кошику
        // $total = 0;
        // foreach ($cartItems as $cartItem) {
        //     $total += $cartItem->product->price * $cartItem->quantity;
        // }


        return view('cart.details', compact('orders'));
    }

    public function removeAll(): RedirectResponse
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }

        return Redirect()->back()->with('success', 'Всі товари успішно видалено з кошика.');
    }
}
