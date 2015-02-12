<?php

class UtilityMileage {

	protected $mileage_specification = 'spec-4';

	public function getValue($source)
	{
		$miles = '';
		if (array_key_exists($this->mileage_specification, $source)) {
			$miles = number_format($source[$this->mileage_specification], 0, '.', ',') . ' mi.';
		}

		return $miles;
	}

	public function buildSortQuery($sort, $sort_order)
	{
		if ($sort_order == '1') {
			array_push($sort, array($this->mileage_specification => array("order" => "desc", "mode" => "min")));
		} else if ($sort_order == 0) {
			array_push($sort, array($this->mileage_specification => array("order" => "asc", "mode" => "min")));
		}

		return $sort;
	}

	public function buildFilterQuery($and, $mileage_filter)
	{
		if (!empty($mileage_filter)) {
			$or = array();
			$mileage_ranges = explode("-", $mileage_filter);
			foreach ($mileage_ranges as $mileage_range) {
				if ($mileage_range == 1) {
					array_push($or, array("range" => array($this->mileage_specification => array("lte" => 10000))));
				} else if ($mileage_range == 2) {
					array_push($or, array("range" => array($this->mileage_specification => array("lte" => 20000))));
				} else if ($mileage_range == 3) {
					array_push($or, array("range" => array($this->mileage_specification => array("lte" => 30000))));
				} else if ($mileage_range == 4) {
					array_push($or, array("range" => array($this->mileage_specification => array("lte" => 40000))));
				} else if ($mileage_range == 5) {
					array_push($or, array("range" => array($this->mileage_specification => array("lte" => 50000))));
				} else if ($mileage_range == 6) {
					array_push($or, array("range" => array($this->mileage_specification => array("lte" => 60000))));
				}
			}

			array_push($and, array("or" => $or));
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
		$mileage_range = array("field" => $this->mileage_specification, "keyed" => true, "ranges" => $mileage_ranges);
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

	public function findSelectedFilter($filters, $aggregations, $mileage_filter)
	{
		if (!empty($mileage_filter)) {
			$values = array();
			$mileage_ranges = explode("-", $mileage_filter);
			foreach ($mileage_ranges as $mileage_range) {
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

				$title = $title . " (" . $aggregations['mileage'][$mileage_range] . ")";
				array_push($values, array("title" => $title, "index" => 'mileage-remove-' . $mileage_range));
			}

			array_push($filters, array("name" => "Mileage", "values" => $values));
		}

		return $filters;
	}
}