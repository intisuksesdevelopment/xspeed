<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'desc',
        'method',
        'type',
        'status',
        'index',
        'created_date',
        'created_by',
        'update_date',
        'update_by',
        'created_at',
        'updated_at',

    ];
    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Available' : 'Not Available';
    }
}
