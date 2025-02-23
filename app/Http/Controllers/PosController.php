<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BankService;
use App\Services\ItemService;
use App\Services\UtilService;
use App\Services\SalesService;
use App\Services\PaymentService;
use App\Services\CategoryService;
use App\Services\CustomerService;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $request = new Request([
            'per_page' => 10,
            'sortBy' => 'name',
            'sortDirection' => 'asc',
            'page' => 1
        ]);
        $data['items'] = ItemService::getActive($request);
        $data['categories'] = CategoryService::getActive($request);
        $data['sales'] = SalesService::getActive($request);
        $data['customers']    = CustomerService::getActive($request);
        $data['paymentMethods']    = PaymentService::getActive($request);
        $data['banks']    = BankService::getActive($request);
        UtilService::convertToIdr(100, 'USD');
        return view('pages.pos.pos',$data);
    }

    public function add(Request $request)
    {
        dd($request->all());
        return CategoryService::save($request);
    }
}
