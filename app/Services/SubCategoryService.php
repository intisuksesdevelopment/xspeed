<?php
namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\NotFoundException;

class SubCategoryService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $subcategories = SubCategory::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($subcategories as $subcategory) {
            $subcategory->availability = $subcategory->isAvailable();
        }
        return $subcategories;
    }
    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $subcategories = SubCategory::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($subcategories as $subcategory) {
            $subcategory->availability = $subcategory->isAvailable();
        }
        return $subcategories;
    }
    public static function getDetail($code)
    {
        try {
            $subcategory = SubCategory::where('code', $code)->first();

            if (! $subcategory) {
                throw new NotFoundException("code : {$code}");
            }
            $subcategory->status = $subcategory->isAvailable();
            return $subcategory;
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'SubCategory not found: ' . $e->getMessage(),
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
            $subcategory       = SubCategory::whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($data['code']) . '%'])->get();

            if ($subcategory->isNotEmpty()) {
                $firstSubCategory = $subcategory->first();
                throw new AlreadyExistException("code : {$firstSubCategory->code}");
            }

            $subcategory = new SubCategory();
            $subcategory->validateAttributes($data);
            $subcategory->fill($data);
            $subcategory->save();

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    public static function update(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? 0 : 1;

            $subcategory = SubCategory::find($data['id']);
            if (! $subcategory) {
                throw new NotFoundException("code : " . $data['code']);
            }
            $subcategory->validateAttributes($data);
            $subcategory->fill($data);
            $subcategory->update();

            return response()->json([
                'success' => true,
                'message' => 'Update successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'SubCategory not found: ' . $e->getMessage(),
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
            $subcategory = SubCategory::find($id);
            if (! $subcategory) {
                throw new NotFoundException("id : " . $id);
            }
            $subcategory->status = 1;
            $subcategory->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'SubCategory not found: ' . $e->getMessage(),
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
