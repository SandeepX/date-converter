<?php

namespace MrIncognito\DateConverter\Traits;
use InvalidArgumentException;

trait DateConvertorTrait
{
    public array $bs = [
        [2000, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2001, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2002, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2003, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2004, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2005, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2006, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2007, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2008, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        [2009, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2010, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2011, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2012, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        [2013, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2014, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2015, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2016, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        [2017, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2018, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2019, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2020, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        [2021, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2022, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        [2023, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2024, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        [2025, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2026, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2027, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2028, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2029, 31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        [2030, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2031, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2032, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2033, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2034, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2035, 30, 32, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        [2036, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2037, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2038, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2039, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        [2040, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2041, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2042, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2043, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        [2044, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2045, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2046, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2047, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        [2048, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2049, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        [2050, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2051, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        [2052, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2053, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        [2054, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2055, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2056, 31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        [2057, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2058, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2059, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2060, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2061, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2062, 30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31],
        [2063, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2064, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2065, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2066, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        [2067, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2068, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2069, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2070, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        [2071, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2072, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        [2073, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        [2074, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        [2075, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2076, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        [2077, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        [2078, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        [2079, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        [2080, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        [2081, 31, 31, 32, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        [2082, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        [2083, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30],
        [2084, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30],
        [2085, 31, 32, 31, 32, 30, 31, 30, 30, 29, 30, 30, 30],
        [2086, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        [2087, 31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30],
        [2088, 30, 31, 32, 32, 30, 31, 30, 30, 29, 30, 30, 30],
        [2089, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        [2090, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30]
    ];

    public array $nepDate = [
        'year' => '',
        'month' => '',
        'date' => '',
        'day' => '',
        'nepali_month' => '',
        'num_day' => ''
    ];

    public array $engDate = [
        'year' => '',
        'month' => '',
        'date' => '',
        'day' => '',
        'english_month' => '',
        'num_day' => ''
    ];

    public const START_MONTH = 1;
    public const START_DAY = 1;
    public const END_MONTH = 12;

    /**
     * @param $date
     * @return string
     */
    public function formatDate($date): string
    {
        return $date['year'].'-'.$date['month'].'-'.$date['date'];
    }

    /**
     * @param int $yy
     * @param int $mm
     * @param int $dd
     * @return bool|string
     *
     * Check if the date range is valid for English dates.
     */
    public function isInRangeEng(int $yy, int $mm, int $dd): bool|string
    {
        try {
            if ($yy < 1944 || $yy > 2033) {
                throw new InvalidArgumentException('Supported only between 1944-2033');
            }

            if ($mm < 1 || $mm > 12) {
                throw new InvalidArgumentException('Error! month value can be between 1-12 only');
            }

            if ($dd < 1 || $dd > 31) {
                throw new InvalidArgumentException('Error! day value can be between 1-31 only');
            }

            return true;
        } catch (InvalidArgumentException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Check if date is with in nepali data range
     */
    public function isInRangeNep(int $yy, int $mm, int $dd): true|string
    {
        try{
            if ($yy < 2000 || $yy > 2089) {
                throw new InvalidArgumentException('Error! year value can be between 2000-2089 only');
            }

            if ($mm < 1 || $mm > 12) {
                throw new InvalidArgumentException('Error! month value can be between 1-12 only');
            }

            if ($dd < 1 || $dd > 32) {
                throw new InvalidArgumentException('Error! day value can be between 1-31 only');
            }

            return true;
        }catch(InvalidArgumentException $e){
            return $e->getMessage();
        }
    }

    /**
     * currently can only calculate the date between AD 1944-2033...
     */
    public function engToNep(int $yy, int $mm, int $dd): array
    {
        try{
            $checkDateRange = $this->isInRangeEng($yy, $mm, $dd);

            if(!$checkDateRange){
                throw new InvalidArgumentException('Invalid date range');
            }

            $month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
            $leapMonth = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

            $def_eyy = 1944; // initial english date.
            $def_nyy = 2000;
            $def_nmm = 9;
            $def_ndd = 17 - 1; // initial nepali date.
            $total_eDays = 0;
            $day = 7 - 1;

            for ($i = 0; $i < ($yy - $def_eyy); $i++) {
                if ($this->isLeapYear($def_eyy + $i) === TRUE) {
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
                if ($this->isLeapYear($yy) === TRUE) {
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
                $a = $this->bs[$i][$j];

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

            return $this->nepDate = [
                'year'    => $y,
                'month'   => $m,
                'date'    => $total_nDays,
                'day'     => $this->dayOfTheWeek($day),
                'nepali_month'  => $this->nepaliMonth($m),
                'num_day' => $day
            ];

        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Currently can only calculate the date between BS 2000-2089
     * @throws \Exception
     */
    public function nepToEng($yy, $mm, $dd): array
    {
        try{
            $def_eyy = 1943;
            $def_emm = 4;
            $def_edd = 14 - 1;
            $def_nyy = 2000;
            $total_nDays = 0;
            $day = 4 - 1;
            $k = 0;

            $month = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            $leapMonth = [0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            $checkDateRange = $this->isInRangeNep($yy, $mm, $dd);

            if(!$checkDateRange){
                throw new \RuntimeException('Date out of range');
            }

            // Count total days in-terms of year
            for ($i = 0; $i < ($yy - $def_nyy); $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $total_nDays += $this->bs[$k][$j];
                }
                $k++;
            }

            // Count total days in-terms of month
            for ($j = 1; $j < $mm; $j++) {
                $total_nDays += $this->bs[$k][$j];
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

            return $this->engDate = [
                'year'    => $y,
                'month'   => $m,
                'date'    => $total_nDays,
                'day'     => $this->dayOfTheWeek($day),
                'english_month'  => $this->englishMonth($m),
                'num_day' => $day
            ];

        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * @param $date
     * @return array
     */
    public function getDayMonthYearFromDate($date): array
    {
        $data['year'] = date('Y', strtotime($date));
        $data['month'] = date('n', strtotime($date));
        $data['day'] = date('d', strtotime($date));
        return $data;
    }
}