<?php

class UtilityPhoto {

	public function getValue($source)
	{
		$image = 'images/empty.png';
		if (array_key_exists('photo', $source)) {
			$image = $source['photo'];
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
					array_push($or, array("exists" => array("field" => 'photo')));
				} else if ($photo_range == 2) {
					array_push($or, array("missing" => array("field" => 'photo')));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAvailableAggregationQuery()
	{
		return array("available" => array("filter" => array("exists" => array("field" => 'photo'))));
	}

	public function buildNotAvailableAggregationQuery()
	{
		return array("not_available" => array("filter" => array("missing" => array("field" => 'photo'))));
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

				array_push($values, array("title" => $title, "index" => 'photo-remove-' . $photo_range));
			}

			array_push($filters, array("name" => "Has Photo", "values" => $values, "modal" => "photo"));
		}

		return $filters;
	}
}