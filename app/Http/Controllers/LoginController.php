<?php
namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // Apply the guest middleware except for the logout method
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {

        return view('pages.auth.signin');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\W_]).+$/',
                    function ($attribute, $value, $fail) {
                        if (! preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\W_]).+$/', $value)) {
                            return $fail('The ' . $attribute . ' must be at least 8 characters long and include at least one letter, one number, and one special character.');
                        }
                    },
                ],
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // Retrieve the authenticated user
                $user = Auth::user();

                // Check if user status is 0
                if ($user->status === 0) {
                    $request->session()->regenerate();

                    return response()->json([
                        'success'      => true,
                        'message'      => 'Login successful!',
                        'redirect_url' => url('dashboard'),
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account is not active or waiting for approval.',
                    ], 403);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.',
            ], 401);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function registrationForm()
    {
        return view('pages.auth.register');
    }
    public function registration(Request $request)
    {
        return UserService::register($request);
    }
}
