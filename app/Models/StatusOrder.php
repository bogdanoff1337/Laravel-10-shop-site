<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    use HasFactory;
    protected $table = 'status_order';
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
