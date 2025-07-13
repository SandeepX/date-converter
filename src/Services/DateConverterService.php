<?php

namespace MrIncognito\DateConverter\Services;

use DateTime;
use Exception;
use MrIncognito\DateConverter\Constants\CalenderData;
use MrIncognito\DateConverter\Helper\DateFormatHelper;
use MrIncognito\DateConverter\Traits\DateConvertorTrait;
use RuntimeException;

class DateConverterService
{
    use DateConvertorTrait;

    public function currentBsDate(string $format = 'Y-m-d'): string
    {
        try {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $nepaliDate = $this->toNepaliDate($year, $month, $day);

            return DateFormatHelper::formatDateString(DateFormatHelper::arrayToDateString($nepaliDate), format: $format);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function currentBsDateDetail(): array|string
    {
        try {
            $year = date('Y');
            $month = date('m');
            $day = date('d');

            return $this->toNepaliDate($year, $month, $day);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Returns the current date in English in the specified format.
     *
     * @param  string  $format  The date format (default: 'Y-m-d')
     * @return string The formatted English date
     */
    public function currentAdDate(string $format = 'Y-m-d'): string
    {
        try {
            return date($format);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function currentAdDateDetail(): array|string
    {
        try {
            $dateTime = new DateTime;

            return [
                'year' => (int) $dateTime->format('Y'),
                'month' => (int) $dateTime->format('n'),
                'day' => (int) $dateTime->format('j'),
                'week_day' => $dateTime->format('l'),
                'month_name' => $dateTime->format('M'),
                'num_week_day' => (int) $dateTime->format('N'),
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function startAndEndAdDateFromNepaliMonth(int $yy, int $mm, string $format = 'Y-m-d'): array|string
    {
        try {
            $totalDaysInMonth = $this->totalDaysInNepaliMonth($yy, $mm);
            $startDay = CalenderData::START_DAY;
            $endDay = $totalDaysInMonth;
            $startDate = $this->toEnglishDate($yy, $mm, $startDay);
            $endDate = $this->toEnglishDate($yy, $mm, $endDay);

            return [
                'start_date' => DateFormatHelper::formatDateString(DateFormatHelper::arrayToDateString($startDate), format: $format),
                'end_date' => DateFormatHelper::formatDateString(DateFormatHelper::arrayToDateString($endDate), format: $format),
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function totalDaysInNepaliMonth(int $year, int $month): int
    {
        if (! $year || $year < 2000 || $year > 2099) {
            throw new \RuntimeException('Year must be provided and cannot be zero or more than 2099 or less than 2000.');
        }

        if (! $month || $month < 1 || $month > 12) {
            throw new \RuntimeException('Month must be provided and must be in between 1 and 12.');
        }
        foreach (CalenderData::NEPALI_DATE as $value) {
            if ($value[0] === $year) {
                return $value[$month] ?? 30;
            }
        }

        return 30;
    }

    public function startAndEndAdDateFromNepaliYear(int $year, string $format = 'Y-m-d'): array|string
    {
        try {
            $totalDaysInMonth = $this->totalDaysInNepaliMonth($year, CalenderData::END_MONTH);
            $startDate = $this->toEnglishDate($year, CalenderData::START_MONTH, CalenderData::START_DAY);
            $endDate = $this->toEnglishDate($year, CalenderData::END_MONTH, $totalDaysInMonth);

            return [
                'start_date' => DateFormatHelper::formatDateString(DateFormatHelper::arrayToDateString($startDate), format: $format),
                'end_date' => DateFormatHelper::formatDateString(DateFormatHelper::arrayToDateString($endDate), format: $format),
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function fromBsToAd($date, string $format = 'Y-m-d'): string
    {
        try {
            $date = $this->getDayMonthYearFromDate($date);
            $dateInAd = $this->toEnglishDate($date['year'], $date['month'], $date['day']);

            return DateFormatHelper::formatDateString(DateFormatHelper::arrayToDateString($dateInAd), format: $format);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function fromAdToBs($date, string $format = 'Y-m-d'): string
    {
        try {
            $date = $this->getDayMonthYearFromDate($date);
            $dateInBs = $this->toNepaliDate($date['year'], $date['month'], $date['day']);

            return DateFormatHelper::formatDateString(DateFormatHelper::arrayToDateString($dateInBs), format: $format);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function daysInBsYear(int $year): float|int
    {
        $yearIndex = $this->getCalendarYearIndex($year);

        if ($yearIndex === false) {
            throw new RuntimeException('Year is out of range. Please provide a year between 2000-2090');
        }

        return array_sum(array_slice(CalenderData::NEPALI_DATE[$yearIndex], 1));
    }

    public function daysInAdYear(int $year): float|int
    {
        if ($year < 1943 || $year > 2043) {
            throw new RuntimeException('Year is out of range. Please provide a year between 1943-2043');
        }

        return ($year % 4 === 0 && $year % 100 !== 0) || ($year % 400 === 0) ? 366 : 365;
    }
}
