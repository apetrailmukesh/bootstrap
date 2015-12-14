<?php

class UtilityDealer {

	public function getName($source)
	{
		$value = '';
		if (array_key_exists('dealer', $source)) {
			$values = Dealer::where('id' , '=', $source['dealer']);
			if ($values->count()) {
				$value = $values->first()->dealer;
			}
		}

		return $value;
	}

	public function getAddress($source)
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