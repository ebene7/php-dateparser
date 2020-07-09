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
        $this->doTestResolve(new MonthResolver(), $query, $expected);
    }

    public function providerResolve(): array
    {
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
                    'start' => (new DateTime())->format('Y-m-01 00:00:00'),
                    'end' => (new DateTime())->format('Y-m-t 23:59:59'),
                ]
            ],
            'lastmonth' => [
                'lastmonth',
                [
                    'result' => Result::class,
                    'start' => (new DateTime())->modify('-1 month')->format('Y-m-01 00:00:00'),
                    'end' => (new DateTime())->modify('-1 month')->format('Y-m-t 23:59:59'),
                ]
            ],
        ];
    }
}
