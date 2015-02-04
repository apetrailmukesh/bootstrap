<?php

class UtilityImage {

	protected $image_specification = 'spec-17';

	public function getValue($source)
	{
		$image = 'images/empty.png';
		if (array_key_exists($this->image_specification, $source)) {
			$image = $source[$this->image_specification];
		}

		return $image;
	}
}