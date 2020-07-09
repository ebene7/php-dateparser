<?php

namespace E7\DateParser;

interface DateParserInterface
{
    public function parse(string $query): Result;
}
