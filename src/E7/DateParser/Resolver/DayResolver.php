<?php

namespace E7\DateParser\Resolver;

use E7\DateParser\Result;
use DateTime;

class DayResolver extends AbstractResolver
{
    const DAYS = [
        'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
    ];

    public function getName(): string
    {
        return 'day';
    }

    public function resolve(string $query): ?Result
    {
        $init = null;

        if (preg_match('=^(?P<year>\d{4})-(?P<month>\d{1,2})-(?P<day>\d{1,2})$=', $query, $match)) {
            $init = new DateTime($match['year'] . '-' . $match['month'] . '-' . $match['day']);
        } else if (preg_match('=^(?P<direction>last|next)(.*)(?P<day>' . implode('|', self::DAYS) . ')=i', $query, $match)) {
            $init = $this->getClock()->now();
            $init = $init->modify($match['direction'] . ' ' . $match['day']);
        } else {
            switch (strtolower($query)) {
                case 'today':
                case 'now':
                    $init = $this->getClock()->now();
                    break;
                case 'yesterday';
                    $init = $this->getClock()->now();
                    $init = $init->modify('-1 days');
                    break;
                case 'tomorrow';
                    $init = $this->getClock()->now();
                    $init = $init->modify('+1 days');
                    break;
                default:
                    break;
            }
        }

        if (null === $init) {
            return null;
        }

        $start = clone $init;
        $start = $start->setTime(0, 0, 0);

        $end = clone $init;
        $end = $end->setTime(23, 59, 59);

        return Result::create($query, $start, $end);
    }
}
