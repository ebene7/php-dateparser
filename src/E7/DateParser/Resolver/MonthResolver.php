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
        $init = null;

        // resolve month: 2020-02
        if (preg_match('=^(?P<year>\d{4})-(?P<month>\d{1,2})$=', $query, $match)) {
            $init = new DateTime($match['year'] . '-' . $match['month']);
        }

        else {
            switch (strtolower($query)) {
                case 'month':
                    $init = $this->getClock()->now();
                    break;
                case 'lastmonth';
                    $init = $this->getClock()->now();
                    $init = $init->modify('-1 month');
                    break;
                case 'nextmonth';
                    $init = $this->getClock()->now();
                    $init = $init->modify('+1 month');
                    break;
                default:
                    break;
            }
        }

        if (null === $init) {
            return null;
        }

        $start = clone $init;
        $start = $start->setDate($start->format('Y'), $start->format('m'), 1);
        $start = $start->setTime(0, 0, 0);

        $end = clone $init;
        $end = $end->setDate($end->format('Y'), $end->format('m'), $end->format('t'));
        $end = $end->setTime(23, 59, 59);

        return Result::create($query, $start, $end);
    }
}
