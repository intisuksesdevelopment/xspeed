<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class UtilService
{
    /**
     * Clear unnecessary decimal places
     *
     * @param float $value
     * @return string
     */
    public static function clearDecimal($value)
    {
        return number_format((float) $value, 2, '.', '');
    }

    /**
     * Format currency
     *
     * @param float $value
     * @param string $currency
     * @return string
     */
    public static function formatCurrency($value, $currency = 'IDR')
    {
        return number_format((float) $value, 2, ',', '.') . ' ' . strtoupper($currency);
    }

    /**
     * Convert to IDR
     *
     * @param float $value
     * @param string|null $fromCurrency
     * @return string
     */
    public static function convertToIdr($value, $fromCurrency)
    {
        if ($fromCurrency == 'IDR' || $fromCurrency == null || $value == 0) {
            return self::clearDecimal($value);
        }

        $response = Http::get(env('EXCHANGE_RATE_API_URL') . env('EXCHANGE_RATE_API_KEY') . "/latest/{$fromCurrency}");

        $rate = $response->json()['conversion_rates']['IDR'] ?? null;

        if ($rate) {
            return self::formatCurrency($rate * $value);
        } else {
            throw new \Exception('Exchange rate not found');
        }
    }
    public static function clearNumberFormat($numberString)
    {
        // Remove dots as the thousands separator and replace the comma with a dot
        $cleanString = str_replace(['.', ','], ['', '.'], $numberString);

        // Convert to integer
        return intval($cleanString);
    }
    public static function formatDate($date)
    { //2025-01-13 08:03:14
        $formattedDate = date('Y-m-d H:i:s', strtotime($date));
        // Convert to string and format with thousands separator
        return $formattedDate;
    }
}
