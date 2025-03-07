<?php
namespace App\Services;

use App\Models\Sale;
use App\Models\SaleData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UtilService;
use App\Constants\CommonConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\AlreadyExistException;

class SalesService{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $sales = Sales::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($sales as $sale) {
            $sale->availability = $sale->isAvailable();
        }
        return $sales;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', 'created_at');
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $sales = Sale::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($sales as $sale) {
            $sale->availability = $sale->isAvailable();
        }
        return $sales;
    }

    public static function save(Request $request)
    {
        try {
            
            $request['payment_total'] = UtilService::clearNumberFormat($request->input('payment_total'));
            $request['payment_change'] = UtilService::clearNumberFormat($request->input('payment_change'));
            
            //validate item is not empty

            $items = $request->input('itemSalesList');
            if (empty($items)) {
                throw new NotFoundException("Item is empty");
            }

            $sales = Sale::where('trx_id', $request->input('trx_id'))->first();
            if ($sales) {
                throw new AlreadyExistException("trx_id : {$request->input('trx_id')}");
            } else {
                $tax = $request->input('tax')/100;
                $disc = $request->input('discount')/100;
                $shipping = $request->input('shipping')??0;
                $dp = 0;  
                $up = 0;
                $charge = 0;
                $subTotalItem = 0;
                $finalTotal = 0;
                $subtotal = 0;
                $total = 0;
                $items = json_decode($items, true);
                $checkStock = ItemService::checkStock($items);
                if ($checkStock['not_available']) {
                    throw new NotFoundException("Stock not enough for: " . implode(", ", array_column($checkStock['not_available'], 'name')));
                }
                foreach ($items as $item) {
                    $subtotal += ($item['qty'] * $item['sell_price']);
                    $subTotalItem +=$item['qty']  ;
                }
                $tax = $subtotal * $tax;
                $disc = $subtotal * $disc;
                $total = $subtotal + $tax + $shipping - $disc;
                
                $request['uuid'] = Str::uuid();
                $request['name'] = $request->input('type').'-'.$request->input('trx_id');
                $request['tax_percent'] = $request->input('tax');
                $request['tax_total'] = $tax;
                $request['disc_percent'] = $request->input('discount');
                $request['disc_total'] = $disc;
                $request['dp_total'] = $request->input('dp_total')??0;
                $request['up_total'] = $request->input('up_total')??0;
                $request['sub_total'] = $subtotal;
                $request['charge_data'] = $request->input('charge_data')??"[]";
                $request['charge_total'] = $request->input('charge_total')??0;
                $request['sub_total_item'] = $subTotalItem;
                $request['final_total'] = $total;

                $request['payment_id'] =$request->input('payment_method')??12;
                $request['payment_desc'] =$request->input('payment_desc')??null;
                $request['payment_date'] =$request->input('payment_date')??null;
                $request['payment_amount'] =UtilService::clearNumberFormat($request->input('payment_total')??0);
                $request['payment_change'] =$request->input('payment_change')??0;
                $request['payment_remaining'] =$request->input('payment_remaining')??0;
                $request['payment_status'] =$request->input('status')??0;
                $request['payment_at'] =date('Y-m-d H:i:s');
                $request['currency'] =$request->input('currency')??'idr';
                $request['created_by'] =Auth::user()->nik;
                $request['status'] =0;

                $custData = CustomerService::getDetail($request->input('customer'));
                $request['cust_id'] =$custData['id'];
                $request['cust_address'] =$custData['address'];
                $request['cust_phone'] =$custData['phone'];
                $request['cust_name'] =$custData['name'];
                $request['cust_email'] =$custData['email'];

                $sales = new Sale();
                $sales->fill($request->all());
                $sales->save();
                
                foreach ($items as $item) {
                    $saleData = new SaleData();
                    $saleData->fill($item);
                    $saleData->sales_id = $sales->id;
                    $saleData->save();
                    $total += $saleData->item_total;
                }
                $sales->total = $total;
                $sales->update();
                return response()->json(['success' => true, 'message' => 'Add successfully!']);
            }
            $data           = $request->all();
            $data['status'] = $request->has('status') ? 0 : 1;
            $sale           = Sale::whereRaw('LOWER(sale) = ?', [strtolower($data['sale'])])->first();  

            dd($request->all());
            if ($sale) {  
                throw new AlreadyExistException("sale : {$sale->sale}");
            } else {  
                $sale = new Sale();
                // $supplier->validateAttributes($data);
                $sale->fill($data);
                $sale->save();
    
                return response()->json(['success' => true, 'message' => 'Add successfully!']);
            }  
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    public static function update(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? $request->input('status') : 0;

            $sale = Sale::find($data['id']);
            if (! $sale) {
                throw new NotFoundException("code : " . $data['code']);
            }
            // $category->validateAttributes($data);
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
                'message' => 'Category not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
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
                'message' => 'Sale not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public static function delete($id)
    {
        try {
            $sale = Sale::find($id);
            if (! $sale) {
                throw new NotFoundException("id : " . $id);
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
                'message' => 'Sale not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}