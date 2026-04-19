<?php

namespace App\Services;

use App\Constants\CommonConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE); // Default to 10 per page if not provided

        // Construct the raw SQL query as a string
        $sql = 'SELECT * FROM `payment_methods` WHERE `status` = 0 ORDER BY `index` ASC';

        // Execute the query and get the results
        $paymentMethods = DB::select($sql);

        $paymentMethodsArray = json_decode(json_encode($paymentMethods), true);

        return $paymentMethodsArray;
    }
}
