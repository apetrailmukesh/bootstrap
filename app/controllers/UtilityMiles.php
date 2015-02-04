<?php

class UtilityMiles {

	protected $miles_specification = 'spec-4';

	public function getValue($source)
	{
		$miles = '';
		if (array_key_exists($this->miles_specification, $source)) {
			$miles = $source[$this->miles_specification] . ' mi.';
		}

		return $miles;
	}

	public function buildSortQuery($sort, $sort_order)
	{
		if ($sort_order == '1') {
			array_push($sort, array($this->miles_specification => array("order" => "desc", "mode" => "min")));
		} else if ($sort_order == 0) {
			array_push($sort, array($this->miles_specification => array("order" => "asc", "mode" => "min")));
		}

		return $sort;
	}
}