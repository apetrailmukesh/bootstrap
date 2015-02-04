<?php

class UtilityTransmission {

	protected $transmission_specification = 'spec-15';

	public function getValue($source)
	{
		$transmission = '';
		if (array_key_exists($this->transmission_specification, $source)) {
			$transmission = $source[$this->transmission_specification];
		}

		return $transmission;
	}
}