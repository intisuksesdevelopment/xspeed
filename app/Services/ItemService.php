<?php
namespace App\Services;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
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
        return Item::with('images')->where('id',21)->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }
    public static function getDetail($uuid)
    {
        $item = Item::where('uuid', $uuid) ->with(['category', 'subcategory', 'brand', 'warehouse', 'rack','images']) ->first();

        if (!$item) {
            throw new NotFoundException("uuid : {$uuid}");
        }
        $item->status = $item->isAvailable();
        return $item;
    }
    public static function save(Request $request)
    {
        $data = $request->all();
        $item = Item::where('name', 'ILIKE', '%' . $data['name'] . '%')->first();
        if ($item) {
            throw new AlreadyExistException("name : {$data['name']}");
        }
        $item = new Item();
        $item->validateAttributes($data);
        $item->fill($data);
        $item->save();

        return $item;
    }
}
