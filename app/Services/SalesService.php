<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Sale;
use App\Models\SaleData;
use Illuminate\Http\Request;
use App\Exceptions\AlreadyExistException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Str;
use App\Services\CustomerService;
use App\Services\ItemService;
use App\Services\UtilService;

class SalesService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        $sales = Sale::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($sales as $sale) {
            $sale->availability = $sale->isAvailable();
        }

        return $sales;
    }

    public static function getInvoices(Request $request, $type)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        $sales = Sale::where('type', $type)->orderBy($sortBy, $sortDirection)->paginate($perPage);

        return $sales;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        $sales = Sale::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($sales as $sale) {
            $sale->availability = $sale->isAvailable();
        }

        return $sales;
    }

    public static function createSale(Request $request)
    {
        try {
            Log::info('Starting sale creation', ['transaction_id' => $request->input('transactionId')]);

            $request['payment_total'] = UtilService::clearNumberFormat($request->input('payment_total'));
            $request['payment_change'] = UtilService::clearNumberFormat($request->input('payment_change'));

            // decode items json string if needed
            $itemsInput = $request->input('items');
            if (is_string($itemsInput)) {
                $request->merge(['items' => json_decode($itemsInput, true)]);
            }

            // validation
            $validated = $request->validate([
                'transactionId'    => 'required|string',
                'type'             => 'required|string',
                'customerUuid'     => 'nullable|string',
                'contact_id'       => 'nullable|string',
                'warehouseId'      => 'required|integer',
                'taxPercent'       => 'nullable|numeric|min:0',
                'discPercent'      => 'nullable|numeric|min:0',
                'items'            => 'required|array|min:1',
                'items.*.uuid'     => 'required|uuid',
                'items.*.qty'      => 'required|integer|min:1',
                'items.*.sell_price' => 'required|numeric|min:0',
            ]);

            $items = $request->input('items');

            DB::beginTransaction();

            try {
                $existing = Sale::where('trx_id', $request->input('transactionId'))->first();
                if ($existing) {
                    throw new \Exception("Duplicate transaction ID: {$request->input('transactionId')}");
                }

                $tax     = $request->input('taxPercent', 0) / 100;
                $disc    = $request->input('discPercent', 0) / 100;
                $subtotal = 0;
                $subTotalItem = 0;

                foreach ($items as $item) {
                    $item['qty'] = $item['qty'] ?? 1;
                    $subtotal     += ($item['qty'] * $item['sell_price']);
                    $subTotalItem += $item['qty'];
                }

                $taxAmount  = $subtotal * $tax;
                $discAmount = $subtotal * $disc;
                $total      = $subtotal + $taxAmount - $discAmount;

                $request['uuid']    = Str::uuid();
                $request['trx_id']  = $request->input('transactionId');
                $request['name']    = strtoupper($request->input('type') . '-' . $request->input('transactionId'));
                $request['type']    = 'sales';

                $request['tax_percent'] = $request->input('taxPercent') ?? 0;
                $request['tax_total']   = $taxAmount;

                $request['disc_percent'] = $request->input('discPercent') ?? 0;
                $request['disc_total']   = $discAmount;

                $request['dp_total'] = $request->input('dp_total') ?? 0;
                $request['up_total'] = $request->input('up_total') ?? 0;

                $request['sub_total']      = $subtotal;
                $request['sub_total_item'] = $subTotalItem;
                $request['final_total']    = $total;

                $request['charge_data']  = $request->input('charge_data') ?? '[]';
                $request['charge_total'] = $request->input('charge_total') ?? 0;

                $request['payment_id']        = $request->input('payment_method') ?? 1;
                $request['bank_account_id']   = $request->input('bank_account_id') ?? null;
                $request['payment_data']      = $request->input('payment_desc') ?? null;
                $request['payment_date']      = $request->input('payment_date') ?? null;
                $request['payment_amount']    = UtilService::clearNumberFormat($request->input('payment_total') ?? 0);
                $request['payment_change']    = $request->input('payment_change') ?? 0;
                $request['payment_remaining'] = $request->input('payment_remaining') ?? 0;
                $request['payment_status']    = $request->input('status') ?? 0;
                $request['payment_at']        = date('Y-m-d H:i:s');

                $request['currency']    = $request->input('currency') ?? 'idr';
                $request['created_by']  = Auth::check() ? Auth::user()->username : 'system';
                $request['status']      = 0;
                $request['warehouse_id'] = $request->input('warehouseId') ?? null;

                // Get customer data
                $customerUuid = $request->input('customerUuid');
                if ($customerUuid) {
                    try {
                        $customer = CustomerService::getDetail($customerUuid);
                        $request['cust_id']      = $customer['id'] ?? null;
                        $request['cust_name']    = $customer['name'] ?? null;
                        $request['cust_address'] = $customer['address'] ?? null;
                        $request['cust_phone']   = $customer['phone'] ?? null;
                        $request['cust_email']   = $customer['email'] ?? null;
                    } catch (\Exception $e) {
                        Log::warning('Failed to fetch customer details: ' . $e->getMessage());
                        $request['cust_id'] = null;
                        $request['cust_name'] = null;
                        $request['cust_address'] = null;
                        $request['cust_phone'] = null;
                        $request['cust_email'] = null;
                    }
                }

                Log::info('Creating Sale record');
                $sale = new Sale;
                $sale->fill($request->all());
                $sale->save();

                Log::info('Sale created', ['sale_id' => $sale->id]);

                foreach ($items as $item) {
                    $itemData = ItemService::getDetail($item['uuid']);

                    $saleData = new SaleData;
                    $saleData->sales_id         = $sale->id;
                    $saleData->item_id          = $itemData['id'];
                    $saleData->item_code        = $itemData['sku'];
                    $saleData->item_name        = $itemData['name'];
                    $saleData->item_amount      = $item['qty'];
                    $saleData->item_unit        = $itemData['unit'] ?? null;
                    $saleData->item_price       = $item['sell_price'];
                    $saleData->item_disc        = 0;
                    $saleData->item_disc_total  = 0;
                    $saleData->item_total       = $item['qty'] * $item['sell_price'];
                    $saleData->created_by       = Auth::check() ? Auth::user()->username : 'system';
                    $saleData->status           = 0;
                    $saleData->save();
                }

                // Update sale total
                $sale->final_total = $total;
                $sale->sub_total   = $subtotal;
                $sale->save();

                DB::commit();
                Log::info('Sale created successfully', ['sale_id' => $sale->id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Sale created successfully!'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Transaction rolled back: ' . $e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Sale creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function update(Request $request)
    {
        try {
            $data = $request->all();
            $data['status'] = $request->has('status') ? $request->input('status') : 0;

            $sale = Sale::find($data['id']);
            if (! $sale) {
                throw new NotFoundException('code : '.$data['code']);
            }
            $sale->fill($data);
            $sale->update();

            return response()->json([
                'success' => true,
                'message' => 'Update successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Sale not found: '.$e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: '.$e->getMessage(),
            ], 500);
        }
    }

    public static function detail($request)
    {
        try {
            $data = [];
            $sales = Sale::where('trx_id', $request->id)
                ->where('status', '<>', 2)
                ->first();
            if ($sales) {
                $data['sales'] = $sales;

                $salesData = SaleData::where('sales_id', $sales->id)
                    ->where('status', '=', 0)->get();
                if ($salesData) {
                    $data['sales_data'] = $salesData;
                }
            }

            return $data;
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Sale not found: '.$e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: '.$e->getMessage(),
            ], 500);
        }
    }

    public static function delete($id)
    {
        try {
            $sale = Sale::find($id);
            if (! $sale) {
                throw new NotFoundException('id : '.$id);
            }
            $sale->status = 1;
            $sale->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Sale not found: '.$e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: '.$e->getMessage(),
            ], 500);
        }
    }
}
