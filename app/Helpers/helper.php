<?php

// app/helpers.php

if (!function_exists('clearDecimal')) {
    /**
     * Clear unnecessary decimal places
     *
     * @param float $value
     * @return string
     */
    function clearDecimal($value)
    {
        return number_format((float)$value, 2, '.', '');
    }
}
