<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\UtilService;
use App\Services\SalesService;
use App\Services\CategoryService;
use App\Services\CustomerService;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $request = new Request([
            'per_page' => 10,
            'sortBy' => 'name',
            'sortDirection' => 'asc',
            'page' => 1
        ]);
        $data['items'] = ItemService::getActive($request);
        $data['categories'] = CategoryService::getActive($request);
        $data['sales'] = SalesService::getActive($request);
        $data['customers']    = CustomerService::getActive($request);

        return view('pages.pos.pos',$data);
    }

    public function add(Request $request)
    {
        return CategoryService::save($request);
    }
}
