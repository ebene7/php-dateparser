<?php

namespace E7\Tests\DateParser\Resolver;

use DateTime;
use E7\DateParser\Resolver\MonthResolver;
use E7\DateParser\Result;

class MonthResolverTest extends ResolverTestCase
{
    /**
     * @dataProvider providerSupports
     */
    public function testSupports(string $query, bool $supports)
    {
        $resolver = new MonthResolver();
        $this->assertEquals($supports, $resolver->supports($query));
    }
    
    public function providerSupports(): array
    {
        return [
            [
                '2020-02',
                true,
            ],
            [
                '2020',
                false,
            ]
        ];
    }

    /**
     * @dataProvider providerResolve
     */
    public function testResolve(string $query, array $expected)
    {
        $resolver = new MonthResolver($this->getClock());
        $this->doTestResolve($resolver, $query, $expected);
    }

    public function providerResolve(): array
    {
        // assume FrozenClock date 2020-07-10

        return [
            'date-string' => [
                '2020-07',
                [
                    'result' => Result::class,
                    'start' => '2020-07-01 00:00:00',
                    'end' => '2020-07-31 23:59:59',
                ]
            ],
            'month' => [
                'month',
                [
                    'result' => Result::class,
                    'start' => '2020-07-01 00:00:00',
                    'end' => '2020-07-31 23:59:59',
                ]
            ],
            'lastmonth' => [
                'lastmonth',
                [
                    'result' => Result::class,
                    'start' => '2020-06-01 00:00:00',
                    'end' => '2020-06-30 23:59:59',
                ]
            ],
            'nextmonth' => [
                'nextmonth',
                [
                    'result' => Result::class,
                    'start' => '2020-08-01 00:00:00',
                    'end' => '2020-08-31 23:59:59',
                ]
            ],
        ];
    }
}
