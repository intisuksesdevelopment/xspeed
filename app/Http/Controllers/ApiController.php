<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getProducts(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getActive()
        ]);
    }
    public function getProductsPaginated(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getPaginated($request)
        ]);
    }
    public function getProductDetail($uuid)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getDetail($uuid)
        ]);
    }
        public function getProductSearch(Request $request)
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        return response()->json([
            'success' => true,
            'data' => ItemService::getSearch($query, $limit)
        ]);
    }

        public function getBrands(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => BrandService::getActive($request)
        ]);
    }

        public function getCategories(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => CategoryService::getActive($request)
        ]);
    }
}
