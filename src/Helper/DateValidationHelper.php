<?php

namespace MrIncognito\DateConverter\Helper;

use InvalidArgumentException;

class DateValidationHelper
{
    /**
     * @param int $yy
     * @param int $mm
     * @param int $dd
     * @return bool|string
     *
     * Check if the date range is valid for English dates.
     */
    public static function isInRangeEng(int $yy, int $mm, int $dd): bool|string
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
            return $e;
        }
    }

    /**
     * Check if date is with in nepali data range
     */
    public static function isInRangeNep(int $yy, int $mm, int $dd): true|string
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
            return $e;
        }
    }


}