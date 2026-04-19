<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'name',
        'type',
        'value',
        'start_date',
        'end_date',
        'status',
        'history_log',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
        'history_log' => 'json',
    ];

    /**
     * The items that belong to the discount.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_discounts', 'discount_id', 'item_id');
    }
}
