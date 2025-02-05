<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;

class SalesController extends Controller
{
    private $salesService;

    public function __construct(SalesService $salesService) {
        $this->salesService = $salesService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $data['sales'] = SalesService::getPaginated($request);
        $data['items'] = ItemService::getActive($request);
        return view('pages.sales.sales-list', $data);
    }
}
