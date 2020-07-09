<?php

namespace E7\Tests\DateParser\Resolver;

use E7\DateParser\Resolver\ResolverInterface;
use PHPUnit\Framework\TestCase;

abstract class ResolverTestCase extends TestCase
{
    protected function doTestResolve(ResolverInterface $resolver, string $query, array $expected)
    {
        $result = $resolver->resolve($query);
        
        if ($expected['result']) {
            $this->assertInstanceOf($expected['result'], $result);
            $this->assertEquals($expected['start'], $result->getStart()->format('Y-m-d H:i:s'));
            $this->assertEquals($expected['end'], $result->getEnd()->format('Y-m-d H:i:s'));
        } else {
            $this->assertNull($result);
        }
    }
}
