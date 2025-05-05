<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\UtilService;
use App\Services\BrandService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->merge(['per_page' => 8]);
        $request->merge(['sortBy' => 'created_at']);
        $data['products'] = ItemService::getActive($request);
        $request->merge(['per_page' => 8]);
        $data['categories'] = CategoryService::getActive($request);
        $data['brands'] = BrandService::getActive($request);
        return view('pages.dashboard.main-layout', ['data' => $data]);
    }
    public function getDetail(Request $request)
    {
        $data['product'] = ItemService::getDetail($request->uuid);
        $request->merge(['per_page' => 4]);
        $data['products'] = ItemService::getPaginated($request);
        $data['brands'] = BrandService::getActive($request);

        return view('pages.dashboard.main-layout', ['data' => $data]);
    }
    public function getList(Request $request)
    {
        
        $data['category'] = json_decode(CategoryService::getDetail($request->categoryCode));
        if($data['category']==null) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }
        $data['products'] = ItemService::getItemsByCategory( $data['category']->id)->getData();
        $data['brands'] = BrandService::getActive($request);

        return view('pages.dashboard.main-layout', ['data' => $data]);
    }
    //
}
