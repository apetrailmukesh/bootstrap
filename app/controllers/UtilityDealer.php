<?php

class UtilityDealer {

	protected $dealer_address_specification = 'spec-7';

	public function getValue($source)
	{
		$dealer_address = '';
		if (array_key_exists($this->dealer_address_specification, $source)) {
			$dealer_address = 'in ' . $source[$this->dealer_address_specification];
		}

		return $dealer_address;
	}
}