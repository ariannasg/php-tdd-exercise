<?php declare(strict_types=1);

namespace TDD;

class Receipt
{
    public function total(array $items = []): float
    {
        return (float)array_sum($items);
    }
}