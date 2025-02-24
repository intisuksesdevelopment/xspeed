<?php
namespace App\Services;

use App\Models\Sale;
use App\Models\SaleData;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\AlreadyExistException;

class SalesService{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $sales = Sales::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($sales as $sale) {
            $sale->availability = $sale->isAvailable();
        }
        return $sales;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', 'created_at');
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $sales = Sale::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($sales as $sale) {
            $sale->availability = $sale->isAvailable();
        }
        return $sales;
    }

    public static function save(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? 0 : 1;
            $sale           = Sale::whereRaw('LOWER(sale) = ?', [strtolower($data['sale'])])->first();  

            if ($sale) {  
                throw new AlreadyExistException("sale : {$sale->sale}");
            } else {  
                $sale = new Sale();
                // $supplier->validateAttributes($data);
                $sale->fill($data);
                $sale->save();
    
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

            $sale = Sale::find($data['id']);
            if (! $sale) {
                throw new NotFoundException("code : " . $data['code']);
            }
            // $category->validateAttributes($data);
            $sale->fill($data);
            $sale->update();

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
    public static function detail($request)
    {
        try {
            $data = [];
            $sales = Sale::where('trx_id', $request->id)
                        ->where('status', '<>', 2)
                        ->first();
            if ($sales) {
                $data['sales'] = $sales;
    
                $salesData = SaleData::where('sales_id', $sales->id)
                            ->where('status', '=', 0)->get();
                if ($salesData) {
                    $data['sales_data'] = $salesData;
                }
            }
    
            return $data;
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sale not found: ' . $e->getMessage(),
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
            $sale = Sale::find($id);
            if (! $sale) {
                throw new NotFoundException("id : " . $id);
            }
            $sale->status = 1;
            $sale->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sale not found: ' . $e->getMessage(),
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