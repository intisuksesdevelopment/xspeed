<?php

namespace App\Services;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountService
{
    public static function getActive(Request $request = null)
    {
        return BankAccount::where('status', 0)
            ->with('bank')
            ->orderBy('bank_id', 'asc')
            ->orderBy('account_name', 'asc')
            ->get();
    }

    public static function getByOwnerType($ownerType)
    {
        return BankAccount::where('status', 0)
            ->where('owner_type', $ownerType)
            ->with('bank')
            ->orderBy('bank_id', 'asc')
            ->get();
    }

    public static function getStoreAccounts()
    {
        return self::getByOwnerType('store');
    }

    public static function getSupplierAccounts($supplierId = null)
    {
        $query = BankAccount::where('status', 0)
            ->where('owner_type', 'supplier')
            ->with('bank');

        if ($supplierId) {
            $query->where('owner_id', $supplierId);
        }

        return $query->orderBy('bank_id', 'asc')->get();
    }

    public static function getDetail($uuid)
    {
        return BankAccount::where('uuid', $uuid)
            ->with('bank')
            ->firstOrFail();
    }
}
