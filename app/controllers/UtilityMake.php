<?php

class UtilityMake {

	public function getValue($source)
	{
		$value = '';
		if (array_key_exists('make', $source)) {
			$values = Make::where('id' , '=', $source['make']);
			if ($values->count()) {
				$value = $values->first()->make;
			}
		}

		return $value;
	}
	
	public function buildFilterQuery($and, $make_filter)
	{
		if (!empty($make_filter)) {
			$or = array();
			$makes = explode("-", $make_filter);
			foreach ($makes as $make) {
				array_push($or, array("term" => array("make" => $make)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("make" => array("terms" => array("field" => "make", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['make']['buckets'] as $make) {
			$makes = Make::where('id' , '=', $make['key']);
			if ($makes->count()) {
				$entity = $makes->first();
				$name = $entity->make;
				$count = $make['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $make['key'], "title" => $title, "count" => $count);
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

	public function findSelectedFilter($filters, $aggregations, $make_filter)
	{
		if (!empty($make_filter)) {
			$values = array();
			$make_ranges = explode("-", $make_filter);
			foreach ($make_ranges as $make_range) {
				$makes = Make::where('id' , '=', $make_range);
				if ($makes->count()) {
					$title = '';
					if (array_key_exists($make_range, $aggregations['make'])) {
						$title = $makes->first()->make . ' (' .  $aggregations['make'][$make_range]['count'] . ')';
					} else {
						$title = $makes->first()->make . ' (0)';
					}
					
					array_push($values, array("title" => $title, "index" => 'make-remove-' . $make_range));
				}
			}

			array_push($filters, array("name" => "Make", "values" => $values));
		}

		return $filters;
	}
}