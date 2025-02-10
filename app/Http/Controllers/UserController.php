<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $users = UserService::getPaginated($request);
        return view('pages.user.users', ['users' => $users]);
    }

    public function add(Request $request)
    {
        $request->merge(['uuid' => Str::uuid()]);
        
        return UserService::save($request);
    }

    public function update(Request $request)
    {
        return UserService::update($request);
    }

    public function delete($id)
    {
        return UserService::delete($id);
    }
}
