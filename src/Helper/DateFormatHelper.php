<?php

namespace MrIncognito\DateConverter\Helper;

use RuntimeException;

class DateFormatHelper
{
    /**
     * Formats a given date string into the specified format.
     *
     * @param  string  $date  The date string (expected in YYYY-MM-DD format).
     * @param  string  $format  The desired output format (e.g., 'Y-m-d', 'd/m/Y').
     *
     * @throws RuntimeException If the date format is invalid.
     */
    public static function formatDateString(string $date, string $format): string
    {
        $parts = explode('-', $date);

        if (count($parts) !== 3) {
            throw new RuntimeException("Invalid date format: $date. Expected YYYY-MM-DD.");
        }

        [$year, $month, $day] = $parts;

        if (! ctype_digit($year) || ! ctype_digit($month) || ! ctype_digit($day)) {
            throw new RuntimeException("Invalid date components: $date.");
        }

        $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        $day = str_pad($day, 2, '0', STR_PAD_LEFT);

        return str_replace(['Y', 'm', 'd'], [$year, $month, $day], $format);
    }

    public static function arrayToDateString(array $dateData): string
    {
        return $dateData['year'].'-'.$dateData['month'].'-'.$dateData['day'];
    }
}
