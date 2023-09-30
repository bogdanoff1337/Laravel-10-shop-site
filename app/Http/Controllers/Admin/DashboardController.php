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
        // Отримуємо всіх користувачів
        $users = User::all();
        
        // Отримуємо всі продукти
        $products = Product::all();
        
        // Отримуємо всі замовлення разом з інформацією про продукти та користувачів
        $orders = Order::with('items.product', 'user')->get();

        // Групуємо замовлення за номерами
        $groupedOrders = $orders->groupBy('order_number');
        
        // Сума для кошика
        $total = 0;
        
        // Отримуємо всі елементи кошика для поточного користувача
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        // Отримуємо загальну кількість товарів у кошику для поточного користувача
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

    public function updateOrderStatus(Request $request, int $orderId): RedirectResponse
    {
        // Знаходимо замовлення за його ідентифікатором
        $order = Order::findOrFail($orderId);

        // Знаходимо статус замовлення
        $statusOrder = $order->statusOrder;

        // Якщо статус не існує, створюємо новий
        if (!$statusOrder) {
            $statusOrder = new StatusOrder();
            $statusOrder->order_id = $order->id;
        }

        // Оновлюємо статус замовлення
        $statusOrder->status = $request->input('status');
        $statusOrder->save();

        return Redirect()->back()->with('success', 'Статус замовлення оновлено.');
    }

    public function deleteProduct(int $id): RedirectResponse
    {
        // Знаходимо продукт за його ідентифікатором
        $product = Product::find($id);

        // Перевіряємо, чи продукт був знайдений
        if ($product) {
            // Перевіряємо, чи існують замовлення, які містять цей продукт
            $ordersWithProduct = OrderItem::where('product_id', $product->id)->exists();

            if ($ordersWithProduct) {
                // Якщо є замовлення з цим продуктом, встановлюємо повідомлення про неможливість видалення
                Session::flash('error', 'Продукт не може бути видалений, оскільки він пов’язаний з наявними замовленнями.');
            } else {
                // Видаляємо продукт, якщо його можна видалити
                $product->forceDelete();

                // Встановлюємо повідомлення про успішне видалення
                Session::flash('success', 'Продукт видалено.');
            }
        } else {
            // Якщо продукт не було знайдено, встановлюємо повідомлення про помилку
            Session::flash('error', 'Продукт не знайдено.');
        }

        // Повертаємо користувача на потрібну сторінку
        return redirect()->route('admin.dashboard');
    }

    public function deleteOrder(int $orderId): RedirectResponse
    {
        // Знаходимо замовлення за його ідентифікатором
        $order = Order::findOrFail($orderId);

        // Видаляємо всі пов’язані записи з таблиці `order_items`
        $order->items()->delete();

        // Видаляємо саме замовлення
        $order->delete();

        return Redirect()->back()->with('success', 'Замовлення успішно видалено.');
    }

    public function getCartQuantity(int $userId): int
    {
        // Отримуємо всі елементи кошика для користувача за його ідентифікатором
        $cartItems = CartItem::where('user_id', $userId)->get();

        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
        }

        return $totalQuantity;
    }
}
