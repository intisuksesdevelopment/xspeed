<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\UtilService;
use App\Services\BrandService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->merge(['per_page' => 8]);
        $request->merge(['sortBy' => 'created_at']);
        $data['products'] = ItemService::getPaginated($request);
        $request->merge(['per_page' => 4]);
        $data['brands'] = BrandService::getPaginated($request);
        return view('pages.dashboard.main-layout', ['data' => $data]);
    }
    public function getDetail(Request $request)
    {
        $data['product'] = ItemService::getDetail($request->uuid);
        $request->merge(['per_page' => 4]);
        $data['products'] = ItemService::getPaginated($request);
        return view('pages.dashboard.main-layout', ['data' => $data]);
    }
    //
}
