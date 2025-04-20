<?php
namespace App\Models;

use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'trx_id',
        'type',
        'name',
        'description',
        'tax_percent',
        'tax_total',
        'disc_percent',
        'disc_total',
        'dp_total',
        'up_total',
        'sub_total',
        'charge_data',
        'charge_total',
        'sub_total_item',
        'final_total',
        'payment_id',
        'payment_data',
        'expired_date',
        'payment_amount',
        'payment_change',
        'payment_remaining',
        'payment_status',
        'payment_at',
        'currency',
        'created_by',
        'process_by',
        'confirm_by',
        'update_by',
        'status',
        'cust_id',
        'cust_address',
        'cust_phone',
        'cust_name',
        'cust_email',
        'created_at',
        'updated_at',
        'process_at',
        'confirm_at',

    ];
    protected $hidden = [
        'id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function buyer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Available' : 'Not Available';
    }
    public function isPaymentStatus()
    {
        switch ($this['payment_status']) {
            case 0:
                return __('payment.paid');
            case 1:
                return __('payment.unpaid');
            case 2:
                return __('payment.hold');
            case 3:
                return __('payment.other');
            default:
                return __('payment.unkonwn');
        }
    }
}
