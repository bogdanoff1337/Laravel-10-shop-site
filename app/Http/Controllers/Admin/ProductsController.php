<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\CartItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    public function index(): View
    {
        // Отримуємо всі продукти та сортуємо їх за датою створення у зворотньому порядку
        $products = Product::orderBy('created_at', 'desc')->get();

        // Обрізаємо опис продуктів до перших 60 символів
        foreach ($products as $product) {
            $product->description = substr($product->description, 0, 60);
        }


        return view('admin.products.index', compact('products'));
    }


    public function create(): View
    {
        return view('admin.products.create');
    }


    public function store(Request $request): RedirectResponse
    {
        // Отримуємо дані з форми
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $stock_quantity = $request->input('stock_quantity');
        $photo = $request->file('photo');

        // Створюємо новий запис для продукту
        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->stock_quantity = $stock_quantity;

        // Завантажуємо фотографію
        if ($photo) {
            $photoPath = $photo->store('public/photos');
            $product->photo = $photoPath;
        }

        $product->save();

        // Перенаправляємо на сторінку індексу продуктів
        return Redirect()->route('admin.products.index');
    }

    public function edit(int $id): View
    {
        // Знаходимо продукт за його ідентифікатором
        $product = Product::find($id);



        return view('admin.products.edit', compact('product', 'cartCount'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        // Отримуємо дані з форми
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $stock_quantity = $request->input('stock_quantity');

        $photo = $request->file('photo');

        // Знаходимо продукт за його ідентифікатором
        $product = Product::find($id);

        // Оновлюємо дані продукту
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->stock_quantity = $stock_quantity;


        // Зміна фотографії
        if ($photo) {
            // Видаляємо попередню фотографію, якщо вона існує
            if ($product->photo) {
                Storage::delete($product->photo);
            }

            // Зберігаємо нову фотографію
            $photoPath = $photo->store('photos');
            $product->photo = $photoPath;
        }

        $product->save();

        // Перенаправляємо на сторінку індексу адміністраторської панелі
        return redirect()->route('admin.dashboard');
    }

    public function show(int $id): View
    {
        // Знаходимо продукт за його ідентифікатором
        $product = Product::find($id);


        return view('admin.products.details', compact('product'));
    }
}
