<?php

namespace E7\Tests\DateParser\Resolver;

use DateTime;
use E7\DateParser\Resolver\WeekResolver;
use E7\DateParser\Result;

class WeekResolverTest extends ResolverTestCase
{
    /**
     * @dataProvider providerSupports
     */
    public function testSupports(string $query, bool $supports)
    {
        $resolver = new WeekResolver();
        $this->assertEquals($supports, $resolver->supports($query));
    }
    
    public function providerSupports(): array
    {
        return [
            [
                'w10-2020',
                true,
            ],
        ];
    }
    
    /**
     * @dataProvider providerResolve
     */
    public function testResolve(string $query, array $expected)
    {
        $resolver = new WeekResolver($this->getClock());
        $this->doTestResolve($resolver, $query, $expected);
    }

    public function providerResolve(): array
    {
        // assume FrozenClock date 2020-07-10

        return [
            'string-week' => [
                'w28-2020',
                [
                    'result' => Result::class,
                    'start' => '2020-07-06 00:00:00',
                    'end' => '2020-07-12 23:59:59',
                ]
            ],
            'week' => [
                'week',
                [
                    'result' => Result::class,
                    'start' => '2020-07-06 00:00:00',
                    'end' => '2020-07-12 23:59:59',
                ]
            ],
            'lastweek' => [
                'lastweek',
                [
                    'result' => Result::class,
                    'start' => '2020-06-29 00:00:00',
                    'end' => '2020-07-05 23:59:59',
                ]
            ],
            'nextweek' => [
                'nextweek',
                [
                    'result' => Result::class,
                    'start' => '2020-07-13 00:00:00',
                    'end' => '2020-07-19 23:59:59',
                ]
            ],
        ];
    }
}
