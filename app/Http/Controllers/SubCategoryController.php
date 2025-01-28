<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\SubCategoryService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{

    public function __construct(SubCategoryService $subCategoryService) {
        $this->subCategoryService = $subCategoryService;
    }
    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $data['subcategories'] = SubCategoryService::getPaginated($request);
        $data['categories'] = CategoryService::getActive($request);
        return view('pages.categories.sub-categories',  $data);
    }
    public function add(Request $request)
    {
        return SubCategoryService::save($request);
    }
    public function update(Request $request)
    {
        return SubCategoryService::update($request);
    }
    public function delete($id)
    {
        return SubCategoryService::delete($id);
    }

}
