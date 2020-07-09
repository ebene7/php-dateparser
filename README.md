# php-dateparser

Provides a simple parser for (date-)strings.

## Installation

```sh
composer require ebene7/php-dateparser
```

## Usage

### `DateParser`

```php
<?php

use E7\DateParser\DateParser;

// Setup by yourself
$parser = DateParser();
$parser->addResolver($resolver);

// or use factory method
$parser = DateParser::create();

$result = $parser->parse($query);

```

The Parser supports...

* Single patterns e.g. `2020-05`, depending on added Resolvers
* Pattern ranges e.g. `2020-05..2020-10`
* Autocorrection for twisted ranges e.g. `2020-10..2020-05`

### `DayResolver`

```php
<?php

use E7\DateParser\Resolver\DayResolver;

$resolver = new DayResolver();
$result = $resolver->resolve($query);
```

Supported patterns:

* `2020-05-15`
* `today`
* `yesterday`
* `tommorrow`
* `[next|last] <dayofweek>`

### `WeekResolver`

Supported patterns:

* `w05-2020`
* `week`
* `lastweek`
* `nextweek`

### `MonthResolver`

Supported patterns:

* `2020-05`
* `month`
* `lastmonth`
* `nextmonth`

### `YearResolver`

Supported patterns:

* `2020`
* `year`
* `lastyear`
* `nextyear`
