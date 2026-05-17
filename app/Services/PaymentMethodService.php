<?php

namespace App\Services;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodService
{
    public static function getActive(Request $request = null)
    {
        return PaymentMethod::where('status', 0)
            ->orderBy('index', 'asc')
            ->get();
    }

    public static function getAll()
    {
        return PaymentMethod::orderBy('index', 'asc')->get();
    }
}
