<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
	public function setUp() {
		$this->Receipt = new Receipt();
	}

	public function tearDown() {
		unset($this->Receipt);
	}

	/**
	 * @dataProvider provideSubtotal
	 */
	public function testSubtotal($items, $expected) {
		$coupon = null;
		$output = $this->Receipt->subtotal($items, $coupon);
		$this->assertEquals(
			$expected,
			$output,
			"When summing the total should equal {$expected}"
		);
	}

	public function provideSubtotal() {
		return [
			'ints totaling 16' => [[1,2,5,8], 16],
			[[-1,2,5,8], 14],
			[[1,2,8], 11],
		];
	}
	public function testSubtotalAndCoupon() {
		$input = [0,2,5,8];
		$coupon = 0.20;
		$output = $this->Receipt->subtotal($input, $coupon);
		$this->assertEquals(
			12,
			$output,
			'When summing the total should equal 12'
		);
	}

	public function testSubtotalException() {
		$input = [0,2,5,8];
		$coupon = 1.20;
		$this->expectException('BadMethodCallException');
		$this->Receipt->subtotal($input, $coupon);
	}

	public function testPostTaxTotal() {
		$items = [1,2,5,8];
		$tax = 0.20;
		$coupon = null;
		$Receipt = $this->getMockBuilder('TDD\Receipt')
			->setMethods(['tax', 'subtotal'])
			->getMock();
		$Receipt->expects($this->once())
			->method('subtotal')
			->with($items, $coupon)
			->will($this->returnValue(10.00));
		$Receipt->expects($this->once())
			->method('tax')
			->with(10.00)
			->will($this->returnValue(1.00));
		$result = $Receipt->postTaxTotal([1,2,5,8], null);
		$this->assertEquals(11.00, $result);
	}

	public function testTax() {
		$inputAmount = 10.00;
		$this->Receipt->tax = 0.10;
		$output = $this->Receipt->tax($inputAmount);
		$this->assertEquals(
			1.00,
			$output,
			'The tax calculation should equal 1.00'
		);
	}

	/**
	 * @dataProvider provideCurrencyAmt
	 */
	public function testCurrencyAmt($input, $expected, $msg) {
		$this->assertSame(
			$expected,
			$this->Receipt->currencyAmt($input),
			$msg
		);
	}

	public function provideCurrencyAmt() {
		return [
			[1, 1.00, '1 should be transformed into 1.00'],
			[1.1, 1.10, '1.1 should be transformed into 1.10'],
			[1.11, 1.11, '1.11 should stay as 1.11'],
			[1.111, 1.11, '1.111 should be transformed into 1.11'],
		];
	}
}