<?php
namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UtilService;
use App\Services\ImageService;
use Yajra\DataTables\DataTables;
use App\Constants\CommonConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\AlreadyExistException;

class ItemService
{

    public static function getPaginated(Request $request)
    {
        $perPage       = $request->input('per_page', CommonConstants::PAGE);
        $sortBy        = $request->input('sortBy', CommonConstants::SORT);
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        $items         = Item::with('images')->with(['category', 'brand', 'rack'])->orderBy($sortBy, $sortDirection)->paginate($perPage);
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
            $item->sell_price   = UtilService::convertToIdr($item->sell_price, $item->currency);
            $item->currency     = 'IDR';
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
    public static function getItemsByCategory($category_id)
    {
        $items = Item::where('category_id', $category_id)->where('status', 0)->with(['category'])->get();
        return response()->json($items);
    }
    public static function getWithMinStock()
    {
        $items = Item::whereColumn('stock', '<=', 'stock_min')->get();
        return $items;
    }
    public static function checkStock($items)
    {
        $stock['available']     = [];
        $stock['not_available'] = [];
        foreach ($items as $item) {

            $itemSelect = Item::where('uuid', $item['uuid'])->first();
            $remaining  = $itemSelect->stock - ($item['qty'] ?? 1);
            if ($remaining >= 0) {
                $stock['available'][] = $item;
            } else {
                $stock['not_available'][] = $item;
            }
        }

        return $stock;
    }

    public static function uploadItem($row)
    {
        $item              = new Item();
        $item->uuid        = (string) Str::uuid();
        $item->sku         = $row[1];
        $item->description = $row[2];
        return $row;
    }

    public static function getData(Request $request)
{
    // Ambil parameter filter & sorting
    $search = $request->input('searchInput');
    $warehouse = $request->input('filterWarehouse');
    $brand = $request->input('filterBrand');
    
    // Ambil info kolom urutan (order)
    $columnIndex = $request->input('order.0.column');
    $orderBy = $request->input("columns.$columnIndex.name");
    $sortBy = $request->input('order.0.dir') === 'desc' ? 'desc' : 'asc';

    // // Cache key berdasarkan semua input
    // $cacheKey = 'datatable_products_' . md5(json_encode([
    //     'search' => $search,
    //     'warehouse' => $warehouse,
    //     'brand' => $brand,
    //     'orderBy' => $orderBy,
    //     'sortBy' => $sortBy,
    //     'page' => $request->input('start'),
    // ]));

    // return 
    // Cache::remember($cacheKey, now()->addMinutes(5), function () use ($search, $warehouse, $brand, $orderBy, $sortBy) {
        $query = Item::with(['category', 'brand'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($warehouse, function ($q) use ($warehouse) {
                $warehouseId = WarehouseService::getIdByCode($warehouse);
                if ($warehouseId) {
                    $q->where('warehouse_id', $warehouseId);
                }
            })
            ->when($brand, function ($q) use ($brand) {
                $brandId = BrandService::getIdByCode($brand);
                if ($brandId) {
                    $q->where('brand_id', $brandId);
                }
            });

        // Sorting dinamis (pastikan kolom ada di tabel item)
        $sortableColumns = ['name', 'sku', 'sell_price', 'unit', 'stock', 'created_at','status'];
        if (in_array($orderBy, $sortableColumns)) {
            $query->orderBy($orderBy, $sortBy);
        }
        return DataTables::of($query)
            ->addColumn('checkbox', function ($row) {
                return '<label class="checkboxs">
                            <input type="checkbox" value="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
            })
            ->addColumn('product', function ($row) {
                return view('pages.products.product-column', compact('row'))->render();
            })
            ->addColumn('category', fn($row) => $row->category->code ?? 'N/A')
            ->addColumn('brand', fn($row) => $row->brand->code ?? 'N/A')
            ->addColumn('created_at', fn($row) => UtilService::formatDate($row->created_at) ?? 'N/A')
            ->addColumn('status', function ($row) {
                $availability = $row->isAvailable();
                return $row->status == 0
                    ? '<span class="badge badge-linesuccess">' . $availability . '</span>'
                    : '<span class="badge badge-linedanger">' . $availability . '</span>';
            })
            ->addColumn('actions', function ($row) {
                return view('pages.products.product-actions', compact('row'))->render();
            })
            ->rawColumns(['checkbox', 'product', 'status', 'actions', 'created_at'])
            ->make(true);
    // });
}

    

}

// uuid
// name
// sku
// barcode
// category_id
// subcategory_id
// brand_id
// warehouse_id
// rack_id
// basic_price
// sell_price
// unit
// color
// stock
// stock_min
// currency
// description
// image_url
// status
// created_by
// updated_by
// created_at
// updated_at
// history_log
