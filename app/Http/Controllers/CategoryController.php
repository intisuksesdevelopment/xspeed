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

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $categories = CategoryService::getPaginatedCategories($request);

        return view('pages.categories.category-list', ['categories' => $categories]);
    }
    public function detail($uuid)
    {
        $item = CategoryService::getDetailCategory($uuid);
        return view('pages.categories.category-details', ['category' => $item->getWithoutId(true)]);
    }
}
