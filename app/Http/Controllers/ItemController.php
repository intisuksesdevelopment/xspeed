<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\RackService;
use App\Services\UnitService;
use App\Services\BrandService;
use App\Services\ExcelService;
use App\Services\CategoryService;
use App\Services\WarehouseService;
use App\Services\SubCategoryService;
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
        $data['categories']    = CategoryService::getActive($request);
        $data['subcategories'] = SubCategoryService::getActive($request);
        $data['warehouses']    = WarehouseService::getActive($request);
        $data['racks']         = RackService::getActive($request);
        $data['brands']        = BrandService::getActive($request);
        return view('pages.products.product-list',$data);
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
    public function barcode(Request $request)
    {
        $data['categories']    = CategoryService::getActive($request);
        $data['subcategories'] = SubCategoryService::getActive($request);
        $data['warehouses']    = WarehouseService::getActive($request);
        $data['racks']         = RackService::getActive($request);
        $data['brands']        = BrandService::getActive($request);
        $data['units']         = UnitService::getActive($request);
        return view('pages.products.product-barcode', $data);
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
    public function getItemsByCategory($category_id)
    {
        return ItemService::getItemsByCategory($category_id);
    }
    public function upload(Request $request)
    {   
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');

        try {
            ExcelService::import($file, null);
            return response()->json(['message' => 'File berhasil diimpor'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getData(Request $request){
        return ItemService::getData($request);
    }


}
