<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Facades\Storage;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    
    public function index()
    {
    $products = Product::orderBy('created_at', 'desc')->get();

    foreach ($products as $product) {
        $product->description = substr($product->description, 0, 60); // Обрізка до перших 60 символів
    }

    $cartCount = $this->getCartQuantity(Auth::id());

    return view('admin.products.index', compact('products', 'cartCount'));
    }

    public function getCartQuantity($userId = null): int
    {
        $cartItems = CartItem::where('user_id', $userId)->get();
    
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }
    
        return $totalQuantity;
    }

    public function create()
    {
        $cartCount = $this->getCartQuantity(Auth::id());
    
        return view('admin.products.create', ['cartCount' => $cartCount]);
    }
    

    public function store(Request $request)
    {
        // Отримання даних з форми
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $stock_quantity = $request->input('stock_quantity');
        $photo = $request->file('photo');

        // Збереження нового запису телефону
        $product = new product();
        $product->name = $name;
        $product->description  = $description ;
        $product->price = $price;
        $product->stock_quantity  = $stock_quantity ;

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
            return redirect()->route('admin.dashboard')->with('success', 'Product is deleted.' );
        } else {
            // Якщо телефон не знайдено, повертаємо користувача на потрібну сторінку з повідомленням про помилку
            return redirect()->route('admin.dashboard')->with('error', 'Product is not found');
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
    
        $cartCount = $this->getCartQuantity(Auth::id());
    
        return view('admin.products.edit', compact('product', 'cartCount'));
    }

    public function update(Request $request, $id)
    {
        // Отримання даних з форми
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $stock_quantity = $request->input('stock_quantity');
       
        $photo = $request->file('photo');

        // Знайдіть телефон за його ідентифікатором
        $product = product::find($id);

        // Оновити дані телефону
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->stock_quantity = $stock_quantity;
    

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

    public function show($id)
    {
        $product = Product::find($id);
    
        $cartCount = $this->getCartQuantity(Auth::id());
    
        return view('admin.products.details', compact('product', 'cartCount'));
    }
}
