<?php

class UtilityDealer {

	public function getValue($source)
	{
		$dealer_address = '';
		if (array_key_exists('address', $source)) {
			$dealer_address = 'in ' . $source['address'];
		}

		return $dealer_address;
	}
}