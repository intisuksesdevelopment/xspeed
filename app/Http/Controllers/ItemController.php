<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use App\Services\BrandService;
use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\CategoryService;
use App\Services\RackService;
use App\Services\WarehouseService;
use App\Services\SubCategoryService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService) {
        $this->itemService = $itemService;
    }
    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $items = ItemService::getPaginated($request);
        $items = $this->itemService->getPaginated($request);
         // Apply the method to each item in the collection
         $itemsWithoutId = $items->map(function ($item) {
             return $item->getWithoutId(true);
            });
        // dd($itemsWithoutId);
        return view('pages.products.product-list', ['items' => $itemsWithoutId]);
    }
    public function add(Request $request)
    {
        $data['categories'] = CategoryService::getActive($request);
        $data['subcategories'] = SubCategoryService::getActive($request);
        $data['warehouses'] = WarehouseService::getActive($request);
        $data['racks'] = RackService::getActive($request);
        $data['brands'] = BrandService::getActive($request);
        return view('pages.products.product-add', $data);
    }
    public function detail($uuid)
    {
        $item = $this->itemService->getDetail($uuid);
        return view('pages.products.product-details', ['item' => $item->getWithoutId(true)]);
    }
}
