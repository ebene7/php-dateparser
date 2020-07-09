<?php

namespace E7\Tests\DateParser;

use DateTime;
use E7\DateParser\DateParser;
use E7\DateParser\Result;
use PHPUnit\Framework\TestCase;

class DateParserTest extends TestCase
{
    /**
     * @dataProvider providerParse
     */
    public function testParse(string $query, array $expected)
    {
        $parser = DateParser::create();
        $result = $parser->parse($query);
        
        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals($expected['start'], $result->getStart()->format('Y-m-d H:i:s'));
        $this->assertEquals($expected['end'], $result->getEnd()->format('Y-m-d H:i:s'));
    }
    
    public function providerParse(): array
    {
        $today = new DateTime();
        
        return [
            'week-of-year-range' => [
                'w20-2020..w25-2020',
                [
                    'start' => '2020-05-11 00:00:00',
                    'end' => '2020-06-21 23:59:59',
                ]
            ],
            'only-year-range' => [
                '2020..2021',
                [
                    'start' => '2020-01-01 00:00:00',
                    'end' => '2021-12-31 23:59:59',
                ]
            ],
            'year-month-range' => [
                '2020-02..2020-05',
                [
                    'start' => '2020-02-01 00:00:00',
                    'end' => '2020-05-31 23:59:59',
                ]
            ],
            'full-date-range' => [
                '2020-02-15..2020-05-15',
                [
                    'start' => '2020-02-15 00:00:00',
                    'end' => '2020-05-15 23:59:59',
                ]
            ],
            'twisted-month-range' => [
                '2020-10..2020-05',
                [
                    'start' => '2020-05-01 00:00:00',
                    'end' => '2020-10-31 23:59:59',
                ]
            ],            
        ];
    }
}
