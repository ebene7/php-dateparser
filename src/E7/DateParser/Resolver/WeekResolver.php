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
        $init = null;

        if (preg_match('=w(?P<week>\d{1,2})\-(?P<year>\d{4})=', $query, $match)) {
            $init = new DateTime();
            $init = $init->setISODate($match['year'], $match['week']);
        } else {
            switch (strtolower($query)) {
                case 'week':
                    $init = $this->getClock()->now();
                    break;
                case 'lastweek':
                    $init = $this->getClock()->now();
                    $init = $init->modify('-1 week');
                    break;
                case 'nextweek':
                    $init = $this->getClock()->now();
                    $init = $init->modify('+1 week');
                    break;
                default:
                    return $query;
            }
        }

        if (null === $init) {
            return null;
        }

        if (1 != $init->format('w')) {
            $init = $init->modify('last monday');
        }

        $start = clone $init;
        $start = $start->setTime(0, 0, 0);

        $end = clone $init;
        $end = $end->modify('+6 days');
        $end = $end->setTime(23, 59, 59);

        return Result::create($query, $start, $end);
    }

    protected function prepare(string $query): string
    {
        switch (strtolower($query)) {
            case 'week':
                return 'w' . (new DateTime())->format('W-Y');
            case 'lastweek':
                return 'w' . (new DateTime())->modify('-1 week')->format('W-Y');
            case 'nextweek':
                return 'w' . (new DateTime())->modify('+1 week')->format('W-Y');
            default:
                return $query;
        }
    }
}
