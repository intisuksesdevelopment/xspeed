<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotFoundException;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ItemService
{
    public static function getPaginatedList(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $query = DB::table('items as i')
            ->select([
                'i.id',
                'i.uuid',
                'i.name',
                'i.sku',
                'i.sell_price',
                'i.basic_price',
                'i.stock',
                'i.unit',
                'i.image_url',
                'i.category_id',
                'i.brand_id',
                'i.status',
                'i.created_at',
                'c.name as category_name',
                'c.code as category_code',
                'b.name as brand_name',
                'b.code as brand_code',
                'r.name as rack_name',
            ])
            ->leftJoin('categories as c', 'c.id', '=', 'i.category_id')
            ->leftJoin('brands as b', 'b.id', '=', 'i.brand_id')
            ->leftJoin('racks as r', 'r.id', '=', 'i.rack_id')
            ->where('i.status', 0);

        // 🔥 FILTER
        if ($request->category) {
            $query->where('i.category_id', $request->category);
        }

        if ($request->brand) {
            $query->where('i.brand_id', $request->brand);
        }

        // 🔥 SEARCH FILTER
        if ($request->search) {
            $search = $request->search;
            $searchBy = $request->search_by;

            $query->where(function($q) use ($search, $searchBy) {
                switch ($searchBy) {
                    case 'Name':
                        $q->where('i.name', 'like', "%{$search}%");
                        break;
                    case 'SKU':
                        $q->where('i.sku', 'like', "%{$search}%");
                        break;
                    case 'Brand':
                        $q->where('b.name', 'like', "%{$search}%");
                        break;
                    case 'Rack':
                        $q->where('r.name', 'like', "%{$search}%");
                        break;
                    default:
                        // Fallback to search all fields
                        $q->where('i.name', 'like', "%{$search}%")
                          ->orWhere('i.sku', 'like', "%{$search}%")
                          ->orWhere('b.name', 'like', "%{$search}%")
                          ->orWhere('r.name', 'like', "%{$search}%");
                }
            });
        }

        // 🔥 WAREHOUSE FILTER
        if ($request->warehouse) {
            $query->where('i.warehouse_id', $request->warehouse);
        }

        // 🔥 BRAND FILTER
        if ($request->brand) {
            $query->where('b.code', $request->brand);
        }

        // 🔥 COUNT (clone)
        $countQuery = clone $query;
        $total = $countQuery->count();

        // 🔥 SORTING
        $sortDirection = $request->sort === 'asc' ? 'asc' : 'desc';

        // 🔥 DATA
        $items = $query
            ->orderBy('i.created_at', $sortDirection)
            ->limit($perPage)
            ->offset($offset)
            ->get();

        // 🔥 TRANSFORM (lebih ringan dari Eloquent)
        $items->transform(function ($item) {
            $item->availability = match ($item->status) {
                0 => 'Tersedia',
                1 => 'Dihapus',
                2 => 'Tidak Aktif',
                default => 'Unknown'
            };

            return $item;
        });

        $lastPage = (int) ceil($total / $perPage);

        return [
            'current_page' => $page,
            'data' => $items,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => $lastPage,
        ];
    }

    public static function getPaginatedv2(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        $page = (int) $request->input('page', 1);

        $query = Item::query()
            ->select([
                'id',
                'uuid',
                'name',
                'sku',
                'sell_price',
                'stock',
                'unit',
                'image_url',
                'category_id',
                'brand_id',
                'rack_id',
                'status',
                'created_at',
            ])
            ->with([
                'category:id,name,code',
                'brand:id,name,code',
                'rack:id,name',
            ]);

        // 🔥 FILTER (pakai whereHas, jangan join)
        if ($request->category) {
            $query->whereHas(
                'category',
                fn($q) => $q->where('code', $request->category)
            );
        }

        // 🔥 CLONE query untuk count
        $countQuery = clone $query;

        // 🔥 COUNT (tanpa order, lebih cepat)
        $total = $countQuery->toBase()->getCountForPagination();

        // 🔥 DATA
        $items = $query
            ->orderBy('created_at', 'desc')
            ->forPage($page, $perPage)
            ->get();

        // 🔥 TAMBAH availability TANPA loop berat
        $items->transform(function ($item) {
            $item->availability = match ($item->status) {
                0 => 'Tersedia',
                1 => 'Dihapus',
                2 => 'Tidak Aktif',
                default => 'Unknown'
            };

            return $item;
        });

        // 🔥 HITUNG last page
        $lastPage = (int) ceil($total / $perPage);

        return [
            'current_page' => $page,
            'data' => $items,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => $lastPage,
        ];
    }

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
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
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided
        $items = Item::with(['category', 'subcategory', 'brand', 'warehouse', 'rack', 'images'])->where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($items as $item) {
            $item->availability = $item->isAvailable();
            $item->sell_price = UtilService::convertToIdr($item->sell_price, $item->currency);
            $item->basic_price = UtilService::convertToIdr($item->basic_price, $item->currency);
            $item->currency = 'IDR';
        }

        return $items;
    }

    public static function getForSelect(Request $request)
    {
        $search = $request->input('search', '');
        $categoryId = $request->input('category_id');
        $subcategoryId = $request->input('subcategory_id');
        $brandId = $request->input('brand_id');
        $page = (int) $request->input('page', 1);
        $limit = 20;

        Log::debug('getForSelect called', [
            'search' => $search,
            'categoryId' => $categoryId,
            'subcategoryId' => $subcategoryId,
            'brandId' => $brandId,
            'page' => $page,
        ]);

        $query = Item::select(['uuid', 'name', 'sku', 'stock', 'basic_price', 'image_url', 'category_id', 'sub_category_id', 'brand_id'])
            ->where('status', 0);

        // Search by name or SKU
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Category filter
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // Subcategory filter
        if (!empty($subcategoryId)) {
            $query->where('sub_category_id', $subcategoryId);
        }

        // Brand filter
        if (!empty($brandId)) {
            $query->where('brand_id', $brandId);
        }

        // Use simplePaginate for efficient LIMIT/OFFSET — avoids full COUNT query
        $items = $query->orderBy('name')
            ->simplePaginate($limit, ['*'], 'page', $page);

        $results = collect($items->items())->map(function ($item) {
            return [
                'id' => $item->uuid,
                'text' => $item->name,
                'sku' => $item->sku,
                'stock' => $item->stock,
                'basic_price' => $item->basic_price,
                'image_url' => $item->image_url,
                'category_id' => $item->category_id,
                'subcategory_id' => $item->sub_category_id,
                'brand_id' => $item->brand_id,
            ];
        });

        Log::debug('getForSelect results', [
            'count' => count($results),
            'hasMorePages' => $items->hasMorePages(),
        ]);

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $items->hasMorePages(),
            ],
        ]);
    }

    public static function getActive2($perPage = null, $sortBy = null, $sortDirection = null)
    {
        $perPage = $perPage ?? CommonConstants::PAGE;
        $sortBy = $sortBy ?? CommonConstants::SORT;
        $sortDirection = $sortDirection ?? CommonConstants::DIRECTION_DESC;

        // whitelist kolom biar aman
        $allowedSort = ['id', 'name', 'sell_price', 'created_at'];
        if (!in_array($sortBy, $allowedSort)) {
            $sortBy = 'id';
        }

        $allowedDirection = ['asc', 'desc'];
        if (!in_array(strtolower($sortDirection), $allowedDirection)) {
            $sortDirection = 'asc';
        }

        $items = Item::with([
            'category',
            'subcategory',
            'brand',
            'warehouse',
            'rack',
            'images',
        ])
            ->where('status', 0)
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);

        // transform data
        $items->getCollection()->transform(function ($item) {
            $item->availability = $item->isAvailable();
            $item->sell_price = UtilService::convertToIdr($item->sell_price, $item->currency);
            $item->currency = 'IDR';

            return $item;
        });

        return $items;
    }

    public static function getDetail($uuid)
    {
        $item = Item::query()
            ->where('uuid', $uuid)
            ->with([
                'category:id,code,name',
                'subcategory:id,code,name',
                'brand:id,code,name',
                'warehouse:id,code,name',
                'rack:id,code,name',
                'images:id,ref,ref_id,name,path,description'
            ])
            ->first();

        if (!$item) {
            throw new NotFoundException("uuid : {$uuid}");
        }

        // Add flattened fields for API response
        $item->status_text = $item->isAvailable();
        $item->category_code = $item->category?->code;
        $item->category_name = $item->category?->name;
        $item->subcategory_code = $item->subcategory?->code;
        $item->subcategory_name = $item->subcategory?->name;
        $item->brand_code = $item->brand?->code;
        $item->brand_name = $item->brand?->name;
        $item->warehouse_code = $item->warehouse?->code;
        $item->warehouse_name = $item->warehouse?->name;
        $item->rack_code = $item->rack?->code;
        $item->rack_name = $item->rack?->name;

        // Transform images to array
        $item->setRelation('images', $item->images->map(fn($img) => (object)[
            'id' => $img->id,
            'name' => $img->name,
            'path' => $img->path,
            'description' => $img->description
        ]));

        // Hide unnecessary relation ID fields
        $item->makeHidden(['category_id', 'sub_category_id', 'brand_id', 'warehouse_id', 'rack_id']);

        return $item;
    }

    public static function getSearch($query, $limit = 10)
    {
        $items = Item::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('sku', 'like', '%' . $query . '%');
            })
            ->limit($limit)
            ->get();

        return $items;
    }

    public static function getId($uuid)
    {
        $item = Item::where('uuid', $uuid)->first();

        if (!$item) {
            throw new NotFoundException("Item not found: uuid {$uuid}");
        }
        $item->status = $item->isAvailable();

        return $item['id'];
    }

    public static function save(Request $request)
    {
        try {
            $data = $request->all();

            // Check for existing item with case-insensitive name match
            $item = Item::query()->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($data['name']) . '%'])->first();
            if ($item) {
                throw new AlreadyExistException("Item already exists: name {$data['name']}");
            }

            // Create a new item
            $item = new Item;
            $data['uuid'] = (string) Str::uuid(); // Generate a unique identifier
            $data['image_url'] = ImageService::getCoverImage($request);
            // Validate and fill item attributes
            $item->validateAttributes($data);
            $item->fill($data);
            $item->save(); // Save the item to the database

            // Handle image saving
            ImageService::saveAll($request, 'items', $item->id);

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public static function edit(Request $request)
    {
        try {
            $data = $request->all();
            $item = Item::where('uuid', $data['uuid'])->first();
            if (!$item) {
                throw new NotFoundException("Item not found: uuid {$data['uuid']}");
            }
            $data['id'] = $item->id;
            $data['image_url'] = ImageService::getCoverImage($request);

            $data['stock'] = (int) $data['stock'];
            $data['stock_min'] = (int) $data['stock_min'];

            $item->validateAttributes($data, $item->id);
            $item->fill($data);
            $item->update(); // Save the item to the database

            // Handle image saving
            ImageService::saveAll($request, 'items', $item->id);

            return response()->json(['success' => true, 'message' => 'Update successfully!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public static function delete($uuid)
    {
        try {
            // Fetch the item model instance
            $item = Item::where('uuid', $uuid)->first();

            if (!$item) {
                throw new NotFoundException('Item not found: uuid ' . $uuid);
            }

            // Update the status
            $item->status = 1;
            $item->save(); // Save the item to the database

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public static function getItemsByCategory($categoryId = null, bool $isPaging = false, int $perPage = 10)
    {
        try {
            $query = Item::query()
                ->where('status', 0)
                ->with(['category', 'brand']);

            if ($categoryId !== null) {
                $query->where('category_id', $categoryId);
            }

            if ($isPaging) {
                $items = $query->paginate($perPage);
            } else {
                $items = $query->get();
            }

            // Transform items to include necessary fields
            $items->transform(function ($item) {
                $item->sell_price = UtilService::convertToIdr($item->sell_price, $item->currency);
                $item->currency = 'IDR';
                return $item;
            });

            return response()->json([
                'success' => true,
                'message' => 'Items retrieved successfully',
                'data' => $items
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get items by category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve items: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public static function getWithMinStock()
    {
        $items = Item::whereColumn('stock', '<=', 'stock_min')->get();

        return $items;
    }

    public static function checkStock($items)
    {
        $stock['available'] = [];
        $stock['not_available'] = [];
        foreach ($items as $item) {

            $itemSelect = Item::where('uuid', $item['uuid'])->first();
            $remaining = $itemSelect->stock - ($item['qty'] ?? 1);
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
        $item = new Item;
        $item->uuid = (string) Str::uuid();
        $item->sku = $row[1];
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
        $sortableColumns = ['name', 'sku', 'sell_price', 'unit', 'stock', 'created_at', 'status'];
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