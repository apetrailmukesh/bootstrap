<?php

class UtilityMileage {

	public function getValue($source)
	{
		$miles = '';
		if (array_key_exists('miles', $source)) {
			$miles = number_format($source['miles'], 0, '.', ',') . ' mi.';
		}

		return $miles;
	}

	public function buildSortQuery($sort, $sort_order)
	{
		if ($sort_order == '1') {
			array_push($sort, array('miles' => array("order" => "desc", "mode" => "min")));
		} else if ($sort_order == 0) {
			array_push($sort, array('miles' => array("order" => "asc", "mode" => "min")));
		}

		return $sort;
	}

	public function buildFilterQuery($and, $mileage_range)
	{
		if (!empty($mileage_range)) {
			if ($mileage_range == 1) {
				array_push($and, array("range" => array('miles' => array("lte" => 10000))));
			} else if ($mileage_range == 2) {
				array_push($and, array("range" => array('miles' => array("lte" => 20000))));
			} else if ($mileage_range == 3) {
				array_push($and, array("range" => array('miles' => array("lte" => 30000))));
			} else if ($mileage_range == 4) {
				array_push($and, array("range" => array('miles' => array("lte" => 40000))));
			} else if ($mileage_range == 5) {
				array_push($and, array("range" => array('miles' => array("lte" => 50000))));
			} else if ($mileage_range == 6) {
				array_push($and, array("range" => array('miles' => array("lte" => 60000))));
			}
		}

		return $and;
	}

	public function buildCustomFilterQuery($and, $mileage_filter)
	{
		if (!empty($mileage_filter)) {
			$mileage_ranges = explode("-", $mileage_filter);
			if (count($mileage_ranges) == 2) {
				$min = $mileage_ranges[0];
				$max = $mileage_ranges[1];

				if ($min < $max) {
					array_push($and, array("range" => array('miles' => array("gte" => $min, "lte" => $max))));
				}
			}
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		$mileage_ranges = array();
		array_push($mileage_ranges, array("key" => "1", "to" => "10001"));
		array_push($mileage_ranges, array("key" => "2", "to" => "20001"));
		array_push($mileage_ranges, array("key" => "3", "to" => "30001"));
		array_push($mileage_ranges, array("key" => "4", "to" => "40001"));
		array_push($mileage_ranges, array("key" => "5", "to" => "50001"));
		array_push($mileage_ranges, array("key" => "6", "to" => "60001"));
		$mileage_range = array("field" => 'miles', "keyed" => true, "ranges" => $mileage_ranges);
		$mileage = array("range" => $mileage_range);

		$aggs = array("mileage" => $mileage);

		return $aggs;
	}

	public function decodeAggregation($results)
	{
		$mileages = $results['aggregations']['mileage']['buckets'];

		$values = array(
			'1' => $mileages['1']['doc_count'],
			'2' => $mileages['2']['doc_count'],
			'3' => $mileages['3']['doc_count'],
			'4' => $mileages['4']['doc_count'],
			'5' => $mileages['5']['doc_count'],
			'6' => $mileages['6']['doc_count'],
		);

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $mileage_range, $mileage_custom_filter)
	{
		if (!empty($mileage_range)) {
			$values = array();
			
			$title = '';
			if ($mileage_range == 1) {
				$title = "10,000 or less";
			} else if ($mileage_range == 2) {
				$title = "20,000 or less";
			} else if ($mileage_range == 3) {
				$title = "30,000 or less";
			} else if ($mileage_range == 4) {
				$title = "40,000 or less";
			} else if ($mileage_range == 5) {
				$title = "50,000 or less";
			} else if ($mileage_range == 6) {
				$title = "60,000 or less";
			}

			array_push($values, array("title" => $title, "index" => 'mileage-remove-' . $mileage_range));

			array_push($filters, array("name" => "Mileage", "values" => $values, "modal" => "mileage"));
		} else if (!empty($mileage_custom_filter)) {
			$mileage_ranges = explode("-", $mileage_custom_filter);
			if (count($mileage_ranges) == 2) {
				$min = $mileage_ranges[0];
				$max = $mileage_ranges[1];

				if ($min < $max) {
					$title = number_format($min) . ' - ' . number_format($max);
					$values = array();
					array_push($values, array("title" => $title, "index" => 'mileage-custom-remove'));
					array_push($filters, array("name" => "Mileage", "values" => $values, "modal" => "mileage"));
				}
			}
		}

		return $filters;
	}
}