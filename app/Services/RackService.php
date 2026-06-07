<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Rack;
use Illuminate\Http\Request;
use App\Exceptions\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;

class RackService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided

        $query = Rack::query()->where('status', 0);

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

        $racks = $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($racks as $rack) {
            $rack->availability = $rack->isAvailable();
        }

        return $racks;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided
        $racks = Rack::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($racks as $rack) {
            $rack->availability = $rack->isAvailable();
        }

        return $racks;
    }

    public static function save(Request $request)
    {
        try {
            $data = $request->except(['image_url']);
            // Use checkbox value: checked = 0 (active), unchecked via hidden input = 1 (inactive)
            $data['status'] = $request->input('status', 1);

            // Handle image upload - save to public/racks folder
            if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');
                $filename = 'rack_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Ensure racks directory exists
                $racksDir = public_path('racks');
                if (!file_exists($racksDir)) {
                    mkdir($racksDir, 0755, true);
                }

                $file->move($racksDir, $filename);
                $data['image_url'] = '/racks/' . $filename;
            }

            // Check for duplicate code among active records only
            $rack = Rack::whereRaw('LOWER(code) = ?', [strtolower($data['code'])])
                ->where('status', 0)
                ->first();

            if ($rack) {
                throw new AlreadyExistException("code : {$rack->code}");
            }

            $rack = new Rack;
            $rack->fill($data);
            $rack->save();

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
            $data = $request->except(['image_url']);
            // Use checkbox value: checked = 0 (active), unchecked via hidden input = 1 (inactive)
            $data['status'] = $request->input('status', 1);

            $rack = Rack::find($data['id']);
            if (! $rack) {
                throw new NotFoundException('code : '.$data['code']);
            }

            // Handle image upload - save to public/racks folder
            if ($request->hasFile('image_url')) {
                // Delete old image if exists
                $oldImagePath = public_path($rack->image_url);
                if ($rack->image_url && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $file = $request->file('image_url');
                $filename = 'rack_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Ensure racks directory exists
                $racksDir = public_path('racks');
                if (!file_exists($racksDir)) {
                    mkdir($racksDir, 0755, true);
                }

                $file->move($racksDir, $filename);
                $data['image_url'] = '/racks/' . $filename;
            }

            $rack->fill($data);
            $rack->update();

            return response()->json([
                'success' => true,
                'message' => 'Update successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Rack not found: '.$e->getMessage(),
            ], 404);
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
            $rack = Rack::find($id);
            if (! $rack) {
                throw new NotFoundException('id : '.$id);
            }
            $rack->status = 1;
            $rack->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'rack not found: '.$e->getMessage(),
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
