<?php

namespace App\Exports;

use App\Models\Item;
use App\Services\UtilService;
use App\Services\BrandService;
use App\Services\WarehouseService;
use Illuminate\Support\NotFoundException;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsExport implements  FromQuery, WithHeadings,WithMapping

{
    protected $filters;

    // Constructor untuk menerima filter
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    // Removed misplaced ->when clauses


    public function query()
    {
        $query = Item::query();

        if (!empty($this->filters['searchInput'])) {
            $query->where('name', 'like', '%' . $this->filters['searchInput'] . '%');
        }
        if (!empty($this->filters['filterWarehouse'])) {
            $warehouseId = WarehouseService::getIdByCode($this->filters['filterWarehouse']);
            if ($warehouseId) {
                $query->where('warehouse_id', $warehouseId);
            }
        }
        if (!empty($this->filters['filterBrand'])) {
            $brandId = BrandService::getIdByCode($this->filters['filterBrand']);
            if ($brandId) {
                $query->where('brand_id', $brandId);
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Name',
            'SKU',
            'Barcode',
            'Category Code',
            'Subcategory Code',
            'Brand Code',
            'Warehouse Code',
            'Rack Code',
            'Basic Price',
            'Sell Price',
            'Unit',
            'Color',
            'Stock',
            'Stock Min',
            'Currency',
            'Description',
            'Image URL',
            'Status',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }
    public function map($row): array
    {
        return [
            $row->name,
            $row->sku,
            $row->barcode,
            $row->category->code?? '',
            $row->subcategory->code?? '',
            $row->brand->code?? '',
            $row->warehouse->code?? '',
            $row->rack->code,
            $row->basic_price,
            $row->sell_price,
            $row->unit,
            $row->color,
            $row->stock,
            $row->stock_min,
            $row->currency,
            $row->description,
            $row->image_url,
            $row->isAvailable(),
            $row->created_by,
            $row->updated_by,
            UtilService::formatDate( $row->created_at),
            UtilService::formatDate($row->updated_at),
        ];
    }

    
}
