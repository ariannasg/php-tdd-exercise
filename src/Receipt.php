<?php declare(strict_types=1);

namespace TDD;

use BadMethodCallException;

class Receipt
{
    /**
     * @var float
     */
    public $tax;
    /**
     * @var Formatter
     */
    private $formatter;

    public function __construct(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function subTotal(array $items = [], float $coupon = null): float
    {
        $sum = (float)array_sum($items);

        if ($sum !== 0 && $coupon !== null) {
            if ($coupon > 1.00) {
                throw new BadMethodCallException('Coupon must be less than or equal to 1.00');
            }
            $sum -= ($sum * $coupon);
        }

        return $sum;
    }

    public function tax(float $amount): float
    {
        return $this->formatter->currencyAmt(($amount * $this->tax));
    }

    public function postTaxTotal(array $amount, float $coupon = null): float
    {
        $subtotal = $this->subTotal($amount, $coupon);
        return $subtotal + $this->tax($subtotal);
    }
}