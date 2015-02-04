<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	protected $utility_price;
	protected $utility_miles;
	protected $utility_description;
	protected $utility_trim;
	protected $utility_transmission;
	protected $utility_engine;
	protected $utility_dealer;
	protected $utility_image;

	public function __construct() {
    	$this->utility_price = new UtilityPrice();
    	$this->utility_miles = new UtilityMiles();
    	$this->utility_description = new UtilityDescription();
    	$this->utility_trim = new UtilityTrim();
    	$this->utility_transmission = new UtilityTransmission();
    	$this->utility_engine = new UtilityEngine();
    	$this->utility_dealer = new UtilityDealer();
    	$this->utility_image = new UtilityImage();
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
		$and = $this->utility_price->buildFilterQuery($and, Input::get('price', ''));

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
			$sort = $this->utility_price->buildSortQuery($sort, $sort_order);
		} else if ($sort_by == 'miles') {
			$sort = $this->utility_miles->buildSortQuery($sort, $sort_order);
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

			$price = $this->utility_price->getValue($source);
			$miles = $this->utility_miles->getValue($source);
			$description = $this->utility_description->getValue($source);
			$trim = $this->utility_trim->getValue($source);
			$transmission = $this->utility_transmission->getValue($source);
			$engine = $this->utility_engine->getValue($source);
			$dealer_address = $this->utility_dealer->getValue($source);
			$image = $this->utility_image->getValue($source);

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
		$filters = $this->utility_price->findSelectedFilter($filters, Input::get('price', ''));

		return $filters;
	}
}
