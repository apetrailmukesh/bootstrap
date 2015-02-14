<?php

class UtilityDrive {

	public function buildFilterQuery($and, $drive_filter)
	{
		if (!empty($drive_filter)) {
			$or = array();
			$drives = explode("-", $drive_filter);
			foreach ($drives as $drive) {
				array_push($or, array("term" => array("drive" => $drive)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("drive" => array("terms" => array("field" => "drive", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['drive']['buckets'] as $drive) {
			$drives = Drive::where('id' , '=', $drive['key']);
			if ($drives->count()) {
				$entity = $drives->first();
				$name = $entity->drive;
				$count = $drive['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $drive['key'], "title" => $title, "count" => $count);
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

	public function findSelectedFilter($filters, $aggregations, $drive_filter)
	{
		if (!empty($drive_filter)) {
			$values = array();
			$drive_ranges = explode("-", $drive_filter);
			foreach ($drive_ranges as $drive_range) {
				$drives = Drive::where('id' , '=', $drive_range);
				if ($drives->count()) {
					$title = '';
					if (array_key_exists($drive_range, $aggregations['drive'])) {
						$title = $drives->first()->drive . ' (' .  $aggregations['drive'][$drive_range]['count'] . ')';
					} else {
						$title = $drives->first()->drive . ' (0)';
					}
					
					array_push($values, array("title" => $title, "index" => 'drive-remove-' . $drive_range));
				}
			}

			array_push($filters, array("name" => "Drivetrain", "values" => $values));
		}

		return $filters;
	}
}