<?php

namespace E7\DateParser\Resolver;

use E7\DateParser\Result;

interface ResolverInterface
{
    public function supports(string $query): bool;
    public function resolve(string $query): ?Result;
    public function getName(): string;
    public function getPriority(): int;
}
