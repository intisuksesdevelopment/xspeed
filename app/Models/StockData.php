<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StockData extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'stock_id',
        'item_id',
        'item_stock',
        'item_price',
        'rack',
        'qty',
        'diff',
        'price_total',
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
     * The attributes that should be cast.
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

    /**
     * Validate the attributes of the model.
     *
     * @param array $attributes
     * @param int|null $id
     * @return bool
     * @throws ValidationException
     */
    public function validateAttributes($attributes, $id = null)
    {
        $validator = Validator::make($attributes, [
            'stock_id' => 'required|integer',
            'item_id' => 'required|integer',
            'item_stock' => 'required|numeric',
            'item_price' => 'required|numeric',
            'rack' => 'required|string|max:255',
            'qty' => 'required|numeric',
            'diff' => 'required|numeric',
            'price_total' => 'required|numeric',
            'created_by' => 'required|integer',
            'update_by' => 'nullable|integer',
            'status' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }

    /**
     * Get the status description.
     *
     * @return string
     */
    public function isStatus()
    {
        switch ($this->status) {
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
}
