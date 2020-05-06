<?php declare(strict_types=1);

namespace TDD;

class Receipt
{
    public function __construct()
    {
    }

    public function total(array $items = [], float $coupon = null): float
    {
        $sum = (float)array_sum($items);

        if ($sum !== 0 && $coupon !== null) {
            $sum -= ($sum * $coupon);
        }

        return $sum;
    }

    public function tax(float $amount, float $tax): float
    {
        return ($amount * $tax);
    }

    public function postTaxTotal(array $amount, float $tax, float $coupon = null): float
    {
        $subtotal = $this->total($amount, $coupon);
        return $subtotal + $this->tax($subtotal, $tax);
    }


}