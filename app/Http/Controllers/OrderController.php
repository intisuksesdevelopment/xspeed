<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\BankService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ConfigService;
use App\Services\ItemService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\RackService;
use App\Services\SubCategoryService;
use App\Services\SupplierService;
use App\Services\UnitService;
use App\Services\WarehouseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        Paginator::useBootstrap(); // Menggunakan Bootstrap
        $brands = OrderService::getPaginated($request);

        return view('pages.orders.order-list', ['orders' => $brands]);
    }

    public function addForm(Request $request)
    {
        // $data['suppliers'] = SupplierService::getActive($request);
        // $data['categories'] = CategoryService::getActive($request);
        // $data['subcategories'] = SubCategoryService::getActive($request);
        // $data['warehouses'] = WarehouseService::getActive($request);
        // $data['racks'] = RackService::getActive($request);
        // $data['brands'] = BrandService::getActive($request);
        // $data['units'] = UnitService::getActive($request);
        // $data['items'] = ItemService::getActive($request);
        $data['config'] = ConfigService::getActive($request);
        $data['paymentMethods'] = PaymentService::getActive($request);
        $data['banks'] = BankService::getActive($request);

        return view('pages.orders.order-add', $data);
    }

    public function createOrder($request)
    {
        return DB::transaction(function () use ($request) {

            $items = $request->input('items', []);

            if (empty($items)) {
                throw new Exception('Item tidak boleh kosong');
            }

            // =========================
            // HITUNG ULANG (ANTI MANIPULASI)
            // =========================
            $subtotal = 0;

            foreach ($items as $item) {
                $subtotal += $item['qty'] * $item['sell_price'];
            }

            $taxPercent = $request->taxPercent ?? 0;
            $discPercent = $request->discPercent ?? 0;

            $taxAmount = $subtotal * ($taxPercent / 100);
            $discAmount = $subtotal * ($discPercent / 100);

            $total = $subtotal + $taxAmount - $discAmount;

            // =========================
            // SAVE ORDER (HEADER)
            // =========================
            $order = Order::create([
                'transaction_id' => $request->transactionId,
                'supplier_id' => $request->supplier_id,
                'contact_id' => $request->contact_id,
                'warehouse_id' => $request->warehouse_id,

                'subtotal' => $subtotal,
                'tax_percent' => $taxPercent,
                'tax_amount' => $taxAmount,
                'disc_percent' => $discPercent,
                'disc_amount' => $discAmount,
                'total' => $total,
            ]);

            // =========================
            // SAVE ITEMS
            // =========================
            foreach ($items as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'] ?? null,
                    'sku' => $item['sku'],
                    'name' => $item['name'],
                    'price' => $item['sell_price'],
                    'qty' => $item['qty'],
                    'total' => $item['qty'] * $item['sell_price'],
                ]);
            }

            return $order;
        });
    }
}
