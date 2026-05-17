<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'bank_id',
        'owner_type',
        'owner_id',
        'account_number',
        'account_name',
        'branch',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'owner_id')->where('owner_type', 'supplier');
    }

    public function isAvailable()
    {
        return $this->status == 0 ? 'Available' : 'Not Available';
    }

    public function getFullAccountInfoAttribute()
    {
        return "{$this->bank->name} - {$this->account_number} ({$this->account_name})";
    }
}
