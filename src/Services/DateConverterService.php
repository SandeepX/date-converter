<?php

namespace MrIncognito\DateConverter\Services;

use MrIncognito\DateConverter\Traits\DateConvertorTrait;
use Exception;
use RuntimeException;

class DateConverterService
{
    use DateConvertorTrait;

    /**
     * @param int $day
     * @return string
     *
     * Return day of the week
     */
    public function dayOfTheWeek(int $day): string
    {
        return match ($day) {
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday',
            default => throw new RuntimeException('Invalid Day'),
        };
    }

    /**
     * @param int $m
     * @return string
     *
     * Return English Month
     */
    public function englishMonth(int $m): string
    {
        return match ($m) {
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sept',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
            default => throw new RuntimeException('Invalid English Month'),
        };
    }


    /**
     * @param int $m
     * @return string
     */
    public function nepaliMonth(int $m): string
    {
        return match ($m) {
            1 => "वैशाख",
            2 => "ज्येष्ठ",
            3 => "आषाढ़",
            4 => "श्रावण",
            5 => "भाद्र",
            6 => "आश्विन",
            7 => "कार्तिक",
            8 => "मंसिर",
            9 => "पौष",
            10 => "माघ",
            11 => "फाल्गुण",
            12 => "चैत्र",
            default => throw new RuntimeException('Invalid Nepali Month'),
        };
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
    public function currentDateInBS(): string
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
    public function startAndEndBsDate(int $yy, int $mm): array|string
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
            if ($value[0] === $year) {
                return $value[$month] ?? 30;
            }
        }
        return 30;
    }

    /**
     * @return array|string
     */
    public function currentBSMonthAndYear(): array|string
    {
        try {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $nepaliDate = $this->engToNep($year, $month, $day);
            return [
                'year' => $nepaliDate['year'],
                'month' => $nepaliDate['month'],
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $yy
     * @return array|string
     */
    public function startAndEndBSDateOfYear(int $yy): array|string
    {
        try {
            $totalDaysInMonth = $this->totalDaysInBSMonth($yy, self::END_MONTH);
            $startDate = $this->nepToEng($yy, self::START_MONTH, self::START_DAY);
            $endDate = $this->nepToEng($yy, self::END_MONTH, $totalDaysInMonth);
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
            return $dateInAd['year'] . '-' . $dateInAd['english_month'] . '-' . $dateInAd['date'];
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
            return $dateInBs['year'] . '-' . $dateInBs['nepali_month'] . '-' . $dateInBs['date'];
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }


}