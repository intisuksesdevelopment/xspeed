<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
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

    public function validateAttributes($attributes)
    {
        $validator = Validator::make($attributes, [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'status' => 'required|integer|in:0,1',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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
}
