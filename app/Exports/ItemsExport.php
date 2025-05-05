<?php
namespace App\Exports;

use App\Models\Item;
use App\Services\BrandService;
use App\Services\UtilService;
use App\Services\WarehouseService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ItemsExport implements FromQuery, WithMapping, WithCustomStartCell, WithEvents, WithTitle, WithDrawings, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Item::with([
            'category',
            'subcategory',
            'brand',
            'warehouse',
            'rack',
        ]);

        if (! empty($this->filters['searchInput'])) {
            $query->where('name', 'like', '%' . $this->filters['searchInput'] . '%');
        }

        if (! empty($this->filters['filterWarehouse'])) {
            $warehouseId = WarehouseService::getIdByCode($this->filters['filterWarehouse']);
            if ($warehouseId) {
                $query->where('warehouse_id', $warehouseId);
            }
        }

        if (! empty($this->filters['filterBrand'])) {
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
            $row->category->code ?? '',
            $row->subcategory->code ?? '',
            $row->brand->code ?? '',
            $row->warehouse->code ?? '',
            $row->rack->code ?? '',
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
            UtilService::formatDate($row->created_at),
            UtilService::formatDate($row->updated_at),
        ];
    }

    public function startCell(): string
    {
        return 'A8';
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('XspeedLogo');
        $drawing->setDescription('XspeedLogo');
        $drawing->setPath(public_path('build/src/img/xspeed-logo-white.png'));
        $drawing->setHeight(75);
        $drawing->setCoordinates('A2');

        return $drawing;
    }
    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\BeforeSheet::class => function (\Maatwebsite\Excel\Events\BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Tulis "LAPORAN PRODUK" di A1
                $sheet->setCellValue('A1', 'LAPORAN PRODUK');
                $sheet->mergeCells('A1:V1'); // Merge dari A1 sampai V1

                // Tulis "Tanggal Export" di A2
                $today = now()->format('d F Y');
                $sheet->mergeCells('A2:V2');
                $sheet->getStyle('A1:V6')->applyFromArray(
                    ['font' => [
                        'color' => [
                            'rgb' => 'FFCD07',
                        ],
                    ],
                        'fill'  => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => '1B2A51'],
                        ],
                    ]
                );
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);

                $sheet->getStyle('A6')->applyFromArray(
                    [
                        'font' => [
                            'name'  => 'Arial',
                            'bold'  => true,
                            'size'  => 14,
                            'color' => [
                                'rgb' => 'FFCD07',
                            ],
                        ], 'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical'   => Alignment::VERTICAL_CENTER,
                            'wrapText'   => true,
                        ],
                    ]
                );
               
                $sheet->setCellValue('A6', 'XspeedMotopart');
                $sheet->mergeCells('A6:C6');

                $sheet->getStyle('A8:V8')->applyFromArray(
                    [
                        'font' => [
                            'name'  => 'Arial',
                            'bold'  => true,
                            'size'  => 14,
                            'color' => [
                                'rgb' => 'FFCD07',
                            ],
                        ], 'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical'   => Alignment::VERTICAL_CENTER,
                            'wrapText'   => true,
                        ],
                    ]
                );
                $sheet->setCellValue('V6', 'Export By: ' . Auth::user()->username . ' @' . $today);
                $sheet->getStyle('V6')->applyFromArray(
                    [
                        'font' => [
                            'name'  => 'Arial',
                            'size'  => 8,
                            'color' => [
                                'rgb' => 'FFCD07',
                            ],
                        ], 'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_RIGHT,
                            'vertical'   => Alignment::VERTICAL_CENTER,
                        ],
                    ]
                );

            },
        ];
    }

    public function title(): string
    {
        return 'Data Product';
    }
}
