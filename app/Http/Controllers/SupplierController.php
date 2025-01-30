<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SupplierService;
use Illuminate\Pagination\Paginator;

class SupplierController extends Controller
{
    private $supplierService;

    public function __construct(SupplierService $supplierService) {
        $this->supplierService = $supplierService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $suppliers = SupplierService::getPaginated($request);
        return view('pages.supplier.suppliers', ['suppliers' => $suppliers]);
    }

    public function add(Request $request)
    {
        return SupplierService::save($request);
    }

    public function update(Request $request)
    {
        return SupplierService::update($request);
    }
    
    public function delete($id)
    {
        return SupplierService::delete($id);
    }
}
