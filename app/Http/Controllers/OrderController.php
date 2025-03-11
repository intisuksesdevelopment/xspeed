<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RackService;
use App\Services\UnitService;
use App\Services\BrandService;
use App\Services\OrderService;
use App\Services\CategoryService;
use App\Services\WarehouseService;
use App\Services\SubCategoryService;
use Illuminate\Pagination\Paginator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $brands = OrderService::getPaginated($request);
        return view('pages.orders.order-list', ['orders' => $brands]);
    }

    public function addForm(Request $request)
    {
        $data['categories']    = CategoryService::getActive($request);
        $data['subcategories'] = SubCategoryService::getActive($request);
        $data['warehouses']    = WarehouseService::getActive($request);
        $data['racks']         = RackService::getActive($request);
        $data['brands']        = BrandService::getActive($request);
        $data['units']         = UnitService::getActive($request);
        return view('pages.orders.order-add', $data);
    }
}
