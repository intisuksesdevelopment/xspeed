<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Config;
use Illuminate\Http\Request;
class ConfigService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);
        // Default to 'asc' if not provided
        $configs = Config::orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($configs as $config) {
            $config->availability = $config->isAvailable();
        }

        return $configs;
    }

    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', 'id');
        $sortDirection = $request->input('sortDirection', 'desc');
        $configs = Config::orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
        return $configs->pluck('value', 'code');;
    }
}
