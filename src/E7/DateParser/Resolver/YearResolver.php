<?php

namespace E7\DateParser\Resolver;

use E7\DateParser\Result;
use DateTime;

class YearResolver extends AbstractResolver
{
    public function getName(): string
    {
        return 'year';
    }

    public function resolve(string $query): ?Result
    {
        $query = $this->prepare($query);

        // resolve year: 2020
        if (!preg_match('=^(?P<year>\d{4})$=', $query, $match)) {
            return null;
        }
        
        $start = new DateTime($match['year'] . '-01-01 00:00:00');
        $end = new DateTime($match['year'] . '-12-31 23:59:59');
        return Result::create($query, $start, $end);
    }

    protected function prepare(string $query): string
    {
        switch (strtolower($query)) {
            case 'year':
                return (new DateTime())->format('Y');
            case 'lastyear';
                return (new DateTime())->modify('-1 year')->format('Y');
            default:
                return $query;
        }
    }
}
