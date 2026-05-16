<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Order;
use App\Models\Sale;
use App\Models\SaleData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided
        $orders = Order::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($orders as $order) {
            $order->availability = $order->isAvailable();
        }

        return $orders;
    }

public static function createOrder(Request $request)
{
    try {

        Log::info('Starting order creation', ['transaction_id' => $request->input('transactionId')]);

        $request['payment_total'] = UtilService::clearNumberFormat($request->input('payment_total'));
        $request['payment_change'] = UtilService::clearNumberFormat($request->input('payment_change'));

        Log::info('Payment data cleared');

        // decode items json string if it's still a string
        $itemsInput = $request->input('items');
        if (is_string($itemsInput)) {
            $request->merge([
                'items' => json_decode($itemsInput, true),
            ]);
        }

        Log::info('Items decoded', ['items_count' => count($request->input('items', []))]);

        // validation
        $validated = $request->validate([
            'transactionId' => 'required|string',
            'type' => 'required|string',

            'supplierUuid' => 'nullable|uuid',
            'contact_id' => 'nullable|string',

            // request kirim angka
            'warehouseId' => 'required|integer',

            'taxPercent' => 'nullable|numeric|min:0',
            'discPercent' => 'nullable|numeric|min:0',

            'items' => 'required|array|min:1',
            'items.*.uuid' => 'required|uuid',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.sell_price' => 'required|numeric|min:0',
        ]);

        Log::info('Validation passed');

        $items = $request->input('items');

        // Start database transaction
        DB::beginTransaction();

        try {
            $sales = Sale::query()
                ->where('trx_id', $request->input('transactionId'))
                ->first();

            if ($sales) {
                throw new \Exception("Duplicate transaction ID: {$request->input('transactionId')}");
            }

            $tax = $request->input('taxPercent', 0) / 100;
            $disc = $request->input('discPercent', 0) / 100;
            $shipping = $request->input('shipping') ?? 0;

            $subTotalItem = 0;
            $subtotal = 0;

            $checkStock = ItemService::checkStock($items);

            if ($checkStock['not_available']) {
                throw new \Exception(
                    'Stock not enough for: ' .
                    implode(', ', array_column($checkStock['not_available'], 'name'))
                );
            }

            foreach ($items as $item) {
                $item['qty'] = $item['qty'] ?? 1;

                $subtotal += ($item['qty'] * $item['sell_price']);
                $subTotalItem += $item['qty'];
            }

            $tax = $subtotal * $tax;
            $disc = $subtotal * $disc;
            $total = $subtotal + $tax + $shipping - $disc;

            $request['uuid'] = Str::uuid();
            $request['trx_id'] = $request->input('transactionId');
            $request['name'] = strtoupper(
                $request->input('type') . '-' . $request->input('transactionId')
            );

            $request['tax_percent'] = $request->input('taxPercent') ?? 0;
            $request['tax_total'] = $tax;

            $request['disc_percent'] = $request->input('discPercent') ?? 0;
            $request['disc_total'] = $disc;

            $request['dp_total'] = $request->input('dp_total') ?? 0;
            $request['up_total'] = $request->input('up_total') ?? 0;

            $request['sub_total'] = $subtotal;

            $request['charge_data'] = $request->input('charge_data') ?? '[]';
            $request['charge_total'] = $request->input('charge_total') ?? 0;

            $request['sub_total_item'] = $subTotalItem;
            $request['final_total'] = $total;

            $request['payment_id'] = $request->input('payment_method') ?? 12;
            $request['payment_data'] = $request->input('payment_desc') ?? null;
            $request['payment_date'] = $request->input('payment_date') ?? null;

            $request['description'] = $request->input('description') ?? null;

            $request['payment_amount'] = UtilService::clearNumberFormat(
                $request->input('payment_total') ?? 0
            );

            $request['payment_change'] = $request->input('payment_change') ?? 0;
            $request['payment_remaining'] = $request->input('payment_remaining') ?? 0;

            $request['payment_status'] = $request->input('status') ?? 0;

            $request['payment_at'] = date('Y-m-d H:i:s');

            $request['currency'] = $request->input('currency') ?? 'idr';

            $request['created_by'] = Auth::check() ? Auth::user()->username : 'system';

            $request['status'] = 0;

            // Get customer data only if contact_id is provided
            $contactId = $request->input('contact_id');
            if ($contactId) {
                try {
                    $custData = ContactService::getDetail($contactId);
                    $request['cust_id'] = $custData['id'] ?? null;
                    $request['cust_address'] = $custData['address'] ?? null;
                    $request['cust_phone'] = $custData['phone'] ?? null;
                    $request['cust_name'] = $custData['name'] ?? null;
                    $request['cust_email'] = $custData['email'] ?? null;
                } catch (\Exception $e) {
                    Log::warning('Failed to fetch contact details: ' . $e->getMessage());
                    $request['cust_id'] = null;
                    $request['cust_address'] = null;
                    $request['cust_phone'] = null;
                    $request['cust_name'] = null;
                    $request['cust_email'] = null;
                }
            } else {
                $request['cust_id'] = null;
                $request['cust_address'] = null;
                $request['cust_phone'] = null;
                $request['cust_name'] = null;
                $request['cust_email'] = null;
            }

            Log::info('Creating Sale record');
            $sales = new Sale;
            $sales->fill($request->all());
            $sales->save();

            Log::info('Sale created', ['sale_id' => $sales->id]);

            foreach ($items as $item) {

                $saleData = new SaleData;

                $saleData['sales_id'] = $sales->id;

                $itemData = ItemService::getDetail($item['uuid']);

                $item['item_id'] = $itemData['id'];
                $item['item_name'] = $itemData['name'];
                $item['item_code'] = $itemData['sku'];
                $item['item_unit'] = $itemData['unit'];
                $item['item_desc'] = $itemData['item_desc'] ?? null;

                $item['item_amount'] = $item['qty'];

                $item['item_price'] = $itemData['sell_price'];

                $item['item_total'] =
                    $itemData['sell_price'] * $item['qty'];

                $item['created_at'] = date('Y-m-d H:i:s');
                $item['created_by'] = Auth::check() ? Auth::user()->nik : 'system';

                $item['status'] = 0;

                $saleData->fill($item);
                $saleData->save();

                Log::info('SaleData created', ['sale_data_id' => $saleData->id, 'item_name' => $item['item_name']]);
            }

            // Commit transaction
            DB::commit();
            Log::info('Order created successfully', ['sale_id' => $sales->id]);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully!'
            ]);

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            Log::error('Transaction rolled back: ' . $e->getMessage());
            throw $e;
        }

    } catch (\Exception $e) {

        Log::error('Order creation failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}
