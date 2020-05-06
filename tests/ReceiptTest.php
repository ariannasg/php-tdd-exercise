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
        $output = $this->receipt->total($input);

        self::assertEquals(
            15,
            $output,
            'When summing the total should equal 15');
    }
}
