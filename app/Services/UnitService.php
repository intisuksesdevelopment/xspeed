<?php
namespace App\Services;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\AlreadyExistException;

class UnitService
{

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $units = Unit::orderBy($sortBy, $sortDirection)->paginate($perPage);
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
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
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
            $data           = $request->all();
            $data['status'] = $request->has('status') ? 0 : 1;
            $unit           = Unit::whereRaw('LOWER(unit) = ?', [strtolower($data['unit'])])->first();  

            if ($unit) {  
                throw new AlreadyExistException("unit : {$unit->unit}");
            } else {  
                $unit = new Unit();
                // $supplier->validateAttributes($data);
                $unit->fill($data);
                $unit->save();
    
                return response()->json(['success' => true, 'message' => 'Add successfully!']);
            }  
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
            $data['status'] = $request->has('status') ? $request->input('status') : 0;

            $unit = Unit::find($data['id']);
            if (! $unit) {
                throw new NotFoundException("code : " . $data['code']);
            }
            // $category->validateAttributes($data);
            $unit->fill($data);
            $unit->update();

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
            $unit = Unit::find($id);
            if (! $unit) {
                throw new NotFoundException("id : " . $id);
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
                'message' => 'Unit not found: ' . $e->getMessage(),
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
