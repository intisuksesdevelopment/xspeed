<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UnitService;
use Illuminate\Pagination\Paginator;

class UnitController extends Controller
{
    private $unitService;

    public function __construct(UnitService $unitService) {
        $this->unitService = $unitService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $units = UnitService::getPaginated($request);
        return view('pages.unit.units', ['units' => $units]);
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
