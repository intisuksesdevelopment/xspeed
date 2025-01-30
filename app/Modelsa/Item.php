<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'name',
        'category_id',
        'subcategory_id',
        'warehouse_id',
        'rack_id',
        'basic_price',
        'sell_price',
        'quantity',
        'unit',
        'color',
        'stock',
        'stock_min',
        'currency',
        'sku',
        'desc',
        'image_url',
        'status',
        'created_by',
        'updated_by',
        'history_log',
    ];
}
