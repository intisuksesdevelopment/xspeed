<?php
namespace App\Services;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemService
{

    public static function getPaginatedItems(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        // Default to 10 items per page if not provided
        $sortBy = $request->input('sortBy', 'id');
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', 'asc');
        // Default to 'asc' if not provided
        return Items::orderBy($sortBy, $sortDirection)->paginate($perPage);
    }
    public static function getDetailItem($uuid)
    {
        $item = Items::where('uuid', $uuid)->first();
        if (!$item) {
            throw new ItemNotFoundException("Item with UUID {$uuid} not found.");
        }
        return $item;
    }
}
