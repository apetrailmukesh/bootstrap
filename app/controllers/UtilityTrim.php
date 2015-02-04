<?php

class UtilityTrim {

	protected $trim_specification = 'spec-1';

	public function getValue($source)
	{
		$trim = '';
		if (array_key_exists($this->trim_specification, $source)) {
			$trim = $source[$this->trim_specification];
		}

		return $trim;
	}
}