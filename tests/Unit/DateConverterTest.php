<?php

use MrIncognito\DateConverter\Enum\NepaliMonthEnum;
use MrIncognito\DateConverter\Services\DateConverterService;

test('current BS date returns a valid formatted string', function () {
    $dateConverterService = new DateConverterService;
    $bsDate = $dateConverterService->currentBsDate(format: 'Y-m-d');

    expect($bsDate)
        ->toBeString()
        ->and($bsDate)
        ->toMatch('/\d{4}-\d{2}-\d{2}/');
});

test('current BS date detail returns an array with year, month, and day', function () {
    $dateConverterService = new DateConverterService;
    $bsDateDetail = $dateConverterService->currentBsDateDetail();

    expect($bsDateDetail)
        ->toBeArray()
        ->and($bsDateDetail)
        ->toHaveKeys(['year', 'month', 'day', 'week_day', 'month_name', 'num_week_day']);
});

test('current AD date returns a valid formatted string', function () {
    $dateConverterService = new DateConverterService;
    $adDate = $dateConverterService->currentAdDate(format: 'Y-m-d');

    expect($adDate)
        ->toBeString()
        ->and($adDate)
        ->toMatch('/\d{4}-\d{2}-\d{2}/');
});

test('current AD date detail returns an array with year, month, day, and more', function () {
    $dateConverterService = new DateConverterService;
    $adDateDetail = $dateConverterService->currentAdDateDetail();

    expect($adDateDetail)
        ->toBeArray()
        ->and($adDateDetail)
        ->toHaveKeys(['year', 'month', 'day', 'week_day', 'month_name', 'num_week_day']);
});

test('start and end AD date from Nepali month returns valid dates', function () {
    $dateConverterService = new DateConverterService;
    $dates = $dateConverterService->startAndEndAdDateFromNepaliMonth(2082, NepaliMonthEnum::ASHADH->value, 'm-d-Y');

    $expectedStartDate = '06-15-2025';
    $expectedEndDate = '07-16-2025';

    expect($dates)->toBeArray()
        ->and($dates)->toHaveKeys(['start_date', 'end_date'])
        ->and($dates['start_date'])->toMatch('/\d{2}-\d{2}-\d{4}/')
        ->and($dates['end_date'])->toMatch('/\d{2}-\d{2}-\d{4}/')
        ->and($dates['start_date'])->toBe($expectedStartDate)
        ->and($dates['end_date'])->toBe($expectedEndDate);
});

test('total days in Nepali month returns a valid number of days', function () {
    $dateConverterService = new DateConverterService;
    $totalDays = $dateConverterService->totalDaysInNepaliMonth(2080, NepaliMonthEnum::BAISHAKH->value);

    expect($totalDays)->toBeInt()
        ->and($totalDays)->toBeGreaterThanOrEqual(28)
        ->and($totalDays)->toBeLessThanOrEqual(32);
});

test('start and end AD date from Nepali year returns valid dates', function () {
    $dateConverterService = new DateConverterService;
    $dates = $dateConverterService->startAndEndAdDateFromNepaliYear(year: 2081, format: 'm-d-Y');

    $expectedStartDate = '04-13-2024';
    $expectedEndDate = '04-13-2025';

    expect($dates)->toBeArray()
        ->and($dates)
        ->toHaveKeys(['start_date', 'end_date'])
        ->and($dates['start_date'])->toMatch('/\d{2}-\d{2}-\d{4}/')
        ->and($dates['end_date'])->toMatch('/\d{2}-\d{2}-\d{4}/')
        ->and($dates['start_date'])->toBe($expectedStartDate)
        ->and($dates['end_date'])->toBe($expectedEndDate);
});

test('converting from BS to AD returns a valid formatted string', function () {
    $dateConverterService = new DateConverterService;
    $adDate = $dateConverterService
        ->fromBsToAd('2082-03-16', 'm-d-Y');

    $expectedDate = '06-30-2025';

    expect($adDate)
        ->toBeString()
        ->and($adDate)->toMatch('/\d{2}-\d{2}-\d{4}/')
        ->and($adDate)->toBe($expectedDate);
});

test('converting from AD to BS returns a valid formatted string', function () {
    $dateConverterService = new DateConverterService;
    $bsDate = $dateConverterService->fromAdToBs('2025-3-12', 'm-d-Y');

    $expectedDate = '11-28-2081';

    expect($bsDate)
        ->toBeString()
        ->and($bsDate)->toMatch('/\d{2}-\d{2}-\d{4}/')
        ->and($bsDate)->toBe($expectedDate);
});

test('days in BS year returns a valid number of days', function () {
    $dateConverterService = new DateConverterService;
    $daysInYear = $dateConverterService->daysInBsYear(2080);

    expect($daysInYear)->toBeInt()
        ->and($daysInYear)->toBeGreaterThanOrEqual(365)
        ->and($daysInYear)->toBeLessThanOrEqual(366);
});

test('days in AD year returns a valid number of days', function () {
    $dateConverterService = new DateConverterService;
    $daysInYear = $dateConverterService->daysInAdYear(2023);

    expect($daysInYear)->toBeInt()
        ->and($daysInYear)->toBeGreaterThanOrEqual(365)
        ->and($daysInYear)->toBeLessThanOrEqual(366);
});

test('throws exception for invalid year in total days in Nepali month', function () {
    $dateConverterService = new DateConverterService;

    expect(fn () => $dateConverterService->totalDaysInNepaliMonth(1999, 1))
        ->toThrow(RuntimeException::class);
});

test('throws exception for invalid month in total days in Nepali month', function () {
    $dateConverterService = new DateConverterService;

    expect(fn () => $dateConverterService->totalDaysInNepaliMonth(2080, 13))
        ->toThrow(RuntimeException::class);
});
