<?php declare(strict_types=1);

namespace TDD\Test;

use PHPUnit\Framework\TestCase;
use TDD\Formatter;

class FormatterTest extends TestCase
{
    /**
     * @var Formatter
     */
    private $formatter;

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
        $this->formatter = new Formatter();
    }

    protected function tearDown(): void
    {
        unset($this->formatter);
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
            $this->formatter->currencyAmt($input),
            $msg
        );
    }
}
