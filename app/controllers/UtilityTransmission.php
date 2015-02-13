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

	public function buildFilterQuery($and, $transmission_filter)
	{
		if (!empty($transmission_filter)) {
			$or = array();
			$transmission_ranges = explode("-", $transmission_filter);
			foreach ($transmission_ranges as $transmission_range) {
				if ($transmission_range == 1) {
					array_push($or, array("term" => array($this->transmission_specification.'.raw' => "Automatic")));
				} else if ($transmission_range == 2) {
					array_push($or, array("term" => array($this->transmission_specification.'.raw' => "Manual")));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAutomaticAggregationQuery()
	{
		return array("automatic" => array("filter" => array("term" => array($this->transmission_specification.'.raw' => "Automatic"))));
	}

	public function buildManualAggregationQuery()
	{
		return array("manual" => array("filter" => array("term" => array($this->transmission_specification.'.raw' => "Manual"))));
	}

	public function decodeAggregation($automatic, $manual)
	{
		$values = array(
			'1' => $automatic['aggregations']['automatic']['doc_count'],
			'2' => $manual['aggregations']['manual']['doc_count']
		);

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $transmission_filter)
	{
		if (!empty($transmission_filter)) {
			$values = array();
			$transmission_ranges = explode("-", $transmission_filter);
			foreach ($transmission_ranges as $transmission_range) {
				$title = '';
				if ($transmission_range == 1) {
					$title = "Automatic";
				} else if ($transmission_range == 2) {
					$title = "Manual";
				}

				$title = $title . " (" . $aggregations['transmission'][$transmission_range] . ")";
				array_push($values, array("title" => $title, "index" => 'transmission-remove-' . $transmission_range));
			}

			array_push($filters, array("name" => "Transmission", "values" => $values));
		}

		return $filters;
	}
}