<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use Illuminate\Pagination\Paginator;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $customers = CustomerService::getPaginated($request);
        return view('pages.customer.customers', ['customers' => $customers]);
    }

    public function add(Request $request)
    {
        return CustomerService::save($request);
    }

    public function update(Request $request)
    {
        return CustomerService::update($request);
    }
    
    public function delete($id)
    {
        return CustomerService::delete($id);
    }
}
