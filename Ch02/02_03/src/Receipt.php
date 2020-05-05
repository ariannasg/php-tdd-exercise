<?php
namespace TDD;
class Receipt {
	public function total(array $items = [], $coupon) {
		$sum = array_sum($items);
		if (!is_null($coupon)) {
			return $sum - ($sum * $coupon);
		}
		return $sum;
	}

	public function tax($amount, $tax) {
		return ($amount * $tax);
	}
}