<?php

namespace E7\Tests\DateParser\Resolver;

use DateTime;
use E7\DateParser\Resolver\YearResolver;
use E7\DateParser\Result;

class YearResolverTest extends ResolverTestCase
{
    /**
     * @dataProvider providerSupports
     */
    public function testSupports(string $query, bool $supports)
    {
        $resolver = new YearResolver();
        $this->assertEquals($supports, $resolver->supports($query));
    }
    
    public function providerSupports(): array
    {
        return [
            [
                '2020',
                true,
            ]
        ];
    }

    /**
     * @dataProvider providerResolve
     */
    public function testResolve(string $query, array $expected)
    {
        $this->doTestResolve(new YearResolver(), $query, $expected);
    }

    public function providerResolve(): array
    {
        // assume FrozenClock date 2020-07-10

        return [
            'year-string' => [
                '2020',
                [
                    'result' => Result::class,
                    'start' => '2020-01-01 00:00:00',
                    'end' => '2020-12-31 23:59:59',
                ]
            ],
            'year' => [
                'year',
                [
                    'result' => Result::class,
                    'start' => '2020-01-01 00:00:00',
                    'end' => '2020-12-31 23:59:59',
                ]
            ],
            'lastyear' => [
                'lastyear',
                [
                    'result' => Result::class,
                    'start' => '2019-01-01 00:00:00',
                    'end' => '2019-12-31 23:59:59',
                ]
            ],
            'nextyear' => [
                'nextyear',
                [
                    'result' => Result::class,
                    'start' => '2021-01-01 00:00:00',
                    'end' => '2021-12-31 23:59:59',
                ]
            ],
        ];
    }
}
