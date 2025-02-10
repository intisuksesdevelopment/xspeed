<?php
namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\NotFoundException;

class StoreService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $stores = Store::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($stores as $store) {
            $store->availability = $store->isAvailable();
        }
        return $stores;
    }
    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $stores = Store::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($stores as $store) {
            $store->availability = $store->isAvailable();
        }
        return $stores;
    }
   

    public static function save(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? 0 : 1;
            $store       = Store::whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($data['code']) . '%'])->get();

            if ($store->isNotEmpty()) {
                $firstSubStore = $store->first();
                throw new AlreadyExistException("code : {$firstSubStore->code}");
            }

            $store = new SubCategory();
            // $store->validateAttributes($data);
            $store->fill($data);
            $store->save();

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

            $store = Store::find($data['id']);
            if (! $store) {
                throw new NotFoundException("code : " . $data['code']);
            }
            // $store->validateAttributes($data);
            $store->fill($data);
            $store->update();

            return response()->json([
                'success' => true,
                'message' => 'Update successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Store not found: ' . $e->getMessage(),
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
            $store = Store::find($id);
            if (! $store) {
                throw new NotFoundException("id : " . $id);
            }
            $store->status = 1;
            $store->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Store not found: ' . $e->getMessage(),
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
