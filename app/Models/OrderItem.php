<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'item_id',
        'item_code',
        'item_name',
        'item_amount',
        'item_amount_received',
        'unit',
        'price',
        'discount',
        'total',
        'created_by',
        'updated_by',
        'status',
    ];

    // =========================
    // RELATION
    // =========================
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // =========================
    // HELPER
    // =========================

    public function getRemainingQtyAttribute()
    {
        return ($this->item_amount ?? 0) - ($this->item_amount_received ?? 0);
    }

    public function isCompleted()
    {
        return $this->item_amount_received >= $this->item_amount;
    }
}
