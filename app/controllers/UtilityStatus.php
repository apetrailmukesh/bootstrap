<?php

class UtilityStatus {

	public function buildFilterQuery($and, $status_filter)
	{
		if (!empty($status_filter)) {
			$or = array();
			$statuses = explode("-", $status_filter);
			foreach ($statuses as $status) {
				array_push($or, array("term" => array("status" => $status)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("status" => array("terms" => array("field" => "status", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['status']['buckets'] as $status) {
			$statuss = Status::where('id' , '=', $status['key']);
			if ($statuss->count()) {
				$entity = $statuss->first();
				$name = $entity->status;
				$count = $status['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $status['key'], "title" => $title, "count" => $count);
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

	public function findSelectedFilter($filters, $aggregations, $status_filter)
	{
		if (!empty($status_filter)) {
			$values = array();
			$status_ranges = explode("-", $status_filter);
			foreach ($status_ranges as $status_range) {
				$statuses = Status::where('id' , '=', $status_range);
				if ($statuses->count()) {
					$title = '';
					if (array_key_exists($status_range, $aggregations['status'])) {
						$title = $statuses->first()->status . ' (' .  $aggregations['status'][$status_range]['count'] . ')';
					} else {
						$title = $statuses->first()->status . ' (0)';
					}
					
					array_push($values, array("title" => $title, "index" => 'status-remove-' . $status_range));
				}
			}

			array_push($filters, array("name" => "Condition", "values" => $values));
		}

		return $filters;
	}
}