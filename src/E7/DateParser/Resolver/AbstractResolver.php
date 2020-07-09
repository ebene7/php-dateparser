<?php

namespace E7\DateParser\Resolver;

use E7\DateParser\Result;

abstract class AbstractResolver implements ResolverInterface
{
    public function getPriority(): int
    {
        return 50;
    }

    public function supports(string $query): bool
    {
        return $this->resolve($query) instanceof Result;
    }
}
