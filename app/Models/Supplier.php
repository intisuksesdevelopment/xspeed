<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'email',
        'phone',
        'address',
        'country',
        'province',
        'city',
        'district',
        'sub_district',
        'npwp',
        'discount',
        'status',
        'created_ad',
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
