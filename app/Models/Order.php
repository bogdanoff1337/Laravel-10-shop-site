<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'order_number', 'user_id', 'first_name', 'last_name', 'payment_method', 'delivery_city'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = static::generateOrderNumber();
        });
    }

    public static function generateOrderNumber()
    {
        // Генерація унікального номера замовлення, наприклад, на основі поточного часу або іншого алгоритму
        return time(); // Приклад: використання часу як номера замовлення
    }

    // Зв'язок "один до багатьох" з моделлю OrderItem


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function statusOrder()
    {
        return $this->hasOne(StatusOrder::class);
    }
}
