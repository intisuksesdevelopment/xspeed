<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
