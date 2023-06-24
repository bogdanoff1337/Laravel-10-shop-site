<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $cartItems = CartItem::with('phone')->where('user_id', Auth::id())->get();

        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem->phone->price * $cartItem->quantity;
        }

        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return view('cart.show', compact('cartItems', 'total'), ['cartItems' => $cartItems, 'total' => $total, 'totalQuantity' => $totalQuantity]);
    }


    public function add(Request $request)
    {
        if (!Auth::check()) {
            // Якщо користувач не зареєстрований, перенаправити на сторінку логіну
            return redirect()->route('login')->with('error', 'Please login to add products to your cart.');
        }
        // Отримати дані про товар, який додається до кошика
        $productId = $request->input('id');
        $quantity = $request->input('quantity');

        // Отримати інформацію про телефон за його ідентифікатором
        $phone = Phone::findOrFail($productId);

        // Створити новий запис у таблиці cart_items для поточного користувача та обраного товару
        $cartItem = new CartItem;
        $cartItem->user_id = Auth::id();
        $cartItem->phone_id = $phone->id; // Встановити значення для поля phone_id
        $cartItem->quantity = $quantity;
        $cartItem->save();



        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function remove($cartItemId)
    {
        // Знайти та видалити елемент кошика з вказаним ID
        // Знайти елемент кошика за його ідентифікатором
        $cartItem = CartItem::findOrFail($cartItemId);

        // Виконати видалення елемента кошика
        $cartItem->delete();

        return redirect()->back()->with('success', 'Product removed from cart successfully.');
    }
    public function index()
    {
        // Отримуємо дані кошика з сесії
        $cartItems = session()->get('cart', []);
        $total = $this->calculateTotal($cartItems);


        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return view('cart.show', ['cartItems' => $cartItems, 'total' => $total, 'totalQuantity' => $totalQuantity]);
    }

    public function placeOrder()
    {
        // Отримуємо дані кошика з сесії
        $cartItems = session()->get('cart', []);

        // Розраховуємо загальну суму покупки
        $total = $this->calculateTotal($cartItems);

        // Виконуємо додаткову логіку для оформлення замовлення
        // ...

        // Очищаємо кошик після оформлення замовлення
        session()->forget('cart');

        return redirect()->route('order.create')->with('success', 'Your order has been placed successfully.');
    }

    private function calculateTotal($cartItems)
    {
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }
    public function increment($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem) {
            $cartItem->quantity++;
            $cartItem->save();
        }

        return redirect()->route('cart.show');
    }
    public function decrement($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->quantity--;
            $cartItem->save();
        }

        return redirect()->route('cart.show');
    }
    public function removeAll($userId)
    {
        // Знайти та видалити всі елементи кошика для вказаного користувача
        CartItem::where('user_id', $userId)->delete();

        return redirect()->back()->with('success', 'All products removed from cart successfully.');
    }
}
