<?php

namespace E7\DateParser;

use E7\DateParser\Resolver\ResolverInterface;
use Exception;
use RuntimeException;

class DateParser implements DateParserInterface
{
    /** @var ResolverInterface[] */
    private $resolvers = [];
    
    public function parse(string $query): Result
    {
        $parts = explode('..', $query);
        
        switch(count($parts)) {
            case 1:
                return $this->resolve($parts[0]);
                break;
            case 2:
                $result0 = $this->parse($parts[0]);
                $result1 = $this->parse($parts[1]);
                
                $allDates = [
                    $result0->getStart(),
                    $result0->getEnd(),
                    $result1->getStart(),
                    $result1->getEnd(),
                ];
                
                return new Result($query, min($allDates), max($allDates));
            default:
                throw new RuntimeException('Cannot parse value');
        }
    }
    
    public function addResolver(ResolverInterface $resolver): self
    {
        $this->resolvers[$resolver->getName()] = $resolver;
        
        return $this;
    }
    
    protected function resolve(string $query)
    {
        foreach ($this->resolvers as $resolver) {
            if (!$resolver->supports($query)) {
                continue;
            }
            
            return $resolver->resolve($query);
        }
        
        throw new Exception('This point should not be reached!');
    }

    public static function create()
    {
        $parser = new self();
        
        $parser->addResolver(new Resolver\YearResolver());
        $parser->addResolver(new Resolver\MonthResolver());
        $parser->addResolver(new Resolver\DayResolver());
        $parser->addResolver(new Resolver\WeekResolver());
        
        return $parser;
    }
}
