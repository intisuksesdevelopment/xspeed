<?php

namespace App\Http\Controllers;

use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class StoreController extends Controller
{
    protected $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $stores = StoreService::getPaginated($request);

        return view('pages.store.stores', ['stores' => $stores]);
    }

    public function add(Request $request)
    {
        return StoreService::save($request);
    }

    public function update(Request $request)
    {
        return StoreService::update($request);
    }

    public function delete($id)
    {
        return StoreService::delete($id);
    }
}
