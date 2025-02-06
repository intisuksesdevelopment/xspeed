<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'address',
        'phone',
        'image_url',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Available' : 'Not Available';
    }
}
