<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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

}
