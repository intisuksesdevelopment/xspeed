<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Stock;
use App\Models\StockData;
use Illuminate\Http\Request;
use App\Exceptions\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Str;

class StockService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);

        $query = Stock::query()->where('status', '!=', 1)
            ->with('warehouse:id,name,code')
            ->with('creator:id,name');

        // Search functionality
        $search = $request->input('search', '');
        $searchBy = $request->input('search_by', 'periode');

        if ($search) {
            $query->where('periode', 'like', '%' . $search . '%');
        }

        // Validate sortBy column
        $allowedColumns = ['created_at', 'periode', 'id'];
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }
        $sortDirection = $sortDirection === 'asc' ? 'asc' : 'desc';

        $stocks = $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
        $stocks->getCollection()->transform(function ($stock) {
            $stock->availability = $stock->isStatus();
            $stock->warehouse_name = $stock->warehouse?->name ?? '-';
            $stock->creator_name = $stock->creator?->name ?? '-';
            return $stock;
        });

        return $stocks;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
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
            $data = $request->all();
            $data['uuid'] = (string) Str::uuid();

            // Validate required warehouse_id
            if (empty($data['warehouse_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse is required. Please select a warehouse.',
                ]);
            }
            $stock = Stock::whereRaw('LOWER(periode) LIKE ?', ['%'.strtolower($data['periode']).'%'])->get();

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

            $stock = new Stock;
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
            $stockData = new StockData;
            $stockData->stock_id = $stock_id;
            $stockData->item_id = ItemService::getId($product['uuid']); // Assuming uuid is the item_id
            $stockData->item_stock = $product['stock'];
            $stockData->item_price = $product['basic_price'];
            $stockData->rack = !empty($product['rack']) ? $product['rack'] : ''; // Default to empty string if not provided
            $stockData->qty = $product['stock'];
            $stockData->diff = $product['count'] - $product['stock'];
            $stockData->price_total = $product['basic_price'] * $product['count'];
            $stockData->created_by = auth()->user()->id ?? null; // Assuming you have user authentication
            $stockData->status = 0; // Set the default status
            $stockData->save();
        }
    }

    public static function update(Request $request)
    {
        try {
            $data = $request->all();
            $data['status'] = $request->has('status') ? $request->input('status') : 0;

            $stock = Stock::find($data['id']);
            if (! $stock) {
                throw new NotFoundException('code : '.$data['code']);
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

    public static function updateStock(Request $request, $id)
    {
        try {
            $data = $request->all();
            \Log::info('StockService updateStock', ['id' => $id, 'status' => $data['status'] ?? 'not set', 'products_count' => count(json_decode($data['products'] ?? '[]', true))]);

            // Validate required warehouse_id
            if (empty($data['warehouse_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse is required. Please select a warehouse.',
                ]);
            }

            // Find existing stock
            $stock = Stock::where('uuid', $id)->first();
            if (!$stock) {
                throw new NotFoundException('uuid : ' . $id);
            }

            // Calculate totals
            $total_item = 0;
            $total_stock = 0;
            $total_count = 0;
            $total_diff = 0;
            $total_price = 0;
            $total_price_diff = 0;

            $products = json_decode($data['products'] ?? '[]', true);
            if (!is_array($products)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid products data.',
                ]);
            }

            foreach ($products as $product) {
                $total_item++;
                $total_stock += $product['stock'];
                $total_count += $product['count'];
                $total_diff += $product['count'] - $product['stock'];
                $total_price += $product['basic_price'] * $product['stock'];
            }

            // Calculate total price difference
            foreach ($products as $product) {
                $total_price_diff += $product['basic_price'] * $product['count'];
            }
            $total_price_diff -= $total_price;

            // Update stock
            $stock->periode = $data['periode'] ?? $stock->periode;
            $stock->warehouse_id = $data['warehouse_id'];
            $stock->total_item = $total_item;
            $stock->stock_total = $total_stock;
            $stock->qty_total = $total_count;
            $stock->diff_total = $total_diff;
            $stock->price_total = $total_price;
            $stock->diff_price_total = $total_price_diff;
            $stock->status = isset($data['status']) ? (int)$data['status'] : 2;
            $stock->updated_by = auth()->user()->id ?? null;
            $stock->save();

            \Log::info('Stock updated, status now', ['stock_status' => $stock->status]);

            // Delete old stock data and create new ones
            StockData::where('stock_id', $stock->id)->delete();
            self::saveAllStockData($products, $stock->id);

            // If accepting (status = 0), update actual item stock quantities
            if ($stock->status == 0) {
                \Log::info('Accepting stock, applying changes');
                self::applyStockChanges($products);
            }

            return response()->json(['success' => true, 'message' => 'Stock updated successfully!']);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Stock not found: '.$e->getMessage()], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    /**
     * Apply stock changes to items when stock opname is accepted
     */
    private static function applyStockChanges($products)
    {
        \Log::info('applyStockChanges called with', ['count' => count($products)]);
        foreach ($products as $index => $product) {
            \Log::info("Processing product $index", $product);
            if (empty($product['uuid'])) {
                \Log::info("Skipping - no uuid");
                continue;
            }

            $item = \App\Models\Item::where('uuid', $product['uuid'])->first();
            if ($item) {
                \Log::info("Found item", ['uuid' => $item->uuid, 'name' => $item->name, 'current_stock' => $item->stock]);
                // Update item stock with the counted quantity
                $item->stock = (float) ($product['count'] ?? $item->stock);
                $item->save();
                \Log::info("Item stock updated", ['new_stock' => $item->stock]);
            } else {
                \Log::info("Item not found", ['uuid' => $product['uuid']]);
            }
        }
    }

    public static function delete($id)
    {
        try {
            $stock = Stock::where('uuid', $id)->first();
            if (!$stock) {
                throw new NotFoundException('uuid : ' . $id);
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
                'message' => 'stock not found: '.$e->getMessage(),
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
