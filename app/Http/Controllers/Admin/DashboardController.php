<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\StatusOrder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): View
    {
        $users = User::paginate(10);

        $products = Product::paginate(10);

        $orders = Order::with('items.product', 'user')->get();

        $groupedOrders = $orders->groupBy('order_number');

        $total = 0;

        return view('admin.dashboard', [
            'users' => $users,
            'products' => $products,
            'orders' => $orders,
            'groupedOrders' => $groupedOrders,
            'total' => $total,
        ]);
    }

    public function updateOrderStatus(Request $request, int $orderId): RedirectResponse
    {
        $order = Order::findOrFail($orderId);

        $statusOrder = $order->statusOrder;

        if (!$statusOrder) {
            $statusOrder = new StatusOrder();
            $statusOrder->order_id = $order->id;
        }

        $statusOrder->status = $request->input('status');
        $statusOrder->save();

        return Redirect()->back()->with('success', 'Статус замовлення оновлено.');
    }

    public function deleteOrder(int $orderId): RedirectResponse
    {
        $order = Order::findOrFail($orderId);

        $order->items()->delete();

        $order->delete();

        return Redirect()->back()->with('success', 'Замовлення успішно видалено.');
    }
}
