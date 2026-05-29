<?php

namespace App\Http\Controllers;

use App\Services\SubRackService;
use App\Services\RackService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class SubRackController extends Controller
{
    private $subRackService;

    public function __construct(SubRackService $subRackService)
    {
        $this->subRackService = $subRackService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap();
        $data['subracks'] = SubRackService::getPaginated($request);
        $data['racks'] = RackService::getActive($request);

        return view('pages.rack.sub-racks', $data);
    }

    public function add(Request $request)
    {
        return SubRackService::save($request);
    }

    public function update(Request $request)
    {
        return SubRackService::update($request);
    }

    public function delete($id)
    {
        return SubRackService::delete($id);
    }
}