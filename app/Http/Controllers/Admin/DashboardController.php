<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\StatusOrder;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $products = Product::all();
        $orders = Order::with('items.product', 'user')->get();

        $groupedOrders = $orders->groupBy('order_number');
        // кошик
        $total = 0;

        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

        $cartCount = $this->getCartQuantity(Auth::id());

        return view('admin.dashboard', [
            'users' => $users,
            'products' => $products,
            'orders' => $orders,
            'groupedOrders' => $groupedOrders,
            'cartItems' => $cartItems,
            'total' => $total,
            'cartCount' => $cartCount,
        ]);
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $statusOrder = $order->statusOrder;

        if (!$statusOrder) {
            $statusOrder = new StatusOrder();
            $statusOrder->order_id = $order->id;
        }

        $statusOrder->status = $request->input('status');
        $statusOrder->save();

        // Отримання оновленого статусу замовлення
        $updatedStatus = $statusOrder->status;

        // Повернення відповіді з оновленим статусом замовлення
        return redirect()->back()->with('success', 'Order status update.');
    }

    public function deleteOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Видалити усі пов'язані записи з таблиці `order_items`
        $order->items()->delete();

        // Видалити замовлення
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }

    public function getCartQuantity(int $userId): int
    {
        $cartItems = CartItem::where('user_id', $userId)->get();
    
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }
    
        return $totalQuantity;
    }
    
}
