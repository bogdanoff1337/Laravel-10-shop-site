<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $userId = auth()->id();

        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        return view('cart.show', compact('cartItems'));
    }

    /**
     * Show the form for addToCart a new resource.
     */
    public function store(Request $request, $userId)
    {
        dd($userId);
        CartItem::create($request->with($userId)->all());
        return redirect('cart.show')->withSuccessMessage('Item was added to your cart!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $product = Product::find($id);

        return view('admin.products.details', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
