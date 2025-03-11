<?php

namespace MrIncognito\DateConverter\Services;

use MrIncognito\DateConverter\Traits\DateConvertorTrait;
use Exception;
use RuntimeException;

class DateConverterService
{
    use DateConvertorTrait;

    /**
     * Returns the day of the week in the specified language.
     *
     * @param int $day The day number (1-7).
     * @param string $type The language type ('ad' or 'bs').
     * @return string The name of the day.
     * @throws RuntimeException If the day is invalid.
     */
    public function dayOfTheWeek(int $day, string $type): string
    {
        $days = [
            self::TYPE['AD'] => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            self::TYPE['BS'] => ['आइतवार', 'सोमवार', 'मङ्गलवार', 'बुधवार', 'बिहिवार', 'शुक्रवार', 'शनिवार']
        ];

        if(!in_array($type, [self::TYPE['AD'], self::TYPE['BS']])) {
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
            self::TYPE['AD'] => [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
                7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
            ],
            self::TYPE['BS'] => [
                1 => 'वैशाख', 2 => 'ज्येष्ठ', 3 => 'आषाढ़', 4 => 'श्रावण', 5 => 'भाद्र',
                6 => 'आश्विन', 7 => 'कार्तिक', 8 => 'मंसिर', 9 => 'पौष', 10 => 'माघ',
                11 => 'फाल्गुण', 12 => 'चैत्र',
            ]
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
     * Calculates whether english year is leap year or not
     */
    public function isLeapYear(int $year): bool
    {
        return ($year % 4 === 0 && $year % 100 !== 0) || ($year % 400 === 0);
    }

    /**
     * @return string
     */
    public function currentYmdFormattedDateInBS(): string
    {
        try {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $nepaliDate = $this->engToNep($year, $month, $day);
            return $this->formatDate($nepaliDate);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $yy
     * @param int $mm
     * @return array|string
     */
    public function startAndEndAdDateFromBSYearAndMonth(int $yy, int $mm): array|string
    {
        try {
            $totalDaysInMonth = $this->totalDaysInBsMonth($yy, $mm);
            $startDay = self::START_DAY;
            $endDay = $totalDaysInMonth;
            $startDate = $this->nepToEng($yy, $mm, $startDay);
            $endDate = $this->nepToEng($yy, $mm, $endDay);
            return [
                'start_date' => $this->formatDate($startDate),
                'end_date' => $this->formatDate($endDate)
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
    public function totalDaysInBsMonth(int $year, int $month): int
    {
        foreach ($this->bs as $value) {
            if ($value[0] == $year) {
                return $value[$month] ?? 30;
            }
        }
        return 30;
    }

    /**
     * @return array|string
     */
    public function currentBSDate(): array|string
    {
        try {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            return $this->engToNep($year, $month, $day);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $yy
     * @return array|string
     */
    public function startAndEndAdDateFromBsYear(int $year): array|string
    {
        try {
            $totalDaysInMonth = $this->totalDaysInBSMonth($year, self::END_MONTH);
            $startDate = $this->nepToEng($year, self::START_MONTH, self::START_DAY);
            $endDate = $this->nepToEng($year, self::END_MONTH, $totalDaysInMonth);
            return [
                'start_date' => $this->formatDate($startDate),
                'end_date' => $this->formatDate($endDate),
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param $date
     * @return string
     */
    public function dateBsToAd($date): string
    {
        try {
            $date = $this->getDayMonthYearFromDate($date);
            $dateInAd = $this->nepToEng($date['year'], $date['month'], $date['day']);
            return $this->formatDate($dateInAd);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param $date
     * @return string
     */
    public function dateAdToBs($date): string
    {
        try {
            $date = $this->getDayMonthYearFromDate($date);
            $dateInBs = $this->EngToNep($date['year'], $date['month'], $date['day']);
            return $this->formatDate($dateInBs);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
