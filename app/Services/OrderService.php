<?php
namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Constants\CommonConstants;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;

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
}