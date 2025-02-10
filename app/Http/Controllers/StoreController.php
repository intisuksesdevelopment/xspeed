<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\StoreService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    protected $storeService;

    public function __construct(StoreService $storeService) {
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
