<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'ref_id',
        'ref',
        'name',
        'position',
        'phone',
        'address',
        'email',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
    
    protected $hidden = [
        'id'
    ];

    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Available' : 'Not Available';
    }
}
