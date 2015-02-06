<?php

class UtilityMileage {

	protected $mileage_specification = 'spec-4';

	public function getValue($source)
	{
		$miles = '';
		if (array_key_exists($this->mileage_specification, $source)) {
			$miles = number_format($source[$this->mileage_specification], 0, '.', '') . ' mi.';
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
					array_push($or, array("range" => array($this->mileage_specification => array("lte" => 100000))));
				} else if ($mileage_range == 2) {
					array_push($or, array("range" => array($this->mileage_specification => array("gt" => 100000, "lte" => 200000))));
				} else if ($mileage_range == 3) {
					array_push($or, array("range" => array($this->mileage_specification => array("gt" => 200000, "lte" => 300000))));
				} else if ($mileage_range == 4) {
					array_push($or, array("range" => array($this->mileage_specification => array("gt" => 300000, "lte" => 400000))));
				} else if ($mileage_range == 5) {
					array_push($or, array("range" => array($this->mileage_specification => array("gt" => 400000, "lte" => 500000))));
				} else if ($mileage_range == 6) {
					array_push($or, array("range" => array($this->mileage_specification => array("gt" => 500000))));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		$mileage_ranges = array();
		array_push($mileage_ranges, array("key" => "1", "to" => "100001"));
		array_push($mileage_ranges, array("key" => "2", "from" => "100001", "to" => "200001"));
		array_push($mileage_ranges, array("key" => "3", "from" => "200001", "to" => "300001"));
		array_push($mileage_ranges, array("key" => "4", "from" => "300001", "to" => "400001"));
		array_push($mileage_ranges, array("key" => "5", "from" => "400001", "to" => "500001"));
		array_push($mileage_ranges, array("key" => "6", "from" => "500001"));
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
					$title = "Up to 100,000";
				} else if ($mileage_range == 2) {
					$title = "100,000 - 200,000";
				} else if ($mileage_range == 3) {
					$title = "200,000 - 300,000";
				} else if ($mileage_range == 4) {
					$title = "300,000 - 400,000";
				} else if ($mileage_range == 5) {
					$title = "400,000 - 500,000";
				} else if ($mileage_range == 6) {
					$title = "Over 500,000";
				}

				$title = $title . " (" . $aggregations['mileage'][$mileage_range] . ")";
				array_push($values, array("title" => $title, "index" => 'mileage-remove-' . $mileage_range));
			}

			array_push($filters, array("name" => "Mileage", "values" => $values));
		}

		return $filters;
	}
}