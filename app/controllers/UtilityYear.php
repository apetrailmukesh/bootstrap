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
			$years = explode("-", $year_filter);
			foreach ($years as $year) {
				array_push($or, array("term" => array("year" => $year)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildCustomFilterQuery($and, $year_filter)
	{
		if (!empty($year_filter)) {
			$year_ranges = explode("-", $year_filter);
			if (count($year_ranges) == 2) {
				$min = $year_ranges[0];
				$max = $year_ranges[1];

				if (empty($min) && !empty($max)) {
					array_push($and, array("range" => array('year' => array("lte" => $max))));
				} else if (!empty($min) && empty($max)) {
					array_push($and, array("range" => array('year' => array("gte" => $min))));
				} else if (!empty($max) && !empty($max) && $min <= $max) {
					array_push($and, array("range" => array('year' => array("gte" => $min, "lte" => $max))));
				}
			}
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("year" => array("terms" => array("field" => "year", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['year']['buckets'] as $year) {
			$name = $year['key'];
			$count = $year['doc_count'];
			$title = $name . ' (' . $count . ')';
			$sorted[$name] = array("key" => $name, "title" => $title, "count" => $count, "index" => 0);
		}

		krsort($sorted);

		$counter = 0;
		foreach ($sorted as $value) {
			$values[$value['key']] = array('index' => $counter, 'key' => $value['key'], 'title' => $value['title'], 'count' => $value['count']);
    		$counter++;
		}

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $year_filter, $year_custom_filter)
	{
		if (!empty($year_filter)) {
			$values = array();
			$year_ranges = explode("-", $year_filter);
			foreach ($year_ranges as $year_range) {
				$title = $year_range;
					
				array_push($values, array("title" => $title, "index" => 'year-remove-' . $year_range));
			}

			array_push($filters, array("name" => "Year", "values" => $values, "modal" => "year"));
		} else if (!empty($year_custom_filter)) {
			$year_ranges = explode("-", $year_custom_filter);
			if (count($year_ranges) == 2) {
				$min = $year_ranges[0];
				$max = $year_ranges[1];

				if (empty($min) && !empty($max)) {
					$title = 'To - ' . $max;
					$values = array();
					array_push($values, array("title" => $title, "index" => 'year-custom-remove'));
					array_push($filters, array("name" => "Year", "values" => $values, "modal" => "year"));
				} else if (!empty($min) && empty($max)) {
					$title = 'From - ' . $min;
					$values = array();
					array_push($values, array("title" => $title, "index" => 'year-custom-remove'));
					array_push($filters, array("name" => "Year", "values" => $values, "modal" => "year"));
				} else if (!empty($max) && !empty($max) && $min <= $max) {
					$title = $min . ' - ' . $max;
					$values = array();
					array_push($values, array("title" => $title, "index" => 'year-custom-remove'));
					array_push($filters, array("name" => "Year", "values" => $values, "modal" => "year"));
				}
			}
		}

		return $filters;
	}
}