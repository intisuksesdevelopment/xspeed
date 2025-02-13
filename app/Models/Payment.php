<?php
namespace App\Models;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'trx_id',
        'ref_id',
        'ref',
        'type',
        'desc',
        'expired_date',
        'payment_date',
        'sub_total',
        'disc_percent',
        'disc_total',
        'tax_percent',
        'tax_total',
        'dp_total',
        'final_total',
        'payment_total',
        'payment_method_id',
        'payment_data',
        'created_date',
        'created_by',
        'update_date',
        'update_by',
        'status',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
