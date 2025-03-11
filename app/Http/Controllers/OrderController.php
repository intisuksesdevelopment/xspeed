<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $brands = OrderService::getPaginated($request);
        return view('pages.order.orders', ['orders' => $brands]);
    }
}
