<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Services\SupplierService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class CustomAuthController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index()
    {

        return view('signin');
    }

    public function customSignin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ],
            [
                'email.required'    => 'Email is required',
                'password.required' => 'Password is required',

            ]

        );
        $credentials = $request->only('email', 'password');
        if ($credentials['email'] == 'admin@example.com' && $credentials['password'] == '123456') {
            return redirect()->intended('index')
                ->withSuccess('Signed in');
        }
        if (Auth::attempt($credentials)) {
            return redirect()->intended('index')
                ->withSuccess('Signed in');
        }

        return redirect("signin")->withErrors('These credentials do not match our records.');
    }
    public function registration()
    {
        return view('register');
    }

    public function customRegister(Request $request)
    {
        $request->validate([
            'name'            => 'required|min:5',
            'email'           => 'required|email|unique:users',
            'password'        => 'required|min:6',
            'confirmpassword' => 'required|min:6',
        ],
            [
                'name.required'            => 'Userame is required',
                'email.required'           => 'Email is required',
                'password.required'        => 'Password is required',
                'confirmpassword.required' => 'Confirm Password is required',

            ]
        );

        $data  = $request->all();
        $check = $this->create($data);

        return redirect("signin")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'password'        => Hash::make($data['password']),
            'confirmpassword' => Hash::make($data['confirmpassword']),
        ]);
    }

    public function dashboard()
    {
        $data['countCustomer'] = CustomerService::countAll();
        $data['countSupplier'] = SupplierService::countAll();
        return view('pages.admin.index', $data);
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('signin');
    }
}
