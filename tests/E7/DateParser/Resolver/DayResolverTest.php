<?php

namespace E7\Tests\DateParser\Resolver;

use DateTime;
use E7\DateParser\Resolver\DayResolver;
use E7\DateParser\Result;

class DayResolverTest extends ResolverTestCase
{
    /**
     * @dataProvider providerSupports
     */
    public function testSupports(string $query, bool $supports)
    {
        $resolver = new DayResolver();
        $this->assertEquals($supports, $resolver->supports($query));
    }
    
    public function providerSupports(): array
    {
        return [
            [
                '2020-05-29',
                true,
            ],
            [
                '2020',
                false,
            ],
            [
                '2020-05',
                false,
            ],
        ];
    }
    
    /**
     * @dataProvider providerResolve
     */
    public function testResolve(string $query, array $expected)
    {
        $this->doTestResolve(new DayResolver(), $query, $expected);
    }

    public function providerResolve(): array
    {
        return [
            'date-string' => [
                '2020-07-09',
                [
                    'result' => Result::class,
                    'start' => '2020-07-09 00:00:00',
                    'end' => '2020-07-09 23:59:59',
                ]
            ],
            'today' => [
                'today',
                [
                    'result' => Result::class,
                    'start' => (new DateTime())->format('Y-m-d 00:00:00'),
                    'end' => (new DateTime())->format('Y-m-d 23:59:59'),
                ]
            ],
            'yesterday' => [
                'yesterday',
                [
                    'result' => Result::class,
                    'start' => (new DateTime())->modify('-1 days')->format('Y-m-d 00:00:00'),
                    'end' => (new DateTime())->modify('-1 days')->format('Y-m-d 23:59:59'),
                ]
            ],
        ];
    }
}
