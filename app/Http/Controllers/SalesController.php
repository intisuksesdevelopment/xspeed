<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\SalesService;
use Illuminate\Pagination\Paginator;

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
