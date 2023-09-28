<?php

namespace App\Http\Controllers;


use App\Models\Order;
use Illuminate\Contracts\View\View;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $order;
    public function __construct(Order $order)


    {
        $this->order = $order;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() : View
    {
        // Retrieve the order from the database
        $order = app('order');

        return view('index', compact('order'));
    }
}
