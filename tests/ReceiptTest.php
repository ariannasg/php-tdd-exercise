<?php declare(strict_types=1);

namespace TDD\Test;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TDD\Formatter;
use TDD\Receipt;

class ReceiptTest extends TestCase
{
    /**
     * @var Receipt
     */
    private $receipt;
    /**
     * @var MockObject
     */
    private $formatter;

    public function provideSubTotal(): array
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

    protected function setUp(): void
    {
        $this->formatter = $this->getMockBuilder(Formatter::class)
            ->setMethods(['currencyAmt'])
            ->getMock();
        $this->formatter->method('currencyAmt')
            ->with(self::anything())
            ->willReturnArgument(0);

        $this->receipt = new Receipt($this->formatter);
    }

    protected function tearDown(): void
    {
        unset($this->receipt);
    }

    /**
     * @dataProvider provideSubTotal
     * @param array $items
     * @param float $expected
     */
    public function testSubTotal(array $items, float $expected): void
    {
        $coupon = null;
        $output = $this->receipt->subTotal($items, $coupon);

        self::assertEquals(
            $expected,
            $output,
            "When summing the total should equal {$expected}");
    }

    public function testSubTotalAndCoupon(): void
    {
        $input = [0, 2, 5, 8];
        $coupon = 0.20;
        $output = $this->receipt->subTotal($input, $coupon);

        self::assertEquals(
            12,
            $output,
            'When summing the total should equal 12');
    }

    public function testSubTotalException(): void
    {
        $input = [0, 2, 5, 8];
        $coupon = 1.20;

        $this->expectException('BadMethodCallException');

        $this->receipt->subTotal($input, $coupon);
    }

    public function testTax(): void
    {
        $inputAmount = 10.00;
        $this->receipt->tax = 0.10;
        $output = $this->receipt->tax($inputAmount);

        self::assertEquals(1.00, $output, 'The tax calculation should equal 1.00');
    }

    public function testPostTaxTotal(): void
    {
        $items = [1, 2, 5, 8];
        $coupon = null;

        $receipt = $this->getMockBuilder(Receipt::class)
            ->setConstructorArgs([$this->formatter])
            ->setMethods(['subTotal', 'tax'])
            ->getMock();

        $receipt->expects(self::once())
            ->method('subTotal')
            ->with($items, $coupon)
            ->willReturn(10.00);
        $receipt->expects(self::once())
            ->method('tax')
            ->with(10.00)
            ->willReturn(1.00);

        $result = $receipt->postTaxTotal($items, $coupon);

        self::assertEquals(11.00, $result);
    }
}
