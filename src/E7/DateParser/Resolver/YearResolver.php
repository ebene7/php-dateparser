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
        $init = null;

        if (preg_match('=^(?P<year>\d{4})$=', $query, $match)) {
            $init = new DateTime($match['year'] . '-01-01');
        } else {
            switch (strtolower($query)) {
                case 'year':
                    $init = $this->getClock()->now();
                    break;
                case 'lastyear';
                    $init = $this->getClock()->now();
                    $init = $init->modify('-1 year');
                    break;
                case 'nextyear';
                    $init = $this->getClock()->now();
                    $init = $init->modify('+1 year');
                    break;
                default:
                    break;
            }
        }

        if (null === $init) {
            return null;
        }

        $start = clone $init;
        $start = $start->setDate($start->format('Y'), 1, 1);
        $start = $start->setTime(0, 0, 0);

        $end = clone $init;
        $end = $end->setDate($end->format('Y'), 12, 31);
        $end = $end->setTime(23, 59, 59);

        return Result::create($query, $start, $end);
    }
}
