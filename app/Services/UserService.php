<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Validation\ValidationException;

class UserService
{
    public static function register(Request $request)
    {
        try {
            $data = $request->all();

            // Check if the user with the same nik already exists
            $user = User::whereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($data['nik']) . '%'])->first();
            if ($user) {
                throw new AlreadyExistException("nik : {$data['nik']}");
            }

            // Create a new user
            $user         = new User();
            $data['uuid'] = (string) Str::uuid();
            $user->validateAttributes($data);

            // Hash the password before saving
            $data['password'] = Hash::make($data['password']);

            $user->fill($data);
            $user->save();

            return response()->json(['success' => true, 'message' => 'Added successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->errors()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $users = User::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($users as $user) {
            $user->availability = $user->isAvailable();
        }
        return $users;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $users = User::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($users as $user) {
            $user->availability = $user->isAvailable();
        }
        return $warehusersouses;
    }

    public static function save(Request $request)
    {
        try {
            $data           = $request->all();
            $data['status'] = 3; //default status waiting (3)

            $user = User::whereRaw('LOWER(nik) LIKE ? OR LOWER(email) LIKE ?', [  
                '%' . strtolower($data['nik']) . '%',  
                '%' . strtolower($data['email']) . '%'  
            ])->first();  

            if ($user) {
                throw new AlreadyExistException("nik : {$data['nik']}");
            }

            // Create a new user
            $user         = new User();
            $data['uuid'] = (string) Str::uuid();
            $user->validateAttributes($data);

            // Hash the password before saving
            $data['password'] = Hash::make($data['password']);

            $user->fill($data);
            $user->save();
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
            $data['status'] = $request->has('status') ? 0 : 1;

            $user = User::find($data['uuid']);
            if (! $user) {
                throw new NotFoundException("uuid : " . $data['uuid']);
            }
            // $category->validateAttributes($data);
            $user->fill($data);
            $user->update();

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
            $user = User::find($id);
            if (! $user) {
                throw new NotFoundException("id : " . $id);
            }
            $user->status = 1;
            $user->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'User not found: ' . $e->getMessage(),
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
