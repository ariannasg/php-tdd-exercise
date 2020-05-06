<?php declare(strict_types=1);

namespace TDD\Test;

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase
{
    /**
     * @var Receipt
     */
    private $receipt;

    protected function setUp(): void
    {
        $this->receipt = new Receipt();
    }

    protected function tearDown(): void
    {
        unset($this->receipt);
    }

    public function testTotal(): void
    {
        $input = [0, 2, 5, 8];
        $coupon = null;
        $output = $this->receipt->total($input, $coupon);

        self::assertEquals(
            15,
            $output,
            'When summing the total should equal 15');
    }

    public function testTotalAndCoupon(): void
    {
        $input = [0, 2, 5, 8];
        $coupon = 0.20;
        $output = $this->receipt->total($input, $coupon);

        self::assertEquals(
            12,
            $output,
            'When summing the total should equal 12');
    }

    public function testTax(): void
    {
        $inputAmount = 10.00;
        $taxInput = 0.10;
        $output = $this->receipt->tax($inputAmount, $taxInput);

        self::assertEquals(1.00, $output, 'The tax calculation should equal 1.00');
    }

    public function testPostTaxTotal(): void
    {
        $receipt = $this->getMockBuilder(Receipt::class)->setMethods(['total', 'tax'])->getMock();
        $receipt->method('total')->willReturn(10.00);
        $receipt->method('tax')->willReturn(1.00);

        $result = $receipt->postTaxTotal([1, 2, 5, 8], 0.20, null);

        self::assertEquals(11.00, $result);
    }
}
