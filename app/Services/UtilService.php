<?php
namespace App\Services;

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
        return number_format((float)$value, 2, '.', '');
    }
}
