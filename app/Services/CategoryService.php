<?php
namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\NotFoundException;

class CategoryService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $categories = Category::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($categories as $category) {
            $category->availability = $category->isAvailable();
        }
        return $categories;
    }
    public static function getDetail($code)
    {
        $category = Category::where('status', $code)->first();

        if (! $category) {
            throw new NotFoundException("code : {$category->code}");
        }
        $category->status = $category->isAvailable();
        return $category;
    }
    public static function save(Request $request)
    {
        $data     = $request->all();
        $category = Category::where('code', 'ILIKE', '%' . $category->name . '%')->get();
        if ($category) {
            throw new AlreadyExistException("code : {$category->code}");
        }
        $category = new Category();
        $category->validateAttributes($category);
        $category->fill($data);
        $category->save();

        return response()->json(['success' => true, 'message' => 'Add successfully!',
    ]);
    }
    public static function update(Request $request)
    {
        $data           = $request->all();
        $data['status'] = $request->has('status') ? $request->input('status') : 0;

        $category = Category::find($data['id']);
        if (! $category) {
            throw new NotFoundException("code : " . $data['code']);
        }
        $category->validateAttributes($data);
        $category->fill($data);
        $category->update();

        return response()->json(['success' => true, 'message' => 'Update successfully!',
    ]);
    }
    public static function delete(Request $request)
    {
        $data     = $request->all();
        $category = Category::find($data['id']);
        if (! $category) {
            throw new NotFoundException("code : " . $data['code']);
        }
        $category->status = 0;
        $category->update();

        return response()->json(['success' => true, 'message' => 'Remove successfully!',
        ]);
    }
}
