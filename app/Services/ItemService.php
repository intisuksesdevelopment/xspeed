<?php
namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Item;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\Str;

class ItemService
{

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        $items = Item::with('images')->with(['category', 'brand', 'rack'])->orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($items as $item) {
            $item->availability = $item->isAvailable();
        }
        return $items;
    }
    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $items = Item::with(['category', 'subcategory', 'brand', 'warehouse', 'rack', 'images'])->where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($items as $item) {
            $item->availability = $item->isAvailable();
            $item->sell_price = UtilService::convertToIdr($item->sell_price, $item->currency);
            $item->currency = 'IDR';
        }
        return $items;
    }
    public static function getDetail($uuid)
    {
        $item = Item::where('uuid', $uuid)->with(['category', 'subcategory', 'brand', 'warehouse', 'rack', 'images'])->first();

        if (! $item) {
            throw new NotFoundException("uuid : {$uuid}");
        }
        $item->status = $item->isAvailable();
        return $item;
    }
    public static function getId($uuid)
    {
        $item = Item::where('uuid', $uuid)->first();

        if (! $item) {
            throw new NotFoundException("uuid : {$uuid}");
        }
        $item->status = $item->isAvailable();
        return $item['id'];
    }
    public static function save(Request $request)
    {
        try {
            $data = $request->all();

            // Check for existing item with case-insensitive name match
            $item = Item::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($data['name']) . '%'])->first();
            if ($item) {
                throw new AlreadyExistException("name : {$data['name']}");
            }

            // Create a new item
            $item              = new Item();
            $data['uuid']      = (string) Str::uuid(); // Generate a unique identifier
            $data['image_url'] = ImageService::getCoverImage($request);
            // Validate and fill item attributes
            $item->validateAttributes($data);
            $item->fill($data);
            $item->save(); // Save the item to the database

            // Handle image saving
            ImageService::saveAll($request, 'items', $item->id);

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    public static function edit(Request $request)
    {
        try {
            $data = $request->all();
            $item = Item::where('uuid', $data['uuid'])->first();
            if (! $item) {
                throw new AlreadyExistException("name : {$data['name']}");
            }
            $data['id']        = $item->id;
            $data['image_url'] = ImageService::getCoverImage($request);

            $data['stock']     = (int) $data['stock'];
            $data['stock_min'] = (int) $data['stock_min'];

            $item->validateAttributes($data, $item->id);
            $item->fill($data);
            $item->update(); // Save the item to the database

            // Handle image saving
            ImageService::saveAll($request, 'items', $item->id);

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }
    public static function delete($uuid)
    {
        try {
            // Fetch the item model instance
            $item = Item::where('uuid', $uuid)->first();

            if (! $item) {
                throw new NotFoundException("uuid : " . $uuid);
            }

            // Update the status
            $item->status = 1;
            $item->save(); // Save the item to the database

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Item not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    public static function getItemsByCategory($category_id){
        $items = Item::where('category_id', $category_id)->where('status',0)->with(['category'])->get();
        return response()->json($items);
    }

    public static function checkStock($items){
        $stock['available'] = [];
        $stock['not_available'] = [];
        foreach ($items as $item) {
            
            $itemSelect = Item::where('uuid', $item['uuid'])->first();
            $remaining = $itemSelect->stock - ($item['qty']??1);
            if($remaining >= 0){
                $stock['available'][] = $item;
            }else{
                $stock['not_available'][] = $item;
            }
        }
        
        return $stock;
    }

}
