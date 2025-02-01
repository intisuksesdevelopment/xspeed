<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\RackService;
use Illuminate\Pagination\Paginator;

class RackController extends Controller
{
    private $rackService;

    public function __construct(RackService $rackService) {
        $this->rackService = $rackService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $racks = RackService::getPaginated($request);
        return view('pages.rack.racks', ['racks' => $racks]);
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
