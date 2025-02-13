<?php
namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
        'image_url',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['item_count'];

    public function validateAttributes($attributes)
    {
        $validator = Validator::make($attributes, [
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url',
            'status'      => 'required|integer|in:0,1',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Available' : 'Not Available';
    }
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function countItems()
    {
        return $this->items()->count();
    }
    public function getItemCountAttribute()
    {
        return $this->items()->count();
    }
}
