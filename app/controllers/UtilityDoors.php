<?php

class UtilityDoors {

	public function buildFilterQuery($and, $doors_filter)
	{
		if (!empty($doors_filter)) {
			$or = array();
			$doorss = explode("-", $doors_filter);
			foreach ($doorss as $doors) {
				array_push($or, array("term" => array("doors" => $doors)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("doors" => array("terms" => array("field" => "doors", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['doors']['buckets'] as $doors) {
			$name = $doors['key'];
			$count = $doors['doc_count'];
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

	public function findSelectedFilter($filters, $aggregations, $doors_filter)
	{
		if (!empty($doors_filter)) {
			$values = array();
			$doors_ranges = explode("-", $doors_filter);
			foreach ($doors_ranges as $doors_range) {
				$title = $doors_range;
					
				array_push($values, array("title" => $title, "index" => 'doors-remove-' . $doors_range));
			}

			array_push($filters, array("name" => "Doors", "values" => $values, "modal" => "doors"));
		}

		return $filters;
	}
}