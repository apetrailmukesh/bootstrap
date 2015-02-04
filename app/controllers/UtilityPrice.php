<?php

class UtilityPrice {

	protected $price_specification = 'spec-20';

	public function getValue($source)
	{
		$price = 'Contact us for price';
		if (array_key_exists($this->price_specification, $source) && is_numeric($source[$this->price_specification])) {
			$price = '$ ' . $source[$this->price_specification];
		}

		return $price;
	}

	public function buildSortQuery($sort, $sort_order)
	{
		if ($sort_order == '1') {
			array_push($sort, array($this->price_specification => array("order" => "desc", "mode" => "min")));
		} else if ($sort_order == 0) {
			array_push($sort, array($this->price_specification => array("order" => "asc", "mode" => "min")));
		}

		return $sort;
	}

	public function buildFilterQuery($and, $price_filter)
	{
		if (!empty($price_filter)) {
			$or = array();
			$price_ranges = explode("-", $price_filter);
			foreach ($price_ranges as $price_range) {
				if ($price_range == 1) {
					array_push($or, array("range" => array($this->price_specification => array("lte" => 10000))));
				} else if ($price_range == 2) {
					array_push($or, array("range" => array($this->price_specification => array("gt" => 10000, "lte" => 20000))));
				} else if ($price_range == 3) {
					array_push($or, array("range" => array($this->price_specification => array("gt" => 20000, "lte" => 30000))));
				} else if ($price_range == 4) {
					array_push($or, array("range" => array($this->price_specification => array("gt" => 30000, "lte" => 40000))));
				} else if ($price_range == 5) {
					array_push($or, array("range" => array($this->price_specification => array("gt" => 40000, "lte" => 50000))));
				} else if ($price_range == 6) {
					array_push($or, array("range" => array($this->price_specification => array("gt" => 50000))));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		$price_ranges = array();
		array_push($price_ranges, array("key" => "1", "to" => "10000"));
		array_push($price_ranges, array("key" => "2", "from" => "10001", "to" => "20000"));
		array_push($price_ranges, array("key" => "3", "from" => "20001", "to" => "30000"));
		array_push($price_ranges, array("key" => "4", "from" => "30001", "to" => "40000"));
		array_push($price_ranges, array("key" => "5", "from" => "40001", "to" => "50000"));
		array_push($price_ranges, array("key" => "6", "from" => "50001"));
		$price_range = array("field" => $this->price_specification, "keyed" => true, "ranges" => $price_ranges);
		$price = array("range" => $price_range);

		$aggs = array("price" => $price);

		return $aggs;
	}

	public function decodeAggregation($results)
	{
		$prices = $results['aggregations']['price']['buckets'];

		$values = array(
			'1' => $prices['1']['doc_count'],
			'2' => $prices['2']['doc_count'],
			'3' => $prices['3']['doc_count'],
			'4' => $prices['4']['doc_count'],
			'5' => $prices['5']['doc_count'],
			'6' => $prices['6']['doc_count'],
		);

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $price_filter)
	{
		if (!empty($price_filter)) {
			$values = array();
			$price_ranges = explode("-", $price_filter);
			foreach ($price_ranges as $price_range) {
				$title = '';
				if ($price_range == 1) {
					$title = "Up to $10,000";
				} else if ($price_range == 2) {
					$title = "$10,000 - $20,000";
				} else if ($price_range == 3) {
					$title = "$20,000 - $30,000";
				} else if ($price_range == 4) {
					$title = "$30,000 - $40,000";
				} else if ($price_range == 5) {
					$title = "$40,000 - $50,000";
				} else if ($price_range == 6) {
					$title = "Over $50,000";
				}

				$title = $title . " (" . $aggregations['price'][$price_range] . ")";
				array_push($values, array("title" => $title, "index" => 'price-remove-' . $price_range));
			}

			array_push($filters, array("name" => "Price", "values" => $values));
		}

		return $filters;
	}
}