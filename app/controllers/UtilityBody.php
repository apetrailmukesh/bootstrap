<?php

class UtilityBody {

	protected $body_specification = 'spec-25';

	public function buildFilterQuery($and, $body_filter)
	{
		if (!empty($body_filter)) {
			$or = array();
			$bodys = explode("-", $body_filter);
			foreach ($bodys as $body) {
				array_push($or, array("term" => array($this->body_specification.'raw' => $body)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("body" => array("terms" => array("field" => $this->body_specification.'raw', "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['body']['buckets'] as $body) {
			$name = $body['key'];
			$count = $body['doc_count'];
			$title = $name . ' (' . $count . ')';
			$sorted[$name] = array("key" => $body['key'], "title" => $title, "count" => $count);
		}

		ksort($sorted);

		$counter = 0;
		foreach ($sorted as $value) {
			$values[$value['key']] = array('index' => $counter, 'key' => $value['key'], 'title' => $value['title'], 'count' => $value['count']);
    		$counter++;
		}

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $body_filter)
	{
		if (!empty($body_filter)) {
			$values = array();
			$body_ranges = explode("-", $body_filter);
			foreach ($body_ranges as $body_range) {
				$title = '';
				if (array_key_exists($body_range, $aggregations['body'])) {
					$title = $bodys->first()->body . ' (' .  $aggregations['body'][$body_range]['count'] . ')';
				} else {
					$title = $bodys->first()->body . ' (0)';
				}
					
				array_push($values, array("title" => $title, "index" => 'body-remove-' . $body_range));
			}

			array_push($filters, array("name" => "body", "values" => $values));
		}

		return $filters;
	}
}