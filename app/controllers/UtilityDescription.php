<?php

class UtilityDescription {

	protected $description_specification = 'spec-19';

	public function getValue($source)
	{
		$description = '';
		if (array_key_exists($this->description_specification, $source)) {
			$description = $source[$this->description_specification];
			$description = strip_tags($description);
			if (strlen($description) > 500) {
				$stringCut = substr($description, 0, 500);
				$description = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
			}
		}

		return $description;
	}
}