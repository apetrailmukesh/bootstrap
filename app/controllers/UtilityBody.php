<?php

class UtilityBody {

	public function getValue($source)
	{
		$value = '';
		if (array_key_exists('body', $source)) {
			$values = Body::where('id' , '=', $source['body']);
			if ($values->count()) {
				$value = $values->first()->body;
			}
		}

		return $value;
	}

	public function buildFilterQuery($and, $body_filter)
	{
		if (!empty($body_filter)) {
			$or = array();
			$bodies = explode("-", $body_filter);
			foreach ($bodies as $body) {
				array_push($or, array("term" => array("body" => $body)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("body" => array("terms" => array("field" => "body", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['body']['buckets'] as $body) {
			$bodys = Body::where('id' , '=', $body['key']);
			if ($bodys->count()) {
				$entity = $bodys->first();
				$name = $entity->body;
				$count = $body['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $body['key'], "title" => $title, "count" => $count);
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

	public function findSelectedFilter($filters, $aggregations, $body_filter)
	{
		if (!empty($body_filter)) {
			$values = array();
			$body_ranges = explode("-", $body_filter);
			foreach ($body_ranges as $body_range) {
				$bodies = Body::where('id' , '=', $body_range);
				if ($bodies->count()) {
					$title = $bodies->first()->body;
					array_push($values, array("title" => $title, "index" => 'body-remove-' . $body_range));
				}
			}

			array_push($filters, array("name" => "Body Style", "values" => $values, "modal" => "body"));
		}

		return $filters;
	}
}