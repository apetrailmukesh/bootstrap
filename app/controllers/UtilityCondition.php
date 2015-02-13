<?php

class UtilityCondition {

	protected $condition_specification = 'spec-14';

	public function buildFilterQuery($and, $condition_filter)
	{
		if (!empty($condition_filter)) {
			$or = array();
			$condition_ranges = explode("-", $condition_filter);
			foreach ($condition_ranges as $condition_range) {
				if ($condition_range == 1) {
					array_push($or, array("term" => array($this->condition_specification.'.raw' => "New")));
				} else if ($condition_range == 2) {
					array_push($or, array("term" => array($this->condition_specification.'.raw' => "PreOwned")));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildNewAggregationQuery()
	{
		return array("new" => array("filter" => array("term" => array($this->condition_specification.'.raw' => "New"))));
	}

	public function buildUsedAggregationQuery()
	{
		return array("used" => array("filter" => array("term" => array($this->condition_specification.'.raw' => "PreOwned"))));
	}

	public function decodeAggregation($new, $used)
	{
		$values = array(
			'1' => $new['aggregations']['new']['doc_count'],
			'2' => $used['aggregations']['used']['doc_count']
		);

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $condition_filter)
	{
		if (!empty($condition_filter)) {
			$values = array();
			$condition_ranges = explode("-", $condition_filter);
			foreach ($condition_ranges as $condition_range) {
				$title = '';
				if ($condition_range == 1) {
					$title = "New";
				} else if ($condition_range == 2) {
					$title = "Used";
				}

				$title = $title . " (" . $aggregations['condition'][$condition_range] . ")";
				array_push($values, array("title" => $title, "index" => 'condition-remove-' . $condition_range));
			}

			array_push($filters, array("name" => "condition", "values" => $values));
		}

		return $filters;
	}
}