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
        $resolver = new DayResolver($this->getClock());
        $this->doTestResolve($resolver, $query, $expected);
    }

    public function providerResolve(): array
    {
        // assume FrozenClock date 2020-07-10

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
                    'start' => '2020-07-10 00:00:00',
                    'end' => '2020-07-10 23:59:59',
                ]
            ],
            'yesterday' => [
                'yesterday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-09 00:00:00',
                    'end' => '2020-07-09 23:59:59',
                ]
            ],
            'tomorrow' => [
                'tomorrow',
                [
                    'result' => Result::class,
                    'start' => '2020-07-11 00:00:00',
                    'end' => '2020-07-11 23:59:59',
                ]
            ],
            'next-monday' => [
                'next-monday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-13 00:00:00',
                    'end' => '2020-07-13 23:59:59',
                ]
            ],
            'next-tuesday' => [
                'next-tuesday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-14 00:00:00',
                    'end' => '2020-07-14 23:59:59',
                ]
            ],
            'next-wednesday' => [
                'next-wednesday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-15 00:00:00',
                    'end' => '2020-07-15 23:59:59',
                ]
            ],
            'next-thursday' => [
                'next-thursday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-16 00:00:00',
                    'end' => '2020-07-16 23:59:59',
                ]
            ],
            'next-friday' => [
                'next-friday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-17 00:00:00',
                    'end' => '2020-07-17 23:59:59',
                ]
            ],
            'next-saturday' => [
                'next-saturday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-11 00:00:00',
                    'end' => '2020-07-11 23:59:59',
                ]
            ],
            'next-sunday' => [
                'next-sunday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-12 00:00:00',
                    'end' => '2020-07-12 23:59:59',
                ]
            ],
            'last-monday' => [
                'last-monday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-06 00:00:00',
                    'end' => '2020-07-06 23:59:59',
                ]
            ],
            'last-tuesday' => [
                'last-tuesday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-07 00:00:00',
                    'end' => '2020-07-07 23:59:59',
                ]
            ],
            'last-wednesday' => [
                'last-wednesday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-08 00:00:00',
                    'end' => '2020-07-08 23:59:59',
                ]
            ],
            'last-thursday' => [
                'last-thursday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-09 00:00:00',
                    'end' => '2020-07-09 23:59:59',
                ]
            ],
            'last-friday' => [
                'last-friday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-03 00:00:00',
                    'end' => '2020-07-03 23:59:59',
                ]
            ],
            'last-saturday' => [
                'last-saturday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-04 00:00:00',
                    'end' => '2020-07-04 23:59:59',
                ]
            ],
            'last-sunday' => [
                'last-sunday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-05 00:00:00',
                    'end' => '2020-07-05 23:59:59',
                ]
            ],
            'last-sunday-uppercase' => [
                'LAST-SUNDAY',
                [
                    'result' => Result::class,
                    'start' => '2020-07-05 00:00:00',
                    'end' => '2020-07-05 23:59:59',
                ]
            ],
            'last-sunday-with-whitespace' => [
                'last sunday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-05 00:00:00',
                    'end' => '2020-07-05 23:59:59',
                ]
            ],
            'last-sunday-with-fxxxing' => [
                'last fxxxing sunday',
                [
                    'result' => Result::class,
                    'start' => '2020-07-05 00:00:00',
                    'end' => '2020-07-05 23:59:59',
                ]
            ],
        ];
    }
}
