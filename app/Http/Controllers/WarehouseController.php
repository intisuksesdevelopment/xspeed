<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\WarehouseService;
use Illuminate\Pagination\Paginator;

class WarehouseController extends Controller
{
    private $warehouseService;

    public function __construct(WarehouseService $warehouseService) {
        $this->warehouseService = $warehouseService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $warehouses = WarehouseService::getPaginated($request);
        return view('pages.warehouse.warehouse', ['warehouses' => $warehouses]);
    }

    public function add(Request $request)
    {
        return WarehouseService::save($request);
    }

    public function update(Request $request)
    {
        return WarehouseService::update($request);
    }
    
    public function delete($id)
    {
        return WarehouseService::delete($id);
    }
}
