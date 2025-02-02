<?php
namespace App\Http\Controllers;

use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ItemService;
use App\Services\RackService;
use App\Services\SubCategoryService;
use App\Services\UnitService;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }
    public function index(Request $request)
    {
        Paginator::useBootstrap();
        $items          = ItemService::getPaginated($request);
        $items          = $this->itemService->getPaginated($request);
        $itemsWithoutId = $items->map(function ($item) {
            return $item->getWithoutId(true);
        });
        // dd($itemsWithoutId);
        return view('pages.products.product-list', ['items' => $itemsWithoutId]);
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
    public function editForm(Request $request)
    {
        $data['item']          = ItemService::getDetail($request->uuid);
        $data['categories']    = CategoryService::getActive($request);
        $data['subcategories'] = SubCategoryService::getActive($request);
        $data['warehouses']    = WarehouseService::getActive($request);
        $data['racks']         = RackService::getActive($request);
        $data['brands']        = BrandService::getActive($request);
        $data['units']         = UnitService::getActive($request);
        return view('pages.products.product-edit', $data);
    }

    public function add(Request $request)
    {
        return ItemService::save($request);
    }
    public function edit(Request $request)
    {
        return ItemService::edit($request);
    }
    public function delete($uuid)
    {
        return ItemService::delete($uuid);
    }
    public function detail($uuid)
    {
        $item = ItemService::getDetail($uuid);
        return view('pages.products.product-details', ['item' => $item->getWithoutId(true)]);
    }
}
