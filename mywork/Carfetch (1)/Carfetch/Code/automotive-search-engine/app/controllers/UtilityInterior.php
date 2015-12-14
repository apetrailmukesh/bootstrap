<?php

class UtilityInterior {

	public function buildFilterQuery($and, $interior_filter)
	{
		if (!empty($interior_filter)) {
			$or = array();
			$interiors = explode("-", $interior_filter);
			foreach ($interiors as $interior) {
				array_push($or, array("term" => array("interior" => $interior)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("interior" => array("terms" => array("field" => "interior", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['interior']['buckets'] as $interior) {
			$interiors = Interior::where('id' , '=', $interior['key']);
			if ($interiors->count()) {
				$entity = $interiors->first();
				$name = $entity->interior;
				$count = $interior['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $interior['key'], "title" => $title, "count" => $count);
			}
		}

		ksort($sorted);

		$counter = 0;
		foreach ($sorted as $value) {
			$values[$value['key']] = array('index' => $counter, 'key' => $value['key'], 'title' => $value['title'], 'count' => $value['count']);
    		$counter++;
		}

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $interior_filter)
	{
		if (!empty($interior_filter)) {
			$values = array();
			$interior_ranges = explode("-", $interior_filter);
			foreach ($interior_ranges as $interior_range) {
				$interiors = Interior::where('id' , '=', $interior_range);
				if ($interiors->count()) {
					$title = $interiors->first()->interior;
					
					array_push($values, array("title" => $title, "index" => 'interior-remove-' . $interior_range));
				}
			}

			array_push($filters, array("name" => "Interior Color", "values" => $values, "modal" => "interior"));
		}

		return $filters;
	}
}