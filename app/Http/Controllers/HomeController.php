<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;


class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(12);
        // dd($products);

        foreach ($products as $product) {
            $product->description = substr($product->description, 0, 30);
        }

        return view('products.index', compact('products'));
    }
}
