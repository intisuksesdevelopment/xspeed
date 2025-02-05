<?php
namespace App\Services;

use App\Constants\CommonConstants;

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
        foreach ($units as $unit) {
            $unit->availability = $unit->isAvailable();
        }
        return $units;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        $units = Unit::where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($units as $unit) {
            $unit->availability = $unit->isAvailable();
        }
        return $units;
    }
}