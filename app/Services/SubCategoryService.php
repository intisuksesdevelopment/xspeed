<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Exceptions\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;
use Illuminate\Validation\ValidationException;

class SubCategoryService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDirection', 'desc');

        // Optimized query - select only needed columns
        $query = SubCategory::query()
            ->select('id', 'category_id', 'name', 'code', 'description', 'image_url', 'status', 'created_at')
            ->where('status', 0)
            ->with('category:id,name,code');

        // Search functionality
        $search = $request->input('search', '');
        $searchBy = $request->input('search_by', 'name');

        if ($search) {
            if ($searchBy === 'code') {
                $query->where('code', 'like', '%' . $search . '%');
            } else {
                $query->where('name', 'like', '%' . $search . '%');
            }
        }

        // Filter by category
        $categoryId = $request->input('category_id', '');
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $subcategories = $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
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
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided
        // Optimized query - only load what's needed
        $subcategories = SubCategory::query()
            ->select('id', 'category_id', 'name', 'code', 'status')
            ->where('status', 0)
            ->with('category:id,name,code')
            ->orderBy($sortBy, $sortDirection)
            ->get();

        foreach ($subcategories as $subcategory) {
            $subcategory->availability = $subcategory->isAvailable();
        }

        return $subcategories;
    }
     public static function getByCategoryId(Request $request, $categoryId)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided
        $subcategories = SubCategory::where('category_id', $categoryId)->where('status', 0)->orderBy($sortBy, $sortDirection)->get();
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
                'message' => 'SubCategory not found: '.$e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: '.$e->getMessage(),
            ], 500);
        }
    }

    public static function save(Request $request)
    {
        try {
            $data = $request->except(['image_upload']);
            $data['status'] = 0;

            // Handle image upload
            if ($request->hasFile('image_upload')) {
                $file = $request->file('image_upload');
                $filename = 'subcategory_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $uploadDir = public_path('subcategories');
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $file->move($uploadDir, $filename);
                $data['image_url'] = '/subcategories/' . $filename;
            }

            $subcategory = SubCategory::whereRaw('LOWER(code) LIKE ?', ['%'.strtolower($data['code']).'%'])->get();

            if ($subcategory->isNotEmpty()) {
                $firstSubCategory = $subcategory->first();
                throw new AlreadyExistException("code : {$firstSubCategory->code}");
            }

            $subcategory = new SubCategory;
            $subcategory->validateAttributes($data);
            $subcategory->fill($data);
            $subcategory->save();

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $firstError = collect($errors)->flatten()->first();
            Log::error('Validation error: '.$firstError);

            return response()->json(['success' => false, 'message' => $firstError ?: 'Validation failed']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage() ?: 'An error occurred. Please try again later.']);
        }
    }

    public static function update(Request $request)
    {
        try {
            $data = $request->except(['image_upload']);
            $data['status'] = $data['status'] ?? 0;

            // Handle image upload
            if ($request->hasFile('image_upload')) {
                $file = $request->file('image_upload');
                $filename = 'subcategory_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $uploadDir = public_path('subcategories');
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Delete old image if exists
                $subcategory = SubCategory::find($data['id']);
                if ($subcategory && $subcategory->image_url) {
                    $oldImagePath = public_path($subcategory->image_url);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $file->move($uploadDir, $filename);
                $data['image_url'] = '/subcategories/' . $filename;
            }

            $subcategory = SubCategory::find($data['id']);
            if (! $subcategory) {
                throw new NotFoundException('code : '.$data['code']);
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
                'message' => 'SubCategory not found: '.$e->getMessage(),
            ], 404);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $firstError = collect($errors)->flatten()->first();
            Log::error('Validation error: '.$firstError);

            return response()->json(['success' => false, 'message' => $firstError ?: 'Validation failed']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: '.$e->getMessage(),
            ], 500);
        }
    }

    public static function delete($id)
    {
        try {
            $subcategory = SubCategory::find($id);
            if (! $subcategory) {
                throw new NotFoundException('id : '.$id);
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
                'message' => 'SubCategory not found: '.$e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: '.$e->getMessage(),
            ], 500);
        }
    }
}
