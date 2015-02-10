<?php

class UtilityMake {

	public function buildFilterQuery($and, $make_filter)
	{
		if (!empty($make_filter)) {
			$or = array();
			$makes = explode("-", $make_filter);
			foreach ($makes as $make) {
				array_push($or, array("term" => array("make_id" => $make)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("make" => array("terms" => array("field" => "make_id", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$values = array();
		
		$counter = 0;
		foreach ($results['aggregations']['make']['buckets'] as $make) {
			$makes = Make::where('id' , '=', $make['key']);
			if ($makes->count()) {
				$title = $makes->first()->make . ' (' . $make['doc_count'] . ')';
				$values[$make['key']] = array("index" => $counter, "key" => $make['key'], "title" => $title, "count" => $make['doc_count']);
				$counter++;
			}
		}

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $make_filter)
	{
		if (!empty($make_filter)) {
			$values = array();
			$make_ranges = explode("-", $make_filter);
			foreach ($make_ranges as $make_range) {
				$makes = Make::where('id' , '=', $make_range);
				if ($makes->count()) {
					$title = $makes->first()->make . ' (' .  $aggregations['make'][$make_range]['count'] . ')';
					array_push($values, array("title" => $title, "index" => 'make-remove-' . $make_range));
				}
			}

			array_push($filters, array("name" => "Make", "values" => $values));
		}

		return $filters;
	}
}