<?php

namespace E7\DateParser\Resolver;

use E7\DateParser\Result;
use E7\Clock\ClockAwareTrait;
use E7\Clock\ClockInterface;

abstract class AbstractResolver implements ResolverInterface
{
    use ClockAwareTrait;

    public function __construct(ClockInterface $clock = null)
    {
        $this->setClock($clock);
    }

    public function getPriority(): int
    {
        return 50;
    }

    public function supports(string $query): bool
    {
        return $this->resolve($query) instanceof Result;
    }
}
