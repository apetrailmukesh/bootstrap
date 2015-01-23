<?php

class SpecificationType extends Eloquent {

	protected $table = 'specification_type';

	public function enabledString()
	{
		$value = 'No';
		if ($this->enabled > 0) {
			$value = 'Yes';
		}

		return $value;
	}
}
