<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Stock extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'periode',
        'warehouse_id',
        'total_item',
        'stock_total',
        'qty_total',
        'diff_total',
        'diff_price_total',
        'price_total',
        'approval_id',
        'created_at',
        'updated_at',
        'created_by',
        'update_by',
        'status',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function validateAttributes($attributes, $id = null)
    {
        $validator = Validator::make($attributes, [
            'uuid'             => 'required|uuid|unique:items,uuid,' . $id,
            'periode'          => 'required|string|max:255',
            'warehouse_id'     => 'required|integer',
            'total_item'       => 'required|integer',
            'stock_total'      => 'required|numeric',
            'qty_total'        => 'required|numeric',
            'diff_total'       => 'required|numeric',
            'diff_price_total' => 'required|numeric',
            'price_total'      => 'required|numeric',
            'approval_id'      => 'required|integer',
            'created_by'       => 'required|integer',
            'update_by'        => 'nullable|integer',
            'status'           => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
    public function isStatus()
    {
        switch ($this['status']) {
            case 0:
                return 'Success';
            case 1:
                return 'Rejected';
            case 2:
                return 'Waiting';
            default:
                return 'Unknown Status';
        }
    }

    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Available' : 'Not Available';
    }
}
