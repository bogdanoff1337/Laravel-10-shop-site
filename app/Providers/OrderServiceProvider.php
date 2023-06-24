<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Auth::check()) {
            // Отримати останнє замовлення для поточного користувача
            $order = Order::where('user_id', Auth::user()->id)->latest()->first();

            // Поділити екземпляр замовлення з усіма шаблонами та контролерами
            $this->app->singleton('order', function ($app) use ($order) {
                return $order;
            });
        }
    }
}
