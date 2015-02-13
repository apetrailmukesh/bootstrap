<?php

class UtilityTransmission {

	public function getValue($source)
	{
		$value = '';
		if (array_key_exists('transmission', $source)) {
			$values = Transmission::where('id' , '=', $source['transmission']);
			if ($values->count()) {
				$value = $values->first()->transmission;
			}
		}

		return $value;
	}

	public function buildFilterQuery($and, $transmission_filter)
	{
		if (!empty($transmission_filter)) {
			$or = array();
			$transmissions = explode("-", $transmission_filter);
			foreach ($transmissions as $transmission) {
				array_push($or, array("term" => array("transmission" => $transmission)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("transmission" => array("terms" => array("field" => "transmission", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['transmission']['buckets'] as $transmission) {
			$transmissions = Transmission::where('id' , '=', $transmission['key']);
			if ($transmissions->count()) {
				$entity = $transmissions->first();
				$name = $entity->transmission;
				$count = $transmission['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $transmission['key'], "title" => $title, "count" => $count);
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

	public function findSelectedFilter($filters, $aggregations, $transmission_filter)
	{
		if (!empty($transmission_filter)) {
			$values = array();
			$transmission_ranges = explode("-", $transmission_filter);
			foreach ($transmission_ranges as $transmission_range) {
				$transmissions = Transmission::where('id' , '=', $transmission_range);
				if ($transmissions->count()) {
					$title = '';
					if (array_key_exists($transmission_range, $aggregations['transmission'])) {
						$title = $transmissions->first()->transmission . ' (' .  $aggregations['transmission'][$transmission_range]['count'] . ')';
					} else {
						$title = $transmissions->first()->transmission . ' (0)';
					}
					
					array_push($values, array("title" => $title, "index" => 'transmission-remove-' . $transmission_range));
				}
			}

			array_push($filters, array("name" => "Transmission", "values" => $values));
		}

		return $filters;
	}
}