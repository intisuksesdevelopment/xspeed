<?php
namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;
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
    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $categories = Category::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($categories as $category) {
            $category->availability = $category->isAvailable();
            $category->countItems = $category->countItems();
        }
        return $categories;
    }
    public static function getDetail($code)
    {
        try {
            $category = Category::where('code', $code)->first();

            if (! $category) {
                throw new NotFoundException("code : {$code}");
            }
            $category->status = $category->isAvailable();
            return $category;
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Category not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public static function save(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? 0 : 1;
            $category       = Category::whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($data['code']) . '%'])->get();

            if ($category->isNotEmpty()) {
                $firstCategory = $category->first();
                throw new AlreadyExistException("code : {$firstCategory->code}");
            }

            $category = new Category();
            $category->validateAttributes($data);
            $category->fill($data);
            $category->save();

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    public static function update(Request $request,String $id)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? 0 : 1;

            $category = Category::find($id);
            if (! $category) {
                throw new NotFoundException("code : " . $data['code']);
            }
            $category->validateAttributes($data);
            $category->fill($data);
            $category->update();

            return response()->json([
                'success' => true,
                'message' => 'Update successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Category not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public static function delete($id)
    {
        try {
            $category = Category::find($id);
            if (! $category) {
                throw new NotFoundException("id : " . $id);
            }
            $category->status = 1;
            $category->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Category not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

}
