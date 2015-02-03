<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	protected $miles_specification = 'spec-4';
	protected $description_specification = 'spec-19';
	protected $trim_specification = 'spec-1';
	protected $transmission_specification = 'spec-15';
	protected $engine_specification = 'spec-16';
	protected $dealer_address_specification = 'spec-7';
	protected $image_specification = 'spec-17';

	protected $price_utility;

	public function __construct() {
    	$this->price_utility = new PriceUtility();
  	}

	public function index()
	{
		$this->layout->body_class = 'srp';

		$zip_code = Input::query('zip_code', '');
		$distance = Input::query('distance', '50');
		$search_text = Input::query('search_text', '');

		Session::put('zip_code', $zip_code);
		Session::put('distance', $distance);

		$title = $search_text;
		$location_info = 'change location';
		if (!empty($zip_code)) {
			$locations = Location::where('zip_code' , '=', $zip_code);
			if ($locations->count()) {
				$location = Location::where('zip_code' , '=', $zip_code)->first();
				$city = $location->city;
				$state = $location->state;
				if (!empty($city) && !empty($state)) {
					$location_info = $distance . ' miles from ' . $city . ', ' . $state . ' (change)';
					$title = $title . ' near ' . $city . ', ' . $state;
				}
			}
		}

		$filters = $this->findSelectedFilters();
		$response = $this->executeSearch();

		$input = Input::all();
		$data = array(
			'zip_code' => $zip_code,
			'distance' => $distance,
			'search_text' => $search_text,
			'title' => $title,
			'location_info' => $location_info,
			'total' => $response['total'],
			'filters' => $filters,
			'results' => $response['results']
			);

		$this->layout->contents = View::make('search/search', $data);
	}

	public function executeSearch()
	{
		$content = json_encode($this->buildQuery());
		
		$url = "http://localhost:9200/vehicles/vehicle/_search";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

		$json_response = curl_exec($curl);
		curl_close($curl);

		$search_results = json_decode($json_response, true);

		$results = $this->decodeResults($search_results);
		$total = $search_results['hits']['total'];

		$response = array(
			'total' => $total,
			'results' => $results,
			);

		return $response;		
	}

	public function buildQuery() 
	{
		$from = (Input::get('page', '1') - 1 ) * 10;
		$search_text = Input::get('search_text', '');
		
		$filter = $this->buildFilterQuery();
		$sort = $this->buildSortQuery();
		$query = $this->buildSearchQuery($filter, $search_text);

		$search_query = array(
			"from" => $from,
			"size" => 10,
			"sort" => $sort,
			"query" => $query
			);

		return $search_query;
	}

	public function buildSearchQuery($filter, $search_text)
	{
		$query;

		if (empty($search_text)) {
			if ($filter == false) {
				$query = array("match_all" => array());
			} else {
				$query = array("constant_score" => array ("filter" => $filter));
			}
		} else {
			$search_query = array("multi_match" => array("query" => $search_text, "operator" => "and", "fields" => array("_all")));
			if ($filter == false) {
				$query = $search_query;
			} else {
				$query = array("filtered" => array ("query" => $search_query, "filter" => $filter));
			}
		}

		return $query;
	}

	public function buildFilterQuery()
	{
		$and = array();

		$and = $this->price_utility->buildFilterQuery($and, Input::get('price', ''));

		$filter = array();
		if (sizeof($and) > 0) {
			$filter['and'] = $and;
			return $filter;
		} else {
			return false;
		}
	}

	public function buildSortQuery() 
	{
		$sort = array();

		$sort_parameters = explode("-", Input::get('sort', 'price-1'));
		$sort_by = $sort_parameters[0];
		$sort_order = $sort_parameters[1];

		if ($sort_by == 'price') {
			$sort = $this->price_utility->buildSortQuery($sort, $sort_order);
		} else if ($sort_by == 'miles') {
			if ($sort_order == '1') {
				array_push($sort, array($this->miles_specification => array("order" => "desc", "mode" => "min")));
			} else if ($sort_order == 0) {
				array_push($sort, array($this->miles_specification => array("order" => "asc", "mode" => "min")));
			}
		} else if ($sort_by == 'year') {
			if ($sort_order == '1') {
				array_push($sort, array("year" => array("order" => "desc")));
			} else if ($sort_order == 0) {
				array_push($sort, array("year" => array("order" => "asc")));
			}
		} else if ($sort_by == 'makemodel') {
			array_push($sort, array("make.raw" => array("order" => "asc")));
			array_push($sort, array("model.raw" => array("order" => "asc")));
		}

		array_push($sort, array("_score" => array("order" => "desc")));

		return $sort;
	}

	public function decodeResults($search_results)
	{
		$results = array();
		foreach ($search_results['hits']['hits'] as $value) {
			$source = $value['_source'];
			$year = $source['year'];
			$make = $source['make'];
			$model = $source['model'];
			$url = $source['url'];
			$dealer = $source['dealer'];

			$price = $this->price_utility->getValue($source);

			$miles = '';
			if (array_key_exists($this->miles_specification, $source)) {
				$miles = $source[$this->miles_specification] . ' mi.';
			}

			$description = '';
			if (array_key_exists($this->description_specification, $source)) {
				$description = $source[$this->description_specification];
				$description = strip_tags($description);
				if (strlen($description) > 500) {
					$stringCut = substr($description, 0, 500);
					$description = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
				}
			}

			$trim = '';
			if (array_key_exists($this->trim_specification, $source)) {
				$trim = $source[$this->trim_specification];
			}

			$transmission = '';
			if (array_key_exists($this->transmission_specification, $source)) {
				$transmission = $source[$this->transmission_specification];
			}

			$engine = '';
			if (array_key_exists($this->engine_specification, $source)) {
				$engine = $source[$this->engine_specification];
			}

			$dealer_address = '';
			if (array_key_exists($this->dealer_address_specification, $source)) {
				$dealer_address = 'in ' . $source[$this->dealer_address_specification];
			}

			$image = 'images/empty.png';
			if (array_key_exists($this->image_specification, $source)) {
				$image = $source[$this->image_specification];
			}

			$result = array(
				'year' => $year,
				'make' => $make,
				'model' => $model,
				'url' => $url,
				'dealer' => $dealer,
				'price' => $price,
				'miles' => $miles,
				'description' => $description,
				'trim' => $trim,
				'transmission' => $transmission,
				'engine' => $engine,
				'dealer_address' => $dealer_address,
				'image' => $image
				);

			array_push($results, $result);
		}

		return $results;
	}

	public function findSelectedFilters() 
	{
		$filters = array();

		$filters = $this->price_utility->findSelectedFilter($filters, Input::get('price', ''));

		return $filters;
	}
}

class PriceUtility {

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
