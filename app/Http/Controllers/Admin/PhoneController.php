<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Phone;
use Illuminate\Support\Facades\Storage;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PhoneController extends Controller
{
    public function create()
    {
        $cartItems = CartItem::with('phone')->where('user_id', Auth::id())->get();
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return view('admin.phones.create', ['totalQuantity' => $totalQuantity]);
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
        $phone = new Phone();
        $phone->brand = $brand;
        $phone->model = $model;
        $phone->price = $price;
        $phone->color = $color;
        $phone->storage = $storage;
        $phone->screen_size = $screenSize;
        $phone->ram = $ram;

        // Завантаження фотографії
        if ($photo) {
            $photoPath = $photo->store('public/photos');
            $phone->photo = $photoPath;
        }

        $phone->save();

        // Перенаправлення на потрібну сторінку після збереження
        return redirect()->route('admin.phones.index');
    }

    public function destroy($id)
    {
        // Знаходження телефону за його ідентифікатором
        $phone = Phone::find($id);

        // Перевірка, чи телефон знайдено
        if ($phone) {
            // Виконуємо видалення телефону
            $phone->delete();

            // Повертаємо користувача на потрібну сторінку з повідомленням про успішне видалення
            return redirect()->route('admin.dashboard')->with('success', 'Телефон успішно видалено.');
        } else {
            // Якщо телефон не знайдено, повертаємо користувача на потрібну сторінку з повідомленням про помилку
            return redirect()->route('admin.dashboard')->with('error', 'Телефон не знайдено.');
        }
    }

    public function edit($id)
    {
        $phone = Phone::find($id);
        $cartItems = CartItem::with('phone')->where('user_id', Auth::id())->get();
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }
        return view('admin.phones.edit', compact('phone'), ['totalQuantity' => $totalQuantity]);
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
        $phone = Phone::find($id);

        // Оновити дані телефону
        $phone->brand = $brand;
        $phone->model = $model;
        $phone->price = $price;
        $phone->color = $color;
        $phone->storage = $storage;
        $phone->screen_size = $screenSize;
        $phone->ram = $ram;

        // Зміна фотографії
        if ($photo) {
            // Видалення попередньої фотографії, якщо вона існує
            if ($phone->photo) {
                Storage::delete($phone->photo);
            }

            // Збереження нової фотографії
            $photoPath = $photo->store('photos');
            $phone->photo = $photoPath;
        }

        $phone->save();

        // Перенаправлення на потрібну сторінку після оновлення
        return redirect()->route('admin.dashboard');
    }

    public function index()
    {
        $phones = Phone::all();
        $cartCount = CartItem::where('user_id', Auth::id())->count();
        $cartItems = CartItem::with('phone')->where('user_id', Auth::id())->get();
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return view('admin.phones.index', compact('phones', 'cartCount'), ['totalQuantity' => $totalQuantity]);
    }

    public function show($id)
    {
        $phone = Phone::find($id);

        $cartCount = CartItem::where('user_id', Auth::id())->count();
        $cartItems = CartItem::with('phone')->where('user_id', Auth::id())->get();
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return view('admin.phones.details', compact('phone', 'cartCount'), ['totalQuantity' => $totalQuantity]);
    }
}
