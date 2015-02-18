<?php

class UtilityCertified {

	public function buildFilterQuery($and, $certified_filter)
	{
		if (!empty($certified_filter)) {
			$or = array();
			$certified_ranges = explode("-", $certified_filter);
			foreach ($certified_ranges as $certified_range) {
				if ($certified_range == 1) {
					array_push($or, array("term" => array("certified" => 1)));
				} else if ($certified_range == 2) {
					array_push($or, array("term" => array("certified" => 0)));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildCertifiedAggregationQuery()
	{
		return array("certified" => array("filter" => array("term" => array("certified" => 1))));
	}

	public function buildNotCertifiedAggregationQuery()
	{
		return array("not_certified" => array("filter" => array("term" => array("certified" => 0))));
	}

	public function decodeAggregation($available, $not_available)
	{
		$values = array(
			'1' => $available['aggregations']['certified']['doc_count'],
			'2' => $not_available['aggregations']['not_certified']['doc_count']
		);

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $certified_filter)
	{
		if (!empty($certified_filter)) {
			$values = array();
			$certified_ranges = explode("-", $certified_filter);
			foreach ($certified_ranges as $certified_range) {
				$title = '';
				if ($certified_range == 1) {
					$title = "Certified";
				} else if ($certified_range == 2) {
					$title = "Not Certified";
				}

				$title = $title . " (" . $aggregations['certified'][$certified_range] . ")";
				array_push($values, array("title" => $title, "index" => 'certified-remove-' . $certified_range));
			}

			array_push($filters, array("name" => "Certification", "values" => $values));
		}

		return $filters;
	}
}