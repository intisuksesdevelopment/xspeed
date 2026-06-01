<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ItemService;
use App\Services\RackService;
use App\Services\StockService;
use App\Services\SubCategoryService;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class StockController extends Controller
{
    private $stockService;

    public function __construct(StockService $stockService)
    {
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
        return view('pages.stocks.stock-add');
    }

    public function add(Request $request)
    {
        return StockService::save($request);
    }

    public function delete($id)
    {
        return StockService::delete($id);
    }

    public function editForm($id)
    {
        $stock = \App\Models\Stock::with(['stockData.item'])->where('uuid', $id)->firstOrFail();

        // Transform stockData to include product info
        $stockProducts = [];
        foreach ($stock->stockData as $data) {
            $item = $data->item;
            $stockProducts[] = [
                'uuid' => $item ? $item->uuid : '',
                'name' => $item ? $item->name : '',
                'sku' => $item ? $item->sku : '',
                'stock' => $data->item_stock,
                'count' => $data->qty,
                'basic_price' => $data->item_price,
                'image_url' => $item && $item->images && $item->images->first() ? asset('uploads/' . $item->images->first()->url) : asset('assets/img/product/noimg.png'),
                'rack' => $data->rack
            ];
        }

        $data['stock'] = $stock;
        $data['stockProducts'] = $stockProducts;

        return view('pages.stocks.stock-edit', $data);
    }

    public function update(Request $request, $id)
    {
        return StockService::updateStock($request, $id);
    }

    // API Methods for dropdowns
    public function getWarehouses(Request $request)
    {
        return response()->json(WarehouseService::getActive($request));
    }

    public function getCategories(Request $request)
    {
        return response()->json(CategoryService::getActive($request));
    }

    public function getSubcategories(Request $request)
    {
        return response()->json(SubCategoryService::getActive($request));
    }

    public function getBrands(Request $request)
    {
        return response()->json(BrandService::getActive($request));
    }

    public function getItems(Request $request)
    {
        // Support Select2 AJAX format with search and filters
        if ($request->ajax() || $request->wantsJson() || $request->has('search') || $request->has('page')) {
            return ItemService::getForSelect($request);
        }
        return response()->json(ItemService::getActive($request));
    }

    public function getRacks(Request $request)
    {
        return response()->json(RackService::getActive($request));
    }
    public function getSubracks(Request $request)
    {
        return response()->json(RackService::getSubRacks($request));
    }
}
