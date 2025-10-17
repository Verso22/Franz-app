<?php
// app/Helpers/helpers.php
// Small helper functions for the app. Loaded automatically by Composer.

if (! function_exists('rupiah')) {
    /**
     * Format a number as Indonesian Rupiah.
     *
     * @param  int|float|null  $amount  The numeric amount to format.
     * @param  string $prefix Optional prefix (default 'Rp ').
     * @return string
     */
    function rupiah($amount, $prefix = 'Rp ')
    {
        // If amount is null or empty, return a dash to show "no data"
        if ($amount === null || $amount === '') {
            return '-';
        }

        // Ensure the value is numeric (if string like "15000" it will work)
        $number = floatval($amount);

        // number_format: no decimals, decimal separator ',', thousands separator '.'
        // Example: 15000 => "15.000"
        $formatted = number_format($number, 0, ',', '.');

        // Return with prefix: "Rp 15.000"
        return $prefix . $formatted;
    }
}
