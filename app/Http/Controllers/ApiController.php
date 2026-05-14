<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ContactService;
use App\Services\ItemService;
use App\Services\OrderService;
use App\Services\SubCategoryService;
use App\Services\SupplierService;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getProducts(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getActive(),
        ]);
    }

    public function getProductsPaginated(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getPaginatedList($request),
        ]);
    }

    public function getProductDetail($uuid)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getDetail($uuid),
        ]);
    }

    public function getProductSearch(Request $request)
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        return response()->json([
            'success' => true,
            'data' => ItemService::getSearch($query, $limit),
        ]);
    }

    public function getBrands(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => BrandService::getActive($request),
        ]);
    }

    public function getCategories(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => CategoryService::getActive($request),
        ]);
    }

    public function getSubcategories(Request $request, $categoryId)
    {
        return response()->json([
            'success' => true,
            'data' => SubCategoryService::getByCategoryId($request, $categoryId),
        ]);
    }

    public function getSuppliers(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => SupplierService::getActive($request),
        ]);
    }

    public function getWarehouses(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => WarehouseService::getActive($request),
        ]);
    }

    public function getContacts(Request $request, $uuid)
    {
        return response()->json([
            'success' => true,
            'data' => ContactService::get($request, $uuid),
        ]);
    }

    public function getContactBySupplier(Request $request, $supplierUuid)
    {
        return response()->json([
            'success' => true,
            'data' => ContactService::get($request, $supplierUuid),
        ]);
    }

    public function addOrder(Request $request)
    {

        $request->merge([
            'items' => json_decode($request->items, true),
        ]);

        $validated = $request->validate([
            'transactionId' => 'required|string',
            'supplierUuid' => 'required|uuid',

            'warehouseId' => 'required|integer',

            'taxPercent' => 'nullable|numeric',
            'discPercent' => 'nullable|numeric',

            'items' => 'required|array',
            'items.*.uuid' => 'required|uuid',
            'items.*.qty' => 'required|integer|min:1',
        ]);
        try {
            $order = OrderService::createOrder($request);

            return redirect()
                ->route('order')
                ->with('success', 'Order berhasil dibuat');
        } catch (\Throwable $e) {

            return back()->with('error', $e->getMessage());
        }
    }
}
