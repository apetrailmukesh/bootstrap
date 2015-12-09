<?php

class UtilityDealer {

	public function getName($source)
	{
		$value = '';
		if (array_key_exists('dealer', $source)) {
			$values = Dealer::where('id' , '=', $source['dealer']);
			if ($values->count()) {
				$value = $values->first()->dealer;
			}
		}

		return $value;
	}

	public function getAddress($source)
	{
		$dealer_address = '';
		if (array_key_exists('address', $source)) {
			$dealer_address = 'in ' . $source['address'];

			if (array_key_exists('city', $source)) {
				$dealer_address = $dealer_address. ', ' . $source['city'];

				if (array_key_exists('state', $source)) {
					$dealer_address = $dealer_address. ', ' . $source['state'];
				}
			}
		}

		return $dealer_address;
	}

	public function getValue($source)
	{
		$value = '';
		if (array_key_exists('dealer', $source)) {
			$values = Dealer::where('id' , '=', $source['dealer']);
			if ($values->count()) {
				$value = $values->first()->dealer;
			}
		}

		return $value;
	}

	public function buildFilterQuery($and, $dealer_filter)
	{
		if (!empty($dealer_filter)) {
			$or = array();
			$dealers = explode("-", $dealer_filter);
			foreach ($dealers as $dealer) {
				array_push($or, array("term" => array("dealer" => $dealer)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("dealer" => array("terms" => array("field" => "dealer", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['dealer']['buckets'] as $dealer) {
			$dealers = Dealer::where('id' , '=', $dealer['key']);
			if ($dealers->count()) {
				$entity = $dealers->first();
				$name = $entity->dealer;
				$count = $dealer['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $dealer['key'], "title" => $title, "count" => $count);
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

	public function findSelectedFilter($filters, $aggregations, $dealer_filter)
	{
		if (!empty($dealer_filter)) {
			$values = array();
			$dealer_ranges = explode("-", $dealer_filter);
			foreach ($dealer_ranges as $dealer_range) {
				$dealers = Dealer::where('id' , '=', $dealer_range);
				if ($dealers->count()) {
					$title = $dealers->first()->dealer;
					
					array_push($values, array("title" => $title, "index" => 'dealer-remove-' . $dealer_range));
				}
			}

			array_push($filters, array("name" => "Dealer", "values" => $values, "modal" => "dealer"));
		}

		return $filters;
	}
}