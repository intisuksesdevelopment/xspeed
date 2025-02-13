<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleData extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'sales_id',
        'item_id',
        'item_code',
        'item_desc',
        'item_name',
        'item_amount',
        'item_amount_received',
        'item_unit',
        'item_price',
        'item_disc',
        'item_disc_total',
        'item_total',
        'created_date',
        'sent_date',
        'update_date',
        'created_by',
        'update_by',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'update_by');
    }
}
