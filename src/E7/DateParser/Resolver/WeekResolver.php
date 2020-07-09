<?php

namespace E7\DateParser\Resolver;

use E7\DateParser\Result;
use DateTime;

class WeekResolver extends AbstractResolver
{
    public function getName(): string
    {
        return 'week';
    }

    public function resolve(string $query): ?Result
    {
        $query = $this->prepare($query);

        // resolve week: w20-2020
        if (!preg_match('=w(?P<week>\d{1,2})\-(?P<year>\d{4})=', $query, $match)) {
            return null;
        }

        $start = new DateTime();
        $start->setISODate($match['year'], $match['week']);
        $start->setTime(0, 0, 0);

        $end = clone $start;
        $end->modify('+6 days');
        $end->setTime(23, 59, 59);

        return Result::create($query, $start, $end);
    }

    protected function prepare(string $query): string
    {
        switch (strtolower($query)) {
            case 'week':
                return 'w' . (new DateTime())->format('W-Y');
            case 'lastweek':
                return 'w' . (new DateTime())->modify('-1 week')->format('W-Y');
            default:
                return $query;
        }
    }
}
