<?php
namespace App\Services;

use App\Models\Rack;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;

class RackService
{

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $racks = Rack::orderBy($sortBy, $sortDirection)->paginate($perPage);
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
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
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
            $data           = $request->all();
            $data['status'] = $request->has('status') ? $request->input('status') : 0;
            $rack       = Rack::whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($data['code']) . '%'])->get();

            if ($rack->isNotEmpty()) {
                $firstRack = $rack->first();
                throw new AlreadyExistException("code : {$firstRack->code}");
            }

            $rack = new Rack();
            // $supplier->validateAttributes($data);
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
            $data           = $request->all();
            $data['status'] = $request->has('status') ? $request->input('status') : 0;

            $rack = Rack::find($data['id']);
            if (! $rack) {
                throw new NotFoundException("code : " . $data['code']);
            }
            // $category->validateAttributes($data);
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
            $rack = Rack::find($id);
            if (! $rack) {
                throw new NotFoundException("id : " . $id);
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
                'message' => 'rack not found: ' . $e->getMessage(),
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
