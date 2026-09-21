<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Sale;
use App\Models\SaleData;
use App\Models\User;
use App\Services\CustomerService;
use App\Services\ItemService;
use App\Services\SupplierService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            'email' => 'required|email',
            'password' => 'required',
        ],
            [
                'email.required' => 'Email is required',
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

        return redirect('signin')->withErrors('These credentials do not match our records.');
    }

    public function registration()
    {
        return view('register');
    }

    public function customRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirmpassword' => 'required|min:6',
        ],
            [
                'name.required' => 'Userame is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
                'confirmpassword.required' => 'Confirm Password is required',

            ]
        );

        $data = $request->all();
        $check = $this->create($data);

        return redirect('signin')->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'confirmpassword' => Hash::make($data['confirmpassword']),
        ]);
    }

    public function adminDashboard(Request $request)
    {
        $data['countCustomer'] = CustomerService::countAll();
        $data['countSupplier'] = SupplierService::countAll();
        $itemRequest = new Request([
            'per_page' => 5,
            'sortBy' => 'created_at',
            'sortDirection' => 'desc',
            'page' => 1,
        ]);
        $data['dataNewProduct'] = ItemService::getPaginated($itemRequest);
        $data['dataMinStockProduct'] = ItemService::getWithMinStock();

        // Dashboard stats
        $data['totalPurchaseDue'] = \App\Models\Order::where('payment_status', 1)->sum('final_total') ?? 0;
        $data['totalSalesDue'] = \App\Models\Sale::where('payment_status', 1)->sum('payment_remaining') ?? 0;
        $data['totalSaleAmount'] = \App\Models\Sale::where('payment_status', 0)->sum('final_total') ?? 0;
        $data['totalExpenseAmount'] = \App\Models\Order::where('status', 0)->sum('final_total') ?? 0;
        $data['countPurchaseInvoice'] = \App\Models\Order::count();
        $data['countSalesInvoice'] = \App\Models\Sale::count();
        $data['currency'] = 'IDR';

        // Chart data - monthly sales and purchase for current year
        $currentYear = now()->year;
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $salesData = [];
        $purchaseData = [];
        for ($m = 1; $m <= 12; $m++) {
            $salesTotal = \App\Models\Sale::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $m)
                ->where('payment_status', 0)
                ->sum('final_total') ?? 0;
            $purchaseTotal = \App\Models\Order::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $m)
                ->sum('final_total') ?? 0;
            // Scale down for chart display (divide by 1000)
            $salesData[] = round($salesTotal / 1000, 1);
            $purchaseData[] = -round($purchaseTotal / 1000, 1);
        }
        $data['chartLabels'] = $months;
        $data['chartSalesData'] = $salesData;
        $data['chartPurchaseData'] = $purchaseData;
        $data['chartYear'] = $currentYear;

        // Minimalist Dashboard Data
        $filter = $request->input('filter', 'month'); // day, week, month
        $data['filter'] = $filter;

        // Date range based on filter (week starts on Sunday for Indonesia)
        $startDate = match($filter) {
            'day' => now()->startOfDay(),
            'week' => now()->startOfWeek(Carbon::SUNDAY),
            default => now()->startOfMonth(),
        };

        // Total Sales (paid only)
        $data['totalSales'] = \App\Models\Sale::where('payment_status', 0)
            ->where('created_at', '>=', $startDate)
            ->sum('final_total') ?? 0;

        // Total Transactions
        $data['totalTransactions'] = \App\Models\Sale::where('created_at', '>=', $startDate)->count();

        // Total Products
        $data['totalProducts'] = \App\Models\Item::count();

        // Low Stock Products (stock <= stock_min)
        $data['lowStockProducts'] = \App\Models\Item::whereColumn('stock', '<=', 'stock_min')->get();
        $data['lowStockCount'] = $data['lowStockProducts']->count();
        $data['urgentStockCount'] = $data['lowStockProducts']->where('stock', '<=', 0)->count();

        // Previous period for comparison
        $prevStartDate = match($filter) {
            'day' => now()->subDay()->startOfDay(),
            'week' => now()->subWeek()->startOfWeek(Carbon::SUNDAY),
            default => now()->subMonth()->startOfMonth(),
        };
        $prevEndDate = match($filter) {
            'day' => now()->subDay()->endOfDay(),
            'week' => now()->subWeek()->endOfWeek(Carbon::SUNDAY),
            default => now()->subMonth()->endOfMonth(),
        };
        $prevSales = \App\Models\Sale::where('payment_status', 0)
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->sum('final_total') ?? 0;

        // Sales change percentage
        if ($prevSales > 0) {
            $data['salesChange'] = round((($data['totalSales'] - $prevSales) / $prevSales) * 100, 1);
        } else {
            $data['salesChange'] = 0;
        }

        // Top Selling Products (based on sale_data)
        $topProducts = \App\Models\SaleData::selectRaw('item_id, SUM(item_unit) as total_qty, SUM(item_total) as total_sales')
            ->whereHas('sales', function ($query) use ($startDate) {
                $query->where('created_at', '>=', $startDate);
            })
            ->groupBy('item_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->with('item:id,name,image_url')
            ->get();
        $data['topProducts'] = $topProducts;

        // Recent Transactions
        $data['recentSales'] = \App\Models\Sale::with('buyer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Daily sales data for chart based on filter
        $chartDays = match($filter) {
            'day' => 7,
            'week' => 7,
            default => 30,
        };
        $chartData = [];
        for ($i = $chartDays - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $total = \App\Models\Sale::where('payment_status', 0)
                ->whereDate('created_at', $date)
                ->sum('final_total') ?? 0;
            $chartData[] = [
                'date' => $date->format('d M'),
                'total' => round($total / 1000, 1),
            ];
        }
        $data['chartData'] = $chartData;
        $data['chartDays'] = $chartDays;

        return view('pages.admin.admin-dashboard', $data);
    }

    public function salesDashboard()
    {
        $data['countCustomer'] = CustomerService::countAll();
        $data['countSupplier'] = SupplierService::countAll();
        $request = new Request([
            'per_page' => 5,
            'sortBy' => 'created_at',
            'sortDirection' => 'desc',
            'page' => 1,
        ]);
        $data['dataNewProduct'] = ItemService::getPaginated($request);
        $data['dataMinStockProduct'] = ItemService::getWithMinStock();

        return view('pages.admin.sales-dashboard', $data);
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('signin');
    }
}
