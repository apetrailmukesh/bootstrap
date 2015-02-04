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

	public function findSelectedFilter($filters, $price_filter)
	{
		if (!empty($price_filter)) {
			$values = array();
			$price_ranges = explode("-", $price_filter);
			foreach ($price_ranges as $price_range) {
				if ($price_range == 1) {
					array_push($values, array("title" => "Up to $10,000", "index" => 'price-remove-'.$price_range));
				} else if ($price_range == 2) {
					array_push($values, array("title" => "$10,000 - $20,000", "index" => 'price-remove-'.$price_range));
				} else if ($price_range == 3) {
					array_push($values, array("title" => "$20,000 - $30,000", "index" => 'price-remove-'.$price_range));
				} else if ($price_range == 4) {
					array_push($values, array("title" => "$30,000 - $40,000", "index" => 'price-remove-'.$price_range));
				} else if ($price_range == 5) {
					array_push($values, array("title" => "$40,000 - $50,000", "index" => 'price-remove-'.$price_range));
				} else if ($price_range == 6) {
					array_push($values, array("title" => "Over $50,000", "index" => 'price-remove-'.$price_range));
				}
			}

			array_push($filters, array("name" => "Price", "values" => $values));
		}

		return $filters;
	}
}