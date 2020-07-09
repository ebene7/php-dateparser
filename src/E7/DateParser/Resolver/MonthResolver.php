<?php

namespace E7\DateParser\Resolver;

use E7\DateParser\Result;
use DateTime;

class MonthResolver extends AbstractResolver
{
    public function getName(): string
    {
        return 'month';
    }

    public function resolve(string $query): ?Result
    {
        $query = $this->prepare($query);

        // resolve month: 2020-02
        if (!preg_match('=^(?P<year>\d{4})-(?P<month>\d{1,2})$=', $query, $match)) {
            return null;
        }

        $start = new DateTime($match['year'] . '-' . $match['month'] . '-01 00:00:00');
        $end = new DateTime($match['year'] . '-' . $match['month'] . '-' . $start->format('t') . ' 23:59:59');
        return Result::create($query, $start, $end);
    }

    protected function prepare(string $query): string
    {
        switch (strtolower($query)) {
            case 'month':
                return (new DateTime())->format('Y-m');
            case 'lastmonth';
                return (new DateTime())->modify('-1 month')->format('Y-m');
            default:
                return $query;
        }
    }
}
