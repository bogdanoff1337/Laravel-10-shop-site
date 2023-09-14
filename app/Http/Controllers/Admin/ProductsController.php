<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Facades\Storage;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProductsController extends Controller
{
    public function create()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return view('admin.products.create', ['totalQuantity' => $totalQuantity]);
    }

    public function store(Request $request)
    {
        // Отримання даних з форми
        $brand = $request->input('brand');
        $model = $request->input('model');
        $price = $request->input('price');
        $color = $request->input('color');
        $storage = $request->input('storage');
        $screenSize = $request->input('screen_size');
        $ram = $request->input('ram');
        $photo = $request->file('photo');

        // Збереження нового запису телефону
        $product = new product();
        $product->brand = $brand;
        $product->model = $model;
        $product->price = $price;
        $product->color = $color;
        $product->storage = $storage;
        $product->screen_size = $screenSize;
        $product->ram = $ram;

        // Завантаження фотографії
        if ($photo) {
            $photoPath = $photo->store('public/photos');
            $product->photo = $photoPath;
        }

        $product->save();

        // Перенаправлення на потрібну сторінку після збереження
        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        // Знаходження телефону за його ідентифікатором
        $product = product::find($id);

        // Перевірка, чи телефон знайдено
        if ($product) {
            // Виконуємо видалення телефону
            $product->delete();

            // Повертаємо користувача на потрібну сторінку з повідомленням про успішне видалення
            return redirect()->route('admin.dashboard')->with('success', 'Телефон успішно видалено.');
        } else {
            // Якщо телефон не знайдено, повертаємо користувача на потрібну сторінку з повідомленням про помилку
            return redirect()->route('admin.dashboard')->with('error', 'Телефон не знайдено.');
        }
    }

    public function edit($id)
    {
        $product = product::find($id);
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }
        return view('admin.products.edit', compact('product'), ['totalQuantity' => $totalQuantity]);
    }

    public function update(Request $request, $id)
    {
        // Отримання даних з форми
        $brand = $request->input('brand');
        $model = $request->input('model');
        $price = $request->input('price');
        $color = $request->input('color');
        $storage = $request->input('storage');
        $screenSize = $request->input('screen_size');
        $ram = $request->input('ram');
        $photo = $request->file('photo');

        // Знайдіть телефон за його ідентифікатором
        $product = product::find($id);

        // Оновити дані телефону
        $product->brand = $brand;
        $product->model = $model;
        $product->price = $price;
        $product->color = $color;
        $product->storage = $storage;
        $product->screen_size = $screenSize;
        $product->ram = $ram;

        // Зміна фотографії
        if ($photo) {
            // Видалення попередньої фотографії, якщо вона існує
            if ($product->photo) {
                Storage::delete($product->photo);
            }

            // Збереження нової фотографії
            $photoPath = $photo->store('photos');
            $product->photo = $photoPath;
        }

        $product->save();

        // Перенаправлення на потрібну сторінку після оновлення
        return redirect()->route('admin.dashboard');
    }

    public function index()
    {
        $products = product::all();
        $cartCount = CartItem::where('user_id', Auth::id())->count();
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return view('admin.products.index', compact('products', 'cartCount'), ['totalQuantity' => $totalQuantity]);
    }

    public function show($id)
    {
        $product = product::find($id);

        $cartCount = CartItem::where('user_id', Auth::id())->count();
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return view('admin.products.details', compact('product', 'cartCount'), ['totalQuantity' => $totalQuantity]);
    }
}
