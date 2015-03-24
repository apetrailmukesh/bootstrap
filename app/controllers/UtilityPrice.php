<?php

class UtilityPrice {

	public function getValue($source)
	{
		$price = 'Call for price';
		if (array_key_exists('price', $source) && is_numeric($source['price'])) {
			$price = '$ ' . number_format($source['price']);
		}

		return $price;
	}

	public function buildSortQuery($sort, $sort_order)
	{
		if ($sort_order == '1') {
			array_push($sort, array('price' => array("order" => "desc", "mode" => "min")));
		} else if ($sort_order == 0) {
			array_push($sort, array('price' => array("order" => "asc", "mode" => "min")));
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
					array_push($or, array("range" => array('price' => array("lte" => 5000))));
				} else if ($price_range == 2) {
					array_push($or, array("range" => array('price' => array("gt" => 5000, "lte" => 10000))));
				} else if ($price_range == 3) {
					array_push($or, array("range" => array('price' => array("gt" => 10000, "lte" => 15000))));
				} else if ($price_range == 4) {
					array_push($or, array("range" => array('price' => array("gt" => 15000, "lte" => 20000))));
				} else if ($price_range == 5) {
					array_push($or, array("range" => array('price' => array("gt" => 20000, "lte" => 30000))));
				} else if ($price_range == 6) {
					array_push($or, array("range" => array('price' => array("gt" => 30000, "lte" => 40000))));
				} else if ($price_range == 7) {
					array_push($or, array("range" => array('price' => array("gt" => 40000, "lte" => 50000))));
				} else if ($price_range == 8) {
					array_push($or, array("range" => array('price' => array("gt" => 50000))));
				}
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildCustomFilterQuery($and, $price_filter)
	{
		if (!empty($price_filter)) {
			$price_ranges = explode("-", $price_filter);
			if (count($price_ranges) == 2) {
				$min = $price_ranges[0];
				$max = $price_ranges[1];

				if ($min < $max) {
					array_push($and, array("range" => array('price' => array("gte" => $min, "lte" => $max))));
				}
			}
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		$price_ranges = array();
		array_push($price_ranges, array("key" => "1", "to" => "5001"));
		array_push($price_ranges, array("key" => "2", "from" => "5001", "to" => "10001"));
		array_push($price_ranges, array("key" => "3", "from" => "10001", "to" => "15001"));
		array_push($price_ranges, array("key" => "4", "from" => "15001", "to" => "20001"));
		array_push($price_ranges, array("key" => "5", "from" => "20001", "to" => "30001"));
		array_push($price_ranges, array("key" => "6", "from" => "30001", "to" => "40001"));
		array_push($price_ranges, array("key" => "7", "from" => "40001", "to" => "50001"));
		array_push($price_ranges, array("key" => "8", "from" => "50001"));
		$price_range = array("field" => 'price', "keyed" => true, "ranges" => $price_ranges);
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
			'7' => $prices['7']['doc_count'],
			'8' => $prices['8']['doc_count'],
		);

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $price_filter, $price_custom_filter)
	{
		if (!empty($price_filter)) {
			$values = array();
			$price_ranges = explode("-", $price_filter);
			foreach ($price_ranges as $price_range) {
				$title = '';
				if ($price_range == 1) {
					$title = "Up to $5,000";
				} else if ($price_range == 2) {
					$title = "$5,001 - $10,000";
				} else if ($price_range == 3) {
					$title = "$10,001 - $15,000";
				} else if ($price_range == 4) {
					$title = "$15,001 - $20,000";
				} else if ($price_range == 5) {
					$title = "$20,001 - $30,000";
				} else if ($price_range == 6) {
					$title = "$30,001 - $40,000";
				} else if ($price_range == 7) {
					$title = "$40,001 - $50,000";
				} else if ($price_range == 8) {
					$title = "Over $50,000";
				}

				array_push($values, array("title" => $title, "index" => 'price-remove-' . $price_range));
			}

			array_push($filters, array("name" => "Price", "values" => $values, "modal" => "price"));
		} else if (!empty($price_custom_filter)) {
			$price_ranges = explode("-", $price_custom_filter);
			if (count($price_ranges) == 2) {
				$min = $price_ranges[0];
				$max = $price_ranges[1];

				if ($min < $max) {
					$title = '$' . number_format($min) . ' - $' . number_format($max);
					$values = array();
					array_push($values, array("title" => $title, "index" => 'price-custom-remove'));
					array_push($filters, array("name" => "Price", "values" => $values, "modal" => "price"));
				}
			}
		}

		return $filters;
	}
}