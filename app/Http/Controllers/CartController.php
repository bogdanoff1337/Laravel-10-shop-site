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

    if (auth()->check()) {

        $userId = auth()->id();

        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        $total = $cartItems->sum(function ($item) {

            return $item->product->price * $item->quantity;

        });

        $cartCount = $this->getCartQuantity(Auth::id());

        return view('cart.show', compact('cartItems', 'total', 'cartCount'));

    }

     // Якщо користувач не автентифікований
    return view('cart.show', compact('cartItems', 'total', 'cartCount'));

    }


    public function add(Request $request): RedirectResponse
    {

        if (!Auth::check()) {
            // Якщо користувач не зареєстрований, перенаправити на сторінку логіну
            return redirect()->route('login')->with('error', 'Please login to add products to your cart.');
        }
        // Отримати дані про товар, який додається до кошика
        $productId = $request->input('id');
        $quantity = $request->input('quantity');

        // Отримати інформацію про телефон за його ідентифікатором
        $Product = Product::findOrFail($productId);

        // Створити новий запис у таблиці cart_items для поточного користувача та обраного товару
        $cartItem = new CartItem;
        $cartItem->user_id = Auth::id();
        $cartItem->Product_id = $Product->id; // Встановити значення для поля Product_id
        $cartItem->quantity = $quantity;
        $cartItem->save();



        return Redirect()->back()->with('success', 'Product added to cart successfully.');

    }

    public function update(Request $request): RedirectResponse
    {
    $cartItemId = $request->input('cartItemId');
    $quantity = $request->input('quantity');

    $cartItem = CartItem::find($cartItemId);
    if ($cartItem) {
        $cartItem->quantity = $quantity;
        $cartItem->save();
    }

    return Redirect()->route('cart.show', ['cartItemId' => $cartItemId]);
    }

    

    public function remove($cartItemId): RedirectResponse
    {

        // Знайти та видалити елемент кошика з вказаним ID
       
        $cartItem = CartItem::findOrFail($cartItemId);

        // Виконати видалення елемента кошика
        $cartItem->delete();

        return Redirect()->back()->with('success', 'Product removed from cart successfully.');

    }


    private function calculateTotal($cartItems)
    {

        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;

    }

    public function getCartQuantity(int $userId): int
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item->quantity;
        }

        return $totalQuantity;
    }
}
