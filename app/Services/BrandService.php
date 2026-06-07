<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Exceptions\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BrandService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDirection', 'desc');

        $query = Brand::query()->where('status', 0);

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

        $brands = $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($brands as $brand) {
            $brand->availability = $brand->isAvailable();
        }

        return $brands;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);

        $brands = Brand::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($brands as $brand) {
            $brand->availability = $brand->isAvailable();
        }

        return $brands;
    }

    public static function save(Request $request)
    {
        try {
            // Validate required fields
            if (empty($request->input('code'))) {
                return response()->json(['success' => false, 'message' => 'Brand code is required']);
            }
            if (empty($request->input('name'))) {
                return response()->json(['success' => false, 'message' => 'Brand name is required']);
            }

            $data = $request->except(['image_url']);
            $data['status'] = $request->has('status') ? 0 : 1;

            // Handle image upload - save to public/brands folder
            if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');
                $filename = 'brand_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Ensure brands directory exists
                $brandsDir = public_path('brands');
                if (!file_exists($brandsDir)) {
                    mkdir($brandsDir, 0755, true);
                }

                $file->move($brandsDir, $filename);
                $data['image_url'] = '/brands/' . $filename;
            }

            $brand = Brand::whereRaw('LOWER(code) = ?', [strtolower($data['code'])])->where('status', 0)->first();

            if ($brand) {
                throw new AlreadyExistException("code : {$brand->code}");
            }

            $brand = new Brand;
            $brand->fill($data);
            $brand->save();

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later. ' . $e->getMessage()]);
        }
    }

    public static function update(Request $request)
    {
        try {
            $data = $request->except(['image_url']);
            $data['status'] = $request->has('status') ? $request->input('status') : 0;

            $brand = Brand::find($data['id']);
            if (!$brand) {
                throw new NotFoundHttpException('code : ' . $data['code']);
            }

            // Handle image upload - save to public/brands folder
            if ($request->hasFile('image_url')) {
                // Delete old image if exists
                $oldImagePath = public_path($brand->image_url);
                if ($brand->image_url && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $file = $request->file('image_url');
                $filename = 'brand_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('brands'), $filename);
                $data['image_url'] = '/brands/' . $filename;
            }

            $brand->fill($data);
            $brand->update();

            return response()->json([
                'success' => true,
                'message' => 'Update successfully!',
            ]);
        } catch (NotFoundHttpException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Brand not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }

    public static function delete($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                throw new NotFoundHttpException('id : ' . $id);
            }

            // Delete image if exists
            $oldImagePath = public_path($brand->image_url);
            if ($brand->image_url && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $brand->status = 1;
            $brand->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundHttpException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Brand not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }

    public static function getIdByCode($code)
    {
        $brand = Brand::where('code', $code)->first();

        if (!$brand) {
            throw new NotFoundHttpException('Brand not found with code: ' . $code);
        }

        return $brand->id;
    }
}
