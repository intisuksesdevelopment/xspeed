<?php
namespace App\Services;

use App\Models\Stock;
use App\Models\StockData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\AlreadyExistException;

class StockService
{

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $stocks = Stock::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($stocks as $stock) {
            $stock->availability = $stock->isAvailable();
        }
        return $stocks;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $stocks = Stock::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($stocks as $stock) {
            $stock->availability = $stock->isAvailable();
        }
        return $stocks;
    }

    public static function save(Request $request)
    {
        try {
            $data           = $request->all();
            $data['uuid'] = (string) Str::uuid();
            $stock       = Stock::whereRaw('LOWER(periode) LIKE ?', ['%' . strtolower($data['periode']) . '%'])->get();

            if ($stock->isNotEmpty()) {
                $firstStock = $stock->first();
                throw new AlreadyExistException("no reference : {$firstStock->periode}");
            }
            $total_item = 0;
            $total_stock = 0;
            $total_count = 0;
            $total_diff = 0;
            $total_price = 0;
            $total_price_diff = 0;

            $data['products'] = json_decode($data['products'], true);
            foreach ($data['products'] as $product) {
                $total_item++;
                $total_stock += $product['stock'];
                $total_count += $product['count'];
                $total_diff += $product['count'] - $product['stock'];
                $total_price += $product['basic_price'] * $product['stock'];
            }
            
            // Calculate total price difference
            foreach ($data['products'] as $product) {
                $total_price_diff += $product['basic_price'] * $product['count'];
            }
            $total_price_diff -= $total_price;
            
            $stock = new Stock();
            $stock = $stock->fill($data);
            $stock->total_item = $total_item;
            $stock->stock_total = $total_stock;
            $stock->qty_total = $total_count;
            $stock->diff_total = $total_diff;
            $stock->price_total = $total_price;
            $stock->diff_price_total = $total_price_diff;
            $stock->status = 2;
            $stock->save();
            
            self::saveAllStockData($data['products'], $stock->id);

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }
    public static function saveAllStockData($products, $stock_id)
    {
        foreach ($products as $product) {
            $stockData = new StockData();
            $stockData->stock_id = $stock_id;
            $stockData->item_id = ItemService::getId($product['uuid']); // Assuming uuid is the item_id
            $stockData->item_stock = $product['stock'];
            $stockData->item_price = $product['basic_price'];
            $stockData->rack = $product['rack'] ?? null; // Assuming rack might be optional
            $stockData->qty = $product['stock'];
            $stockData->diff = $product['count'] - $product['stock'];
            $stockData->price_total = $product['basic_price'] * $product['count'];
            $stockData->created_by = auth()->user()->id?? null; // Assuming you have user authentication
            $stockData->status = 0; // Set the default status
            $stockData->save();
        }
    }
    
    public static function update(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? $request->input('status') : 0;

            $stock = Stock::find($data['id']);
            if (! $stock) {
                throw new NotFoundException("code : " . $data['code']);
            }
            // $category->validateAttributes($data);
            $stock->fill($data);
            $stock->update();

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
            $stock = Stock::find($id);
            if (! $stock) {
                throw new NotFoundException("id : " . $id);
            }
            $stock->status = 1;
            $stock->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'stock not found: ' . $e->getMessage(),
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
