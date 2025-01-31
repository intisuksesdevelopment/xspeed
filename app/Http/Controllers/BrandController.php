<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BrandService;
use Illuminate\Pagination\Paginator;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $brandService) {
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $brands = BrandService::getPaginated($request);
        return view('pages.brand.brands', ['brands' => $brands]);
    }

    public function add(Request $request)
    {
        return BrandService::save($request);
    }

    public function update(Request $request)
    {
        return BrandService::update($request);
    }
    
    public function delete($id)
    {
        return BrandService::delete($id);
    }
}
