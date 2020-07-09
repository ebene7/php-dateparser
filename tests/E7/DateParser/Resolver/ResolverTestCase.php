<?php

namespace E7\Tests\DateParser\Resolver;

use DateTimeImmutable;
use E7\Clock\ClockAwareTrait;
use E7\Clock\FrozenClock;
use E7\DateParser\Resolver\ResolverInterface;
use PHPUnit\Framework\TestCase;

abstract class ResolverTestCase extends TestCase
{
    use ClockAwareTrait;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->setClock(new FrozenClock(new DateTimeImmutable('2020-07-10')));
    }

    protected function doTestResolve(ResolverInterface $resolver, string $query, array $expected)
    {
        $result = $resolver->resolve($query);

        if ($expected['result']) {
            $this->assertInstanceOf($expected['result'], $result);

            $this->assertEquals(
                $expected['start'],
                $result->getStart()->format('Y-m-d H:i:s'),
                'Start-Date does not match'
            );

            $this->assertEquals(
                $expected['end'],
                $result->getEnd()->format('Y-m-d H:i:s'),
                'End-Date does not match'
            );
        } else {
            $this->assertNull($result);
        }
    }
}
