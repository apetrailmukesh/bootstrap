<?php

class UtilityYear {

	public function buildSortQuery($sort, $sort_order)
	{
		if ($sort_order == '1') {
			array_push($sort, array("year" => array("order" => "desc")));
		} else if ($sort_order == 0) {
			array_push($sort, array("year" => array("order" => "asc")));
		}

		return $sort;
	}

	public function buildFilterQuery($and, $year_filter)
	{
		if (!empty($year_filter)) {
			$or = array();
			$year_ranges = explode("-", $year_filter);
			foreach ($year_ranges as $year_range) {
				if ($year_range == 1) {
					array_push($or, array("range" => array("year" => array("lte" => 1990))));
				} else if ($year_range == 2) {
					array_push($or, array("range" => array("year" => array("gt" => 1990, "lte" => 1995))));
				} else if ($year_range == 3) {
					array_push($or, array("range" => array("year" => array("gt" => 1995, "lte" => 2000))));
				} else if ($year_range == 4) {
					array_push($or, array("range" => array("year" => array("gt" => 2000, "lte" => 2005))));
				} else if ($year_range == 5) {
					array_push($or, array("range" => array("year" => array("gt" => 2005, "lte" => 2010))));
				} else if ($year_range == 6) {
					array_push($or, array("range" => array("year" => array("gt" => 2010))));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		$year_ranges = array();
		array_push($year_ranges, array("key" => "1", "to" => "1990"));
		array_push($year_ranges, array("key" => "2", "from" => "1991", "to" => "1995"));
		array_push($year_ranges, array("key" => "3", "from" => "1996", "to" => "2000"));
		array_push($year_ranges, array("key" => "4", "from" => "2001", "to" => "2005"));
		array_push($year_ranges, array("key" => "5", "from" => "2006", "to" => "2010"));
		array_push($year_ranges, array("key" => "6", "from" => "2011"));
		$year_range = array("field" => "year", "keyed" => true, "ranges" => $year_ranges);
		$year = array("range" => $year_range);

		$aggs = array("year" => $year);

		return $aggs;
	}

	public function decodeAggregation($results)
	{
		$years = $results['aggregations']['year']['buckets'];

		$values = array(
			'1' => $years['1']['doc_count'],
			'2' => $years['2']['doc_count'],
			'3' => $years['3']['doc_count'],
			'4' => $years['4']['doc_count'],
			'5' => $years['5']['doc_count'],
			'6' => $years['6']['doc_count'],
		);

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $year_filter)
	{
		if (!empty($year_filter)) {
			$values = array();
			$year_ranges = explode("-", $year_filter);
			foreach ($year_ranges as $year_range) {
				$title = '';
				if ($year_range == 1) {
					$title = "Before 1990";
				} else if ($year_range == 2) {
					$title = "1990 - 1995";
				} else if ($year_range == 3) {
					$title = "1995 - 2000";
				} else if ($year_range == 4) {
					$title = "2000 - 2005";
				} else if ($year_range == 5) {
					$title = "2005 - 2010";
				} else if ($year_range == 6) {
					$title = "After 2010";
				}

				$title = $title . " (" . $aggregations['year'][$year_range] . ")";
				array_push($values, array("title" => $title, "index" => 'year-remove-' . $year_range));
			}

			array_push($filters, array("name" => "Year", "values" => $values));
		}

		return $filters;
	}
}