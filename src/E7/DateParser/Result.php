<?php

namespace E7\DateParser;

use DateTimeInterface;

class Result
{
    /** @var string */
    private $query;
    
    /** @var DateTimeInterface */
    private $start;
    
    /** @var DateTimeInterface */
    private $end;
    
    public function __construct(
        string $query,
        DateTimeInterface $start,
        DateTimeInterface $end
    ) {
        $this->query = $query;
        $this->start = $start;
        $this->end = $end;
    }
    
    public function getQuery(): string
    {
        return $this->query;
    }

    public function getStart(): DateTimeInterface
    {
        return $this->start;
    }

    public function getEnd(): DateTimeInterface
    {
        return $this->end;
    }
    
    public static function create(
        string $query,
        DateTimeInterface $start,
        DateTimeInterface $end
    ) {
        return new self($query, $start, $end);
    }
}
