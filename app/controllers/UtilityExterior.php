<?php

class UtilityExterior {

	public function buildFilterQuery($and, $exterior_filter)
	{
		if (!empty($exterior_filter)) {
			$or = array();
			$exteriors = explode("-", $exterior_filter);
			foreach ($exteriors as $exterior) {
				array_push($or, array("term" => array("exterior" => $exterior)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("exterior" => array("terms" => array("field" => "exterior", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['exterior']['buckets'] as $exterior) {
			$exteriors = Exterior::where('id' , '=', $exterior['key']);
			if ($exteriors->count()) {
				$entity = $exteriors->first();
				$name = $entity->exterior;
				$count = $exterior['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $exterior['key'], "title" => $title, "count" => $count);
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

	public function findSelectedFilter($filters, $aggregations, $exterior_filter)
	{
		if (!empty($exterior_filter)) {
			$values = array();
			$exterior_ranges = explode("-", $exterior_filter);
			foreach ($exterior_ranges as $exterior_range) {
				$exteriors = Exterior::where('id' , '=', $exterior_range);
				if ($exteriors->count()) {
					$title = '';
					if (array_key_exists($exterior_range, $aggregations['exterior'])) {
						$title = $exteriors->first()->exterior . ' (' .  $aggregations['exterior'][$exterior_range]['count'] . ')';
					} else {
						$title = $exteriors->first()->exterior . ' (0)';
					}
					
					array_push($values, array("title" => $title, "index" => 'exterior-remove-' . $exterior_range));
				}
			}

			array_push($filters, array("name" => "Exterior Color", "values" => $values));
		}

		return $filters;
	}
}