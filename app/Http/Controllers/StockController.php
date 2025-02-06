<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    private $salesService;

    public function __construct(SalesService $salesService) {
        $this->salesService = $salesService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $data['stocks'] = StockService::getPaginated($request);
        return view('pages.stocks.stock-list', $data);
    }
    public function addForm(Request $request)
    {
        $data['categories']    = CategoryService::getActive($request);
        $data['subcategories'] = SubCategoryService::getActive($request);
        $data['warehouses']    = WarehouseService::getActive($request);
        $data['racks']         = RackService::getActive($request);
        $data['brands']        = BrandService::getActive($request);
        $data['units']         = UnitService::getActive($request);
        return view('pages.products.product-add', $data);
    }
    public function add(Request $request)
    {
        return SalesService::save($request);
    }
}
