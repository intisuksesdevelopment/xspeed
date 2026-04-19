<?php

namespace App\Http\Controllers;

use App\Services\BankService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Services\ItemService;
use App\Services\PaymentService;
use App\Services\SalesService;
use App\Services\UtilService;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $request = new Request([
            'per_page' => 10,
            'sortBy' => 'name',
            'sortDirection' => 'asc',
            'page' => 1,
        ]);
        $data['items'] = ItemService::getActive($request);
        $data['categories'] = CategoryService::getActive($request);
        $data['sales'] = SalesService::getActive($request);
        $data['customers'] = CustomerService::getActive($request);
        $data['paymentMethods'] = PaymentService::getActive($request);
        $data['banks'] = BankService::getActive($request);
        UtilService::convertToIdr(100, 'USD');

        return view('pages.pos.pos', $data);
    }

    public function add(Request $request)
    {

        return SalesService::save($request);
    }
}
