<?php
namespace App\Services;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;

class BankService
{

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $banks = Bank::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($banks as $bank) {
            $bank->availability = $bank->isAvailable();
        }
        return $banks;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', 'index'); 
        $sortDirection = $request->input('sortDirection', 'desc'); 
        $validSortByFields = ['index'];
        if (!in_array($sortBy, $validSortByFields)) {
            $sortBy = 'index';
        }

        $banks = Bank::where('status', 0)
                    ->orderBy($sortBy, $sortDirection)
                    ->paginate($perPage);
        foreach ($banks as $bank) {
            $bank->availability = $bank->isAvailable();
        }

        return $banks;
    }


    public static function save(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = $request->has('status') ? 0 : 1;
            $bank          = Bank::whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($data['code']) . '%'])->get();

            if ($bank->isNotEmpty()) {
                $firstBank = $bank->first();
                throw new AlreadyExistException("code : {$firstBank->code}");
            }

            $bank = new Bank();
            // $supplier->validateAttributes($data);
            $bank->fill($data);
            $bank->save();

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
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

            $bank = Bank::find($data['id']);
            if (! $bank) {
                throw new NotFoundException("code : " . $data['code']);
            }
            // $category->validateAttributes($data);
            $bank->fill($data);
            $bank->update();

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

    public static function delete($id)
    {
        try {
            $bank = Bank::find($id);
            if (! $bank) {
                throw new NotFoundException("id : " . $id);
            }
            $bank->status = 1;
            $bank->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Warehouse not found: ' . $e->getMessage(),
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
