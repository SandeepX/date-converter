<?php

namespace MrIncognito\DateConverter\Traits;

use InvalidArgumentException;
use MrIncognito\DateConverter\Constants\CalenderData;
use MrIncognito\DateConverter\Enum\DayTypeEnum;
use MrIncognito\DateConverter\Helper\DateFormatHelper;
use MrIncognito\DateConverter\Helper\DateValidationHelper;
use RuntimeException;

trait DateConvertorTrait
{
    /**
     * currently can only calculate the date between AD 1944-2033...
     */
    public function toNepaliDate(int $yy, int $mm, int $dd): array
    {
        $checkDateRange = DateValidationHelper::isInRangeEng($yy, $mm, $dd);

        if (! $checkDateRange) {
            throw new InvalidArgumentException('Invalid date range');
        }

        $month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $leapMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        $def_eyy = 1944; // initial english date.
        $def_nyy = 2000; // initial nepali date
        $def_nmm = 9;
        $def_ndd = 17 - 1; // initial nepali date.
        $total_eDays = 0;
        $day = 7 - 1;

        for ($i = 0; $i < ($yy - $def_eyy); $i++) {
            if ($this->isLeapYear($def_eyy + $i) === true) {
                for ($j = 0; $j < 12; $j++) {
                    $total_eDays += $leapMonth[$j];
                }
            } else {
                for ($j = 0; $j < 12; $j++) {
                    $total_eDays += $month[$j];
                }
            }
        }

        for ($i = 0; $i < ($mm - 1); $i++) {
            if ($this->isLeapYear($yy) === true) {
                $total_eDays += $leapMonth[$i];
            } else {
                $total_eDays += $month[$i];
            }
        }

        $total_eDays += $dd;

        $i = 0;
        $j = $def_nmm;
        $total_nDays = $def_ndd;
        $m = $def_nmm;
        $y = $def_nyy;

        while ($total_eDays !== 0) {
            $a = CalenderData::NEPALI_DATE[$i][$j];

            $total_nDays++;
            $day++;

            if ($total_nDays > $a) {
                $m++;
                $total_nDays = 1;
                $j++;
            }

            if ($day > 7) {
                $day = 1;
            }

            if ($m > 12) {
                $y++;
                $m = 1;
            }

            if ($j > 12) {
                $j = 1;
                $i++;
            }

            $total_eDays--;
        }

        return [
            'year' => $y,
            'month' => $m,
            'day' => $total_nDays,
            'week_day' => $this->dayOfTheWeek($day, DayTypeEnum::BS->value),
            'month_name' => $this->month($m, DayTypeEnum::BS->value),
            'num_week_day' => $day,
        ];
    }

    /**
     * Calculates whether english year is leap year or not
     */
    public function isLeapYear(int $year): bool
    {
        return ($year % 100 === 0) ? ($year % 400 === 0) : ($year % 4 === 0);
    }

    /**
     * Currently can only calculate the date between BS 2000-2089
     */
    public function toEnglishDate($yy, $mm, $dd): array
    {
        $def_eyy = 1943;
        $def_emm = 4;
        $def_edd = 14 - 1;
        $def_nyy = 2000;
        $total_nDays = 0;
        $day = 4 - 1;
        $k = 0;

        $month = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        $leapMonth = [0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        $checkDateRange = DateValidationHelper::isInRangeNep($yy, $mm, $dd);

        if (! $checkDateRange) {
            throw new RuntimeException('Date out of range');
        }

        // Count total days in-terms of year
        for ($i = 0; $i < ($yy - $def_nyy); $i++) {
            for ($j = 1; $j <= 12; $j++) {
                $total_nDays += CalenderData::NEPALI_DATE[$k][$j];
            }
            $k++;
        }

        // Count total days in-terms of month
        for ($j = 1; $j < $mm; $j++) {
            $total_nDays += CalenderData::NEPALI_DATE[$k][$j];
        }

        // Count total days in-terms of date
        $total_nDays += $dd;

        // Calculation of equivalent english date...
        $total_eDays = $def_edd;
        $m = $def_emm;
        $y = $def_eyy;
        while ($total_nDays !== 0) {
            if ($this->isLeapYear($y)) {
                $a = $leapMonth[$m];
            } else {
                $a = $month[$m];
            }

            $total_eDays++;
            $day++;

            if ($total_eDays > $a) {
                $m++;
                $total_eDays = 1;
                if ($m > 12) {
                    $y++;
                    $m = 1;
                }
            }

            if ($day > 7) {
                $day = 1;
            }

            $total_nDays--;
        }

        return [
            'year' => $y,
            'month' => $m,
            'day' => $total_eDays,
            'week_day' => $this->dayOfTheWeek($day, DayTypeEnum::AD->value),
            'month_name' => $this->month($m, DayTypeEnum::AD->value),
            'num_week_day' => $day,
        ];
    }

    public function getDayMonthYearFromDate($date): array
    {
        $formattedDate = DateFormatHelper::formatDateString($date, 'Y-m-d');

        $parts = explode('-', $formattedDate);

        if (count($parts) !== 3) {
            throw new RuntimeException("Invalid date format: $formattedDate");
        }

        return [
            'year' => (int) $parts[0],
            'month' => (int) $parts[1],
            'day' => (int) $parts[2],
        ];
    }

    /**
     * Returns the day of the week in the specified language.
     *
     * @param  int  $day  The day number (1-7).
     * @return string The name of the day.
     *
     * @throws RuntimeException If the day is invalid.
     */
    public function dayOfTheWeek(int $day, string $type): string
    {
        $days = [
            DayTypeEnum::AD->value => CalenderData::AD_WEEK_DAYS,
            DayTypeEnum::BS->value => CalenderData::BS_WEEK_DAYS,
        ];

        if (! in_array($type, [DayTypeEnum::AD->value, DayTypeEnum::BS->value], true)) {
            throw new RuntimeException("Invalid {$type}");
        }

        return $days[$type][$day - 1] ?? throw new RuntimeException('Invalid Day');
    }

    /**
     * @param  string  $type  'ad' for English, 'bs' for Nepali
     */
    public function month(int $m, string $type): string
    {
        $months = [
            DayTypeEnum::AD->value => CalenderData::AD_MONTHS,
            DayTypeEnum::BS->value => CalenderData::BS_MONTHS,
        ];

        if ($m < 1 || $m > 12) {
            throw new RuntimeException('Invalid Month');
        }

        if (! isset($months[$type][$m])) {
            throw new RuntimeException("Invalid $type Month");
        }

        return $months[$type][$m];
    }

    public function getCalendarYearIndex($year): bool|int
    {
        $calendarData = CalenderData::NEPALI_DATE;

        return collect($calendarData)->search(fn ($data) => $data[0] === (int) $year);
    }
}
