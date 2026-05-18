<?php

namespace App\Http\Controllers;

use App\Services\BankService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Services\ItemService;
use App\Services\PaymentService;
use App\Services\SalesService;
use App\Services\UtilService;
use App\Services\WarehouseService;
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
        
        // Get recent sales for transaction history (last 20 transactions)
        $recentRequest = new Request([
            'per_page' => 20,
            'sortBy' => 'created_at',
            'sortDirection' => 'desc',
            'page' => 1,
        ]);
        $data['sales'] = SalesService::getPaginated($recentRequest);
        
        $data['customers'] = CustomerService::getActive($request);
        $data['paymentMethods'] = PaymentService::getActive($request);
        $data['banks'] = BankService::getActive($request);
        $data['warehouses'] = WarehouseService::getActive($request);
        UtilService::convertToIdr(100, 'USD');

        return view('pages.pos.pos', $data);
    }

    public function add(Request $request)
    {

        return SalesService::save($request);
    }
}
