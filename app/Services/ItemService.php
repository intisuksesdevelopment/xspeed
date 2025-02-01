<?php
namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Constants\CommonConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\AlreadyExistException;

class ItemService
{

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 Item per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        return Item::with('images')->with('category')->with('category')->with('subcategory')->with('rack')->orderBy($sortBy, $sortDirection)->paginate($perPage);
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
            $item         = new Item();
            $data['uuid'] = (string) Str::uuid(); // Generate a unique identifier

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
}
