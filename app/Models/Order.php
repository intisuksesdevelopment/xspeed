<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'trx_id',
        'order_id',
        'type',
        'supplier_id',
        'supplier_name',
        'supplier_position',
        'supplier_address',
        'supplier_phone',
        'supplier_email',
        'name',
        'desc',
        'dept_id',
        'tax_percent',
        'tax_total',
        'disc_percent',
        'disc_total',
        'dp_total',
        'up_total',
        'sub_total',
        'sub_total_item',
        'final_total',
        'payment_id',
        'payment_data',
        'expired_date',
        'payment_date',
        'payment_status',
        'currency',
        'created_at',
        'process_at',
        'update_at',
        'confirm_at',
        'created_by',
        'process_by',
        'confirm_by',
        'update_by',
        'status',
    ];
    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Available' : 'Not Available';
    }
}
