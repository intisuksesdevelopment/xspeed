<?php

namespace App\Http\Controllers;

use App\Services\BankService;
use App\Services\ConfigService;
use App\Services\ItemService;
use App\Services\PaymentService;
use App\Services\SalesService;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class SalesController extends Controller
{
    private $salesService;

    public function __construct(SalesService $salesService)
    {
        $this->salesService = $salesService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $data['sales'] = SalesService::getPaginated($request);
        $data['items'] = ItemService::getActive($request);

        return view('pages.sales.sales-list', $data);
    }

    public function addForm(Request $request)
    {
        $data['config'] = ConfigService::getActive($request);
        $data['paymentMethods'] = PaymentService::getActive($request);
        $data['banks'] = BankService::getActive($request);

        return view('pages.sales.sales-add', $data);
    }

    public function invoices(Request $request)
    {

        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $data['sales'] = SalesService::getInvoices($request, 'sales');

        return view('pages.sales.sales-invoices', $data);
    }

    public function add(Request $request)
    {
        return SalesService::save($request);
    }

    public function detail(Request $request)
    {
        return SalesService::detail($request);
    }
}
