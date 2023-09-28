<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\StatusOrder;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
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

    public function updateOrderStatus(Request $request, int $orderId) : RedirectResponse
    {
        $order = Order::findOrFail($orderId);

        $statusOrder = $order->statusOrder;

        if (!$statusOrder) {
            $statusOrder = new StatusOrder();
            $statusOrder->order_id = $order->id;
        }

        $statusOrder->status = $request->input('status');
        $statusOrder->save();

        return Redirect()->back()->with('success', 'Order status update.');
    }

    public function deleteProduct(string $id): RedirectResponse
    {
        // Знаходження продукту за його ідентифікатором
        $product = Product::find($id);
    
        // Перевірка, чи продукт знайдено
        if ($product) {
            // Перевірка, чи є замовлення, які мають цей продукт
            $ordersWithProduct = OrderItem::where('product_id', $product->id)->exists();
    
            if ($ordersWithProduct) {
                // Якщо є замовлення з цим продуктом, встановити флеш-повідомлення про неможливість видалення
                Session::flash('error', 'Product cannot be deleted because it is associated with existing orders.');
            } else {
                // Виконуємо видалення продукту, якщо його можна видалити
                $product->forceDelete();
    
                // Встановлюємо флеш-повідомлення про успішне видалення
                Session::flash('success', 'Product is deleted.');
            }
        } else {
            // Якщо продукт не знайдено, встановити флеш-повідомлення про помилку
            Session::flash('error', 'Product is not found');
        }
    
        // Повертаємо користувача на потрібну сторінку
        return redirect()->route('admin.dashboard');
    }
    

    public function deleteOrder(int $orderId): RedirectResponse
    {
        $order = Order::findOrFail($orderId);

        // Видалити усі пов'язані записи з таблиці `order_items`
        $order->items()->delete();

        // Видалити замовлення
        $order->delete();

        return Redirect()->back()->with('success', 'Order deleted successfully.');
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
