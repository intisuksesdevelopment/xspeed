<?php

namespace App\Http\Controllers;

use App\Services\BankAccountService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ContactService;
use App\Services\CustomerService;
use App\Services\ItemService;
use App\Services\OrderService;
use App\Services\PaymentMethodService;
use App\Services\SalesService;
use App\Services\SubCategoryService;
use App\Services\SupplierService;
use App\Services\UnitService;
use App\Services\RackService;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getProducts(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getActive(),
        ]);
    }

    public function getProductsPaginated(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getPaginatedList($request),
        ]);
    }

    public function getProductDetail($uuid)
    {
        return response()->json([
            'success' => true,
            'data' => ItemService::getDetail($uuid),
        ]);
    }

    public function getProductSearch(Request $request)
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        return response()->json([
            'success' => true,
            'data' => ItemService::getSearch($query, $limit),
        ]);
    }

    public function getBrands(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => BrandService::getActive($request),
        ]);
    }

    public function getBrandsPaginated(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => BrandService::getPaginated($request),
        ]);
    }

    public function getUnitsPaginated(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => UnitService::getPaginated($request),
        ]);
    }

    public function getRacksPaginated(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => RackService::getPaginated($request),
        ]);
    }

    public function getCategories(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => CategoryService::getActive($request),
        ]);
    }

    public function getSubcategories(Request $request, $categoryId = null)
    {
        if ($categoryId) {
            return response()->json([
                'success' => true,
                'data' => SubCategoryService::getByCategoryId($request, $categoryId),
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => SubCategoryService::getActive($request),
        ]);
    }

    public function getSubcategoriesPaginated(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => SubCategoryService::getPaginated($request),
        ]);
    }

    public function getSuppliers(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => SupplierService::getActive($request),
        ]);
    }

    public function getCustomers(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => CustomerService::getActive($request),
        ]);
    }

    public function getWarehouses(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => WarehouseService::getActive($request),
        ]);
    }

    public function getContacts(Request $request, $uuid)
    {
        return response()->json([
            'success' => true,
            'data' => ContactService::get($request, $uuid),
        ]);
    }

    public function getContactBySupplier(Request $request, $supplierUuid)
    {
        return response()->json([
            'success' => true,
            'data' => ContactService::get($request, $supplierUuid),
        ]);
    }

    public function getPaymentMethods(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => PaymentMethodService::getActive($request),
        ]);
    }

    public function getBankAccounts(Request $request)
    {
        $ownerType = $request->input('owner_type', 'store'); // default to store
        $ownerId = $request->input('owner_id', null);
        
        if ($ownerType === 'store') {
            $data = BankAccountService::getStoreAccounts();
        } elseif ($ownerType === 'supplier') {
            $data = BankAccountService::getSupplierAccounts($ownerId);
        } else {
            $data = BankAccountService::getActive($request);
        }
        
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function addOrder(Request $request)
    {
        try {
            return OrderService::createOrder($request);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function addSales(Request $request)
    {
        try {
            return SalesService::createSale($request);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createBankAccount(Request $request)
    {
        try {
            $validated = $request->validate([
                'bank_id' => 'required|integer|exists:banks,id',
                'owner_type' => 'required|string|in:store,supplier',
                'owner_id' => 'nullable|integer',
                'account_number' => 'required|string|max:50',
                'account_name' => 'required|string|max:100',
                'branch' => 'nullable|string|max:255',
                'status' => 'nullable|integer|in:0,1',
            ]);

            $bankAccount = \App\Models\BankAccount::create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'bank_id' => $validated['bank_id'],
                'owner_type' => $validated['owner_type'],
                'owner_id' => $validated['owner_id'] ?? null,
                'account_number' => $validated['account_number'],
                'account_name' => $validated['account_name'],
                'branch' => $validated['branch'] ?? null,
                'status' => $validated['status'] ?? 0,
                'created_by' => auth()->check() ? auth()->user()->username : 'system',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bank account created successfully',
                'data' => $bankAccount->load('bank'),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getBanks(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => \App\Models\Bank::where('status', 0)->orderBy('name', 'asc')->get(),
        ]);
    }

    public function deleteOrder($uuid)
    {
        try {
            $order = \App\Models\Order::where('uuid', $uuid)->firstOrFail();
            
            // Delete related order items first
            \App\Models\OrderItem::where('order_id', $order->id)->delete();
            
            // Delete the order
            $order->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}