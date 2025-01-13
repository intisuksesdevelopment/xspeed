<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ItemService;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    public function index(Request $request)
    {
       dd(ItemService::getDetailItem('729bd9f5-eae3-4aa8-b507-01be2864d6b4')->get());

        return view('signin');
    }
}
