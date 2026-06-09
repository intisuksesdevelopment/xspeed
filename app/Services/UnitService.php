<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Exceptions\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;

class UnitService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided

        $query = Unit::query()->where('status', 0);

        // Search functionality
        $search = $request->input('search', '');
        $searchBy = $request->input('search_by', 'name');

        if ($search) {
            if ($searchBy === 'unit') {
                $query->where('unit', 'like', '%' . $search . '%');
            } else {
                $query->where('name', 'like', '%' . $search . '%');
            }
        }

        $units = $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($units as $unit) {
            $unit->availability = $unit->isAvailable();
        }

        return $units;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided
        $units = Unit::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($units as $unit) {
            $unit->availability = $unit->isAvailable();
        }

        return $units;
    }

    public static function save(Request $request)
    {
        try {
            $data = $request->all();
            $data['status'] = 0;

            // Check for duplicate unit (code) among active records only
            $existingUnit = Unit::whereRaw('LOWER(unit) = ?', [strtolower($data['unit'])])
                ->where('status', 0)
                ->first();

            if ($existingUnit) {
                throw new AlreadyExistException("unit : {$existingUnit->unit}");
            }

            // Check for duplicate name among active records only
            $existingName = Unit::whereRaw('LOWER(name) = ?', [strtolower($data['name'])])
                ->where('status', 0)
                ->first();

            if ($existingName) {
                throw new AlreadyExistException("name : {$existingName->name}");
            }

            $unit = new Unit;
            $unit->fill($data);
            $unit->save();

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
            $data = $request->all();
            $data['status'] = $data['status'] ?? 0;

            $unit = Unit::find($data['id']);
            if (! $unit) {
                throw new NotFoundException('code : '.$data['code']);
            }

            // Check for duplicate unit (code) among other active records
            $existingUnit = Unit::whereRaw('LOWER(unit) = ?', [strtolower($data['unit'])])
                ->where('status', 0)
                ->where('id', '!=', $data['id'])
                ->first();

            if ($existingUnit) {
                throw new AlreadyExistException("unit : {$existingUnit->unit}");
            }

            // Check for duplicate name among other active records
            $existingName = Unit::whereRaw('LOWER(name) = ?', [strtolower($data['name'])])
                ->where('status', 0)
                ->where('id', '!=', $data['id'])
                ->first();

            if ($existingName) {
                throw new AlreadyExistException("name : {$existingName->name}");
            }

            $unit->fill($data);
            $unit->update();

            return response()->json([
                'success' => true,
                'message' => 'Update successfully!',
            ]);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Category not found: '.$e->getMessage(),
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
            $unit = Unit::find($id);
            if (! $unit) {
                throw new NotFoundException('id : '.$id);
            }
            $unit->status = 1;
            $unit->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Unit not found: '.$e->getMessage(),
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
