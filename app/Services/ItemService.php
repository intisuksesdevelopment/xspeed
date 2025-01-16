<?php
namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\ItemNotFoundException;

class ItemService
{

    public static function getPaginatedItems(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 Item per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        return Item::orderBy($sortBy, $sortDirection)->paginate($perPage);
    }
    public static function getDetailItem($uuid)
    {
        $item = Item::where('uuid', $uuid)->first();
        if (!$item) {
            throw new ItemNotFoundException("Item with UUID {$uuid} not found.");
        }
        return $item;
    }
    public static function saveItem(Request $request)
    {
        $data = $request->all();
        $item = Item::where('name', 'ILIKE', '%' . $item->name . '%')->get();
        if ($item) {
            throw new ItemAlready("Item with UUID {$uuid} not found.");
        }
        $item = new Item();
        $item->validateAttributes($data);
        $item->fill($data);
        $item->save();

        return $item;
    }
}
