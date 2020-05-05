<?php declare(strict_types=1);

namespace TDD\Test;

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase
{
    public function testTotal(): void
    {
        $receipt = new Receipt();

        self::assertEquals(
            15,
            $receipt->total([0, 2, 5, 8]),
            'When summing the total should equal 15');
    }
}
