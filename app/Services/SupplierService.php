<?php
namespace App\Services;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;

class SupplierService
{

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $suppliers = Supplier::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($suppliers as $supplier) {
            $supplier->availability = $supplier->isAvailable();
        }
        return $suppliers;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $suppliers = Supplier::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($suppliers as $supplier) {
            $supplier->availability = $supplier->isAvailable();
        }
        return $suppliers;
    }

    public static function save(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? $request->input('status') : 0;
            $supplier       = Supplier::whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($data['code']) . '%'])->get();

            if ($supplier->isNotEmpty()) {
                $firstSupplier = $supplier->first();
                throw new AlreadyExistException("code : {$firstSupplier->code}");
            }

            $supplier = new Supplier();
            // $supplier->validateAttributes($data);
            $supplier->fill($data);
            $supplier->save();

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

            $supplier = Supplier::find($data['id']);
            if (! $supplier) {
                throw new NotFoundException("code : " . $data['code']);
            }
            // $category->validateAttributes($data);
            $supplier->fill($data);
            $supplier->update();

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
            $supplier = Supplier::find($id);
            if (! $supplier) {
                throw new NotFoundException("id : " . $id);
            }
            $supplier->status = 1;
            $supplier->update();

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
