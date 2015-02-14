<?php

class UtilityCylinders {

	public function buildFilterQuery($and, $cylinders_filter)
	{
		if (!empty($cylinders_filter)) {
			$or = array();
			$cylinderss = explode("-", $cylinders_filter);
			foreach ($cylinderss as $cylinders) {
				array_push($or, array("term" => array("cylinders" => $cylinders)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("cylinders" => array("terms" => array("field" => "cylinders", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['cylinders']['buckets'] as $cylinders) {
			$name = $cylinders['key'];
			$count = $cylinders['doc_count'];
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

	public function findSelectedFilter($filters, $aggregations, $cylinders_filter)
	{
		if (!empty($cylinders_filter)) {
			$values = array();
			$cylinders_ranges = explode("-", $cylinders_filter);
			foreach ($cylinders_ranges as $cylinders_range) {
				$title = '';
				if (array_key_exists($cylinders_range, $aggregations['cylinders'])) {
					$title = $cylinders_range . ' (' .  $aggregations['cylinders'][$cylinders_range]['count'] . ')';
				} else {
					$title = $cylinders_range . ' (0)';
				}
					
				array_push($values, array("title" => $title, "index" => 'cylinders-remove-' . $cylinders_range));
			}

			array_push($filters, array("name" => "Cylinders", "values" => $values));
		}

		return $filters;
	}
}