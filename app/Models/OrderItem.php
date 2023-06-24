<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['phone_id', 'quantity'];

    use HasFactory;
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id');
    }
}
