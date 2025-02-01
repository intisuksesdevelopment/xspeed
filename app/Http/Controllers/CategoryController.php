<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $categories = CategoryService::getPaginated($request);
        return view('pages.categories.category-list', ['categories' => $categories]);
    }
    public function add(Request $request)
    {
        return CategoryService::save($request);
    }
    public function update(Request $request)
    {
        return CategoryService::update($request);
    }
    public function delete($id)
    {
        return CategoryService::delete($id);
    }

}
