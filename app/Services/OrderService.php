<?php
namespace App\Services;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Contact;
use App\Models\SaleData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ContactService;
use App\Constants\CommonConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\AlreadyExistException;

class OrderService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $orders = Order::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($orders as $order) {
            $order->availability = $order->isAvailable();
        }
        return $orders;
    }
    public static function save(Request $request)
    {
        try {
            
            $request['payment_total'] = UtilService::clearNumberFormat($request->input('payment_total'));
            $request['payment_change'] = UtilService::clearNumberFormat($request->input('payment_change'));
            
            //validate item is not empty

            $items = $request->input('itemOrderList');

            $decodedItems = json_decode($items, true);


            if (empty($decodedItems)) {
                throw new \Exception("Product must not empty");
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
                    $item['qty'] = $item['qty']??1;
                    $subtotal += ($item['qty'] * $item['sell_price']);
                    $subTotalItem +=$item['qty']  ;
                }
                
                $tax = $subtotal * $tax;
                $disc = $subtotal * $disc;
                $total = $subtotal + $tax + $shipping - $disc;
                
                $request['uuid'] = Str::uuid();
                $request['name'] = strtoupper($request->input('type').'-'.$request->input('trx_id'));
                $request['tax_percent'] = $request->input('tax')??0;
                $request['tax_total'] = $tax;
                $request['disc_percent'] = $request->input('discount')??0;
                $request['disc_total'] = $disc;
                $request['dp_total'] = $request->input('dp_total')??0;
                $request['up_total'] = $request->input('up_total')??0;
                $request['sub_total'] = $subtotal;
                $request['charge_data'] = $request->input('charge_data')??"[]";
                $request['charge_total'] = $request->input('charge_total')??0;
                $request['sub_total_item'] = $subTotalItem;
                $request['final_total'] = $total;

                $request['payment_id'] =$request->input('payment_method')??12;
                $request['payment_data'] =$request->input('payment_desc')??null;
                $request['payment_date'] =$request->input('payment_date')??null;
                $request['description'] =$request->input('description')??null;
                $request['payment_amount'] =UtilService::clearNumberFormat($request->input('payment_total')??0);
                $request['payment_change'] =$request->input('payment_change')??0;
                $request['payment_remaining'] =$request->input('payment_remaining')??0;
                $request['payment_status'] =$request->input('status')??0;
                $request['payment_at'] =date('Y-m-d H:i:s');
                $request['currency'] =$request->input('currency')??'idr';
                $request['created_by'] =Auth::user()->nik;
                $request['status'] =0;

                $custData = ContactService::getDetail($request->input('contact_id'));
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
                    $saleData['sales_id'] =  $sales->id;
                    $itemData = ItemService::getDetail($item['uuid']);
                    $item['item_id'] = $itemData['id'];
                    $item['item_id'] = $itemData['id'];
                    $item['item_name'] = $itemData['name'];
                    $item['item_code'] = $itemData['sku'];
                    $item['item_unit'] = $itemData['unit'];
                    $item['item_desc'] = $itemData['item_desc'];
                    $item['item_amount'] = $item['qty'];
                    $item['item_price'] = $itemData['sell_price'];
                    $item['item_total'] = $itemData['sell_price']* $item['qty'];
                    $item['created_at'] =date('Y-m-d H:i:s');
                    $item['created_by'] =Auth::user()->nik;
                    $item['status'] =0;

                    $saleData->fill($item);
                    $saleData->save();
                }
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
            return response()->json(['success' => false, 'message' => $e->getMessage()??'An error occurred. Please try again later.']);
        }
    }
}