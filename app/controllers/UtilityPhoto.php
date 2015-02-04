<?php

class UtilityPhoto {

	protected $photo_specification = 'spec-17';

	public function getValue($source)
	{
		$image = 'images/empty.png';
		if (array_key_exists($this->photo_specification, $source)) {
			$image = $source[$this->photo_specification];
		}

		return $image;
	}

	public function buildFilterQuery($and, $photo_filter)
	{
		if (!empty($photo_filter)) {
			$or = array();
			$photo_ranges = explode("-", $photo_filter);
			foreach ($photo_ranges as $photo_range) {
				if ($photo_range == 1) {
					array_push($or, array("exists" => array("field" => $this->photo_specification)));
				} else if ($photo_range == 2) {
					array_push($or, array("missing" => array("field" => $this->photo_specification)));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAvailableAggregationQuery()
	{
		return array("available" => array("filter" => array("exists" => array("field" => $this->photo_specification))));
	}

	public function buildNotAvailableAggregationQuery()
	{
		return array("not_available" => array("filter" => array("missing" => array("field" => $this->photo_specification))));
	}

	public function decodeAggregation($available, $not_available)
	{
		$values = array(
			'1' => $available['aggregations']['available']['doc_count'],
			'2' => $not_available['aggregations']['not_available']['doc_count']
		);

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $photo_filter)
	{
		if (!empty($photo_filter)) {
			$values = array();
			$photo_ranges = explode("-", $photo_filter);
			foreach ($photo_ranges as $photo_range) {
				$title = '';
				if ($photo_range == 1) {
					$title = "Available";
				} else if ($photo_range == 2) {
					$title = "Not Available";
				}

				$title = $title . " (" . $aggregations['photo'][$photo_range] . ")";
				array_push($values, array("title" => $title, "index" => 'photo-remove-' . $photo_range));
			}

			array_push($filters, array("name" => "Has Photo", "values" => $values));
		}

		return $filters;
	}
}