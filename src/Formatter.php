<?php declare(strict_types=1);

namespace TDD;

class Formatter
{
    public function currencyAmt(float $input): float
    {
        return round($input, 2);
    }
}