<?php

class UtilityEngine {

	protected $engine_specification = 'spec-16';

	public function getValue($source)
	{
		$engine = '';
		if (array_key_exists($this->engine_specification, $source)) {
			$engine = $source[$this->engine_specification];
		}

		return $engine;
	}
}