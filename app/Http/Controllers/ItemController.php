<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ItemService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    public function __construct(ItemService $itemService) {
        $this->itemService = $itemService;
    }
    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $items = ItemService::getPaginatedItems($request);
        $items = $this->itemService->getPaginatedItems($request);
         // Apply the method to each item in the collection
         $itemsWithoutId = $items->map(function ($item) {
             return $item->getWithoutId(true);
            });
        // dd($itemsWithoutId);
        return view('pages.products.product-list', ['items' => $itemsWithoutId]);
    }
    public function detail($uuid)
    {
        $item = ItemService::getDetailItem($uuid);
        return view('pages.products.product-details', ['item' => $item->getWithoutId(true)]);
    }
}
