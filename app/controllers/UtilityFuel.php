<?php

class UtilityFuel {

	public function buildFilterQuery($and, $fuel_filter)
	{
		if (!empty($fuel_filter)) {
			$or = array();
			$fuels = explode("-", $fuel_filter);
			foreach ($fuels as $fuel) {
				array_push($or, array("term" => array("fuel" => $fuel)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("fuel" => array("terms" => array("field" => "fuel", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['fuel']['buckets'] as $fuel) {
			$fuels = Fuel::where('id' , '=', $fuel['key']);
			if ($fuels->count()) {
				$entity = $fuels->first();
				$name = $entity->fuel;
				$count = $fuel['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $fuel['key'], "title" => $title, "count" => $count);
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

	public function findSelectedFilter($filters, $aggregations, $fuel_filter)
	{
		if (!empty($fuel_filter)) {
			$values = array();
			$fuel_ranges = explode("-", $fuel_filter);
			foreach ($fuel_ranges as $fuel_range) {
				$fuels = Fuel::where('id' , '=', $fuel_range);
				if ($fuels->count()) {
					$title = $fuels->first()->fuel;
					
					array_push($values, array("title" => $title, "index" => 'fuel-remove-' . $fuel_range));
				}
			}

			array_push($filters, array("name" => "Fuel", "values" => $values, "modal" => "fuel"));
		}

		return $filters;
	}
}