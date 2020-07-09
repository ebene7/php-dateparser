<?php

namespace E7\DateParser\Resolver;

use E7\DateParser\Result;
use DateTime;

class DayResolver extends AbstractResolver
{
    public function getName(): string
    {
        return 'day';
    }

    public function resolve(string $query): ?Result
    {
        $query = $this->prepare($query);

        // resolve day: 2020-06-15
        if (!preg_match('=^(?P<year>\d{4})-(?P<month>\d{1,2})-(?P<day>\d{1,2})$=', $query, $match)) {
            return null;
        }

        $start = new DateTime($match['year'] . '-' . $match['month'] . '-' . $match['day'] . ' 00:00:00');
        $end = new DateTime($match['year'] . '-' . $match['month'] . '-' . $match['day'] . ' 23:59:59');
        return Result::create($query, $start, $end);
    }

    protected function prepare(string $query): string
    {
        switch (strtolower($query)) {
            case 'today':
            case 'now':
                return (new DateTime())->format('Y-m-d');
            case 'yesterday';
                return (new DateTime())->modify('-1 days')->format('Y-m-d');
            default:
                return $query;
        }
    }
}
