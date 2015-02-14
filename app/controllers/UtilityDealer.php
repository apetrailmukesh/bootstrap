<?php

class UtilityDealer {

	public function getValue($source)
	{
		$dealer_address = '';
		if (array_key_exists('address', $source)) {
			$dealer_address = 'in ' . $source['address'];

			if (array_key_exists('city', $source)) {
				$dealer_address = $dealer_address. ', ' . $source['city'];

				if (array_key_exists('state', $source)) {
					$dealer_address = $dealer_address. ', ' . $source['state'];
				}
			}
		}

		return $dealer_address;
	}
}