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

    public function provideTotal(): array
    {
        return [
            [
                [1, 2, 5, 8], 16
            ],
            [
                [-1, 2, 5, 8], 14
            ],
            [
                [1, 2, 8], 11
            ],
        ];
    }

    public function provideCurrencyAmt(): array
    {
        return [
            [
                1, 1.00, '1 should be transformed into 1.00'
            ],
            [
                1.1, 1.10, '1 should be transformed into 1.10'
            ],
            [
                1.11, 1.11, '1 should be transformed into 1.11'
            ],
            [
                1.111, 1.11, '1 should be transformed into 1.11'
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->receipt = new Receipt();
    }

    protected function tearDown(): void
    {
        unset($this->receipt);
    }

    /**
     * @dataProvider provideTotal
     * @param array $items
     * @param float $expected
     */
    public function testTotal(array $items, float $expected): void
    {
        $coupon = null;
        $output = $this->receipt->total($items, $coupon);

        self::assertEquals(
            $expected,
            $output,
            "When summing the total should equal {$expected}");
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

    public function testTotalException(): void
    {
        $input = [0, 2, 5, 8];
        $coupon = 1.20;

        $this->expectException('BadMethodCallException');

        $this->receipt->total($input, $coupon);
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
        $items = [1, 2, 5, 8];
        $tax = 0.20;
        $coupon = null;

        $receipt = $this->getMockBuilder(Receipt::class)->setMethods(['total', 'tax'])->getMock();
        $receipt->expects(self::once())
            ->method('total')
            ->with($items, $coupon)
            ->willReturn(10.00);
        $receipt->expects(self::once())
            ->method('tax')
            ->with(10.00, $tax)
            ->willReturn(1.00);

        $result = $receipt->postTaxTotal($items, $tax, $coupon);

        self::assertEquals(11.00, $result);
    }

    /**
     * @dataProvider provideCurrencyAmt
     * @param float $input
     * @param float $expected
     * @param string $msg
     */
    public function testCurrencyAmt(float $input, float $expected, string $msg): void
    {
        self::assertSame(
            $expected,
            $this->receipt->currencyAmt($input),
            $msg
        );
    }
}
