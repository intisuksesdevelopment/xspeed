<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Racks extends Model
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
}
