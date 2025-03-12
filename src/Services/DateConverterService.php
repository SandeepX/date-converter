<?php

namespace MrIncognito\DateConverter\Services;

use DayType;
use Exception;
use MrIncognito\DateConverter\Constants\CalenderData;
use MrIncognito\DateConverter\Helper\DateFormatHelper;
use MrIncognito\DateConverter\Traits\DateConvertorTrait;
use RuntimeException;

class DateConverterService
{
    use DateConvertorTrait;

    /**
     * Returns the day of the week in the specified language.
     *
     * @param int $day The day number (1-7).
     * @return string The name of the day.
     * @throws RuntimeException If the day is invalid.
     */
    public function dayOfTheWeek(int $day, string $type): string
    {
        $days = [
            DayType::AD->value => CalenderData::AD_WEEK_DAYS,
            DayType::BS->value => CalenderData::BS_WEEK_DAYS
        ];

        if (!in_array($type, [DayType::AD->value, DayType::BS->value], true)) {
            throw new RuntimeException("Invalid {$type}");
        }

        return $days[$type][$day - 1] ?? throw new RuntimeException('Invalid Day');
    }

    /**
     * @param int $m
     * @param string $type 'ad' for English, 'bs' for Nepali
     * @return string
     */
    public function month(int $m, string $type): string
    {
        $months = [
            DayType::AD->value => CalenderData::AD_MONTHS,
            DayType::BS->value => CalenderData::BS_MONTHS
        ];

        if ($m < 1 || $m > 12) {
            throw new RuntimeException("Invalid Month");
        }

        if (!isset($months[$type][$m])) {
            throw new RuntimeException("Invalid $type Month");
        }

        return $months[$type][$m];
    }

    /**
     * @param string $format
     * @return string
     */
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


    /**
     * @return array|string
     */
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
     * @param string $format The date format (default: 'Y-m-d')
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

    /**
     * @return array|string
     */
    public function currentAdDateDetail(): array|string
    {
        try {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            return $this->toEnglishDate($year, $month, $day);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * @param int $yy
     * @param int $mm
     * @param string $format
     * @return array|string
     */
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
                'end_date' => DateFormatHelper::formatDateString(DateFormatHelper::arrayToDateString($endDate), format: $format)
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param int $year
     * @param int $month
     * @return int
     */
    public function totalDaysInNepaliMonth(int $year, int $month): int
    {
        foreach (CalenderData::NEPALI_DATE as $value) {
            if ($value[0] === $year) {
                return $value[$month] ?? 30;
            }
        }
        return 30;
    }

    /**
     * @param int $year
     * @param string $format
     * @return array|string
     */
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

    /**
     * @param $date
     * @param string $format
     * @return string
     */
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

    /**
     * @param $date
     * @param string $format
     * @return string
     */
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
}
