# Laravel Date Convertor 

A Laravel package to easily convert dates between AD (Anno Domini) and BS (Bikram Sambat) calendars.
The package provides a simple interface for converting dates from the Gregorian (AD) calendar to the Nepali (BS) calendar and vice versa.

## Installation

Follow the steps below to install the `mr.incognito/date-converter` package into your Laravel application.

### 1. Install via Composer

Run the following command to add the package to your Laravel project:

```bash
  composer require mr.incognito/date-converter --ignore-platform-reqs
```
 
## Usage

Once the package is installed, you can easily convert AD to BS and BS to AD in your application.

```php

$engDate = '2025-03-12';

$npDate = '2081-11-28';

$currentBsDate = DateConverter::currentBsDate('m-d-Y');;
// Result: '11-28-2081'

$currentBsDateDetailInArray = DateConverter::currentBsDateDetail();
// Result: [  "year" => 2081
              "month" => 11
              "day" => 28
              "week_day" => "बुधवार"
              "month_name" => "फाल्गुण"
              "num_week_day" => 4 ]

$currentAdDate = DateConverter::currentAdDate('m/d/Y');;
// Result: '03/12/2025'

$currentAdDateDetailInArray = DateConverter::currentAdDateDetail();
// Result: [  "year" => 2025
              "month" => 3
              "day" => 12
              "week_day" => "Wednesday"
              "month_name" => "Mar"
              "num_week_day" => 3 ]

$dateFromAdTBS = DateConverter::fromAdToBs('2025-3-12', 'm/d/Y');
// Result: '11/28/2081'

$dateFromBsToAd = DateConverter::fromBsToAd('2081-11-28', 'm-d-Y');
// Result: '03-12-2025'

// month can be NepaliMonthEnum::XXX->value or month number (1-12)

$totalDaysInNepaliMonth = DateConverter::totalDaysInNepaliMonth(2081, NepaliMonthEnum::FALGUN->value);
// Result: 29 

$startAndEndAdDateFromNepaliYear = DateConverter::startAndEndAdDateFromNepaliYear(2081, 'm-d-Y');
// Result: [
  "start_date" => "04-13-2024"
  "end_date" => "04-13-2025"
]

$startAndEndAdDateFromNepaliMonth = DateConverter::startAndEndAdDateFromNepaliMonth(2081, NepaliMonthEnum::FALGUN->value,'m-d-Y');
// Result: [
  "start_date" => "02-13-2025"
  "end_date" => "03-13-2025"
]

$totalDaysInBsYear = DateConverter::daysInBsYear(2080);
// Result: 365 
    
$totalDaysInADYear = DateConverter::daysInAdYear(2024);
// Result: 366 

```

## Format Specifiers

The following format specifiers are supported for formatting dates:

- `Y` - Year in four digits
- `m` - Month in two digits with leading zero (01-12)
- `d` - Day in two digits with leading zero (01-31)

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.


## Credits

- [SandeepPant](https://github.com/sandeepx)
- [All Contributors](../../contributors)

## License
This package is open-sourced software licensed under the MIT license.
