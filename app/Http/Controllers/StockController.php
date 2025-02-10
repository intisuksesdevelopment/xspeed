<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\RackService;
use App\Services\UnitService;
use App\Services\BrandService;
use App\Services\StockService;
use App\Services\CategoryService;
use App\Services\WarehouseService;
use App\Services\SubCategoryService;
use Illuminate\Pagination\Paginator;

class StockController extends Controller
{
    private $stockService;

    public function __construct(StockService $stockService) {
        $this->stockService = $stockService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $data['stocks'] = StockService::getPaginated($request);
        return view('pages.stocks.stock-list', $data);
    }
    public function addForm(Request $request)
    {
        $data['items']    = ItemService::getActive($request);
        $data['categories']    = CategoryService::getActive($request);
        $data['subcategories']    = SubCategoryService::getActive($request);
        $data['brands']    = BrandService::getActive($request);
        $data['racks']    = RackService::getActive($request);
        $data['warehouses']    = WarehouseService::getActive($request);
        return view('pages.stocks.stock-add', $data);
    }
    public function add(Request $request)
    {
        return StockService::save($request);
    }
}
