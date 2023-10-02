<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    
    public function index(): View
    {
        // Перевірка, чи користувач автентифікований
        if (auth()->check()) {
            // Якщо користувач автентифікований, отримуємо його ID
            $userId = auth()->id();

            // Отримуємо товари з кошика користувача
            $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

            // Розраховуємо загальну суму замовлення на основі товарів у кошику
            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Отримуємо кількість товарів у кошику користувача
            $cartCount = $this->getCartQuantity(Auth::id());

            return view('cart.show', compact('cartItems', 'total', 'cartCount'));
        }

        // Якщо користувач не автентифікований, все одно відображаємо сторінку кошика
        return view('cart.show', compact('cartItems', 'total', 'cartCount'));
    }

    public function add(Request $request): RedirectResponse
    {
        // Перевірка, чи користувач автентифікований
        if (!Auth::check()) {
            // Якщо користувач не зареєстрований, перенаправляємо його на сторінку логіну з повідомленням
            return redirect()->route('login')->with('error', 'Будь ласка, увійдіть, щоб додавати товари в кошик.');
        }

        // Отримання даних про товар, який додається до кошика
        $productId = $request->input('id');
        $quantity = $request->input('quantity');

        // Отримання інформації про товар за його ідентифікатором
        $product = Product::findOrFail($productId);

        // Створення нового запису у таблиці cart_items для поточного користувача та обраного товару
        $cartItem = new CartItem;
        $cartItem->user_id = Auth::id();
        $cartItem->product_id = $product->id;
        $cartItem->quantity = $quantity;
        $cartItem->save();

        return Redirect()->back()->with('success', 'Товар успішно додано до кошика.');
    }

    public function updateQuantityProduct(Request $request): RedirectResponse
    {
        // Отримання ID елемента кошика та нової кількості товару
        $cartItemId = $request->input('cartItemId');
        $quantity = $request->input('quantity');

        // Знаходження елемента кошика за його ID
        $cartItem = CartItem::find($cartItemId);

        // Оновлення кількості товару у кошику
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return Redirect()->route('cart.show', ['cartItemId' => $cartItemId]);
    }

    public function remove(int $cartItemId): RedirectResponse
{
    // Знаходження елемента кошика за вказаним ID
    $cartItem = CartItem::find($cartItemId);

    // Перевірка, чи був елемент знайдений
    if ($cartItem) {
        // Виконання видалення елемента кошика
        $cartItem->delete();
        return Redirect()->back()->with('success', 'Товар успішно видалено з кошика.');
    } else {
        // Обробка ситуації, коли елемент не знайдено
        return Redirect()->back()->with('error', 'Товар з вказаним ID не знайдено в кошику.');
    }
}

    public function getCartQuantity(int $userId): int
    {
        // Отримання всіх елементів кошика для користувача за його ID
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item->quantity;
        }

        return $totalQuantity;
    }
}
