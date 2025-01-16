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

    public function __construct(ItemService $itemService) {
        $this->itemService = $itemService;
    }
    public function index(Request $request)
    {
        $items = ItemService::getPaginatedItems($request);
        $items = $this->itemService->getPaginatedItems($request);
         // Apply the method to each item in the collection
         $itemsWithoutId = $items->map(function ($item) {
             return $item->getWithoutId(true);
            });
        return view('product-list', ['items' => $itemsWithoutId]);    }
}
