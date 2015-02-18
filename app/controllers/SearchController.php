<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	protected $utility_make;
	protected $utility_model;
	protected $utility_price;
	protected $utility_mileage;
	protected $utility_feature;
	protected $utility_transmission;
	protected $utility_dealer;
	protected $utility_photo;
	protected $utility_year;
	protected $utility_status;
	protected $utility_body;
	protected $utility_certified;
	protected $utility_interior;
	protected $utility_exterior;
	protected $utility_doors;
	protected $utility_cylinders;
	protected $utility_fuel;
	protected $utility_drive;

	public function __construct() {
		$this->utility_make = new UtilityMake();
		$this->utility_model = new UtilityModel();
    	$this->utility_price = new UtilityPrice();
    	$this->utility_mileage = new UtilityMileage();
    	$this->utility_feature = new UtilityFeature();
    	$this->utility_transmission = new UtilityTransmission();
    	$this->utility_dealer = new UtilityDealer();
    	$this->utility_photo = new UtilityPhoto();
    	$this->utility_year = new UtilityYear();
    	$this->utility_status = new UtilityStatus();
    	$this->utility_certified = new UtilityCertified();
    	$this->utility_exterior = new UtilityExterior();
    	$this->utility_interior = new UtilityInterior();
    	$this->utility_drive = new UtilityDrive();
    	$this->utility_fuel = new UtilityFuel();
    	$this->utility_doors = new UtilityDoors();
    	$this->utility_cylinders = new UtilityCylinders();
    	$this->utility_body = new UtilityBody();
  	}

	public function index()
	{
		$this->layout->body_class = 'srp';

		$zip_code = Input::query('zip_code', '');
		$distance = Input::query('distance', '50');
		$search_text = Input::query('search_text', '');

		if (empty($zip_code)) {
			$this->findLocation();
			$zip_code = Session::get('zip_code', '');
		}

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
					if ($distance == 0) {
						$location_info = 'unlimited miles from ' . $city . ', ' . $state . ' (change)';
					} else {
						$location_info = $distance . ' miles from ' . $city . ', ' . $state . ' (change)';
					}

					$title = $title . ' near ' . $city . ', ' . $state;
				}
			}
		}

		$results = $this->executeSearch();
		$aggregations = $this->executeAggregations();
		$filters = $this->findSelectedFilters($aggregations);

		$input = Input::all();
		$data = array(
			'zip_code' => $zip_code,
			'distance' => $distance,
			'search_text' => $search_text,
			'title' => $title,
			'location_info' => $location_info,
			'total' => $results['total'],
			'filters' => $filters,
			'results' => $results['results'],
			'aggregations' => $aggregations
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
		
		$filter = $this->buildFilterQuery('none');
		$sort = $this->buildSortQuery();
		$query = $this->buildSearchQuery($filter);

		$search_query = array(
			"from" => $from,
			"size" => 10,
			"sort" => $sort,
			"query" => $query
			);

		return $search_query;
	}

	public function buildSearchQuery($filter)
	{
		$query;

		if ($filter == false) {
			$query = array("match_all" => array());
		} else {
			$query = array("constant_score" => array ("filter" => $filter));
		}

		return $query;
	}

	public function buildFilterQuery($exclude)
	{
		$and = array();

		$zip_code = Input::query('zip_code', '');
		$distance = Input::query('distance', '50');
		if (!empty($zip_code) && !empty($distance)) {
			$locations = Location::where('zip_code' , '=', $zip_code);
			if ($locations->count()) {
				$location = Location::where('zip_code' , '=', $zip_code)->first();
				$latitude = $location->latitude;
				$longitude = $location->longitude;
				$distance = ($distance * 1.609344) . 'km';
				array_push($and, array("geo_distance" => array("pin.location" => array("lat" => $latitude, "lon" => $longitude), "distance" => $distance)));
			}	
		}

		if ($exclude != 'make') {
			$and = $this->utility_make->buildFilterQuery($and, Input::get('make', ''));
		}

		if ($exclude != 'model') {
			$and = $this->utility_model->buildFilterQuery($and, Input::get('model', ''));
		}

		if ($exclude != 'price') {
			$and = $this->utility_price->buildFilterQuery($and, Input::get('price', ''));
		}

		if ($exclude != 'mileage') {
			$and = $this->utility_mileage->buildFilterQuery($and, Input::get('mileage', ''));
		}

		if ($exclude != 'photo') {
			$and = $this->utility_photo->buildFilterQuery($and, Input::get('photo', ''));
		}

		if ($exclude != 'transmission') {
			$and = $this->utility_transmission->buildFilterQuery($and, Input::get('transmission', ''));
		}

		if ($exclude != 'year') {
			$and = $this->utility_year->buildFilterQuery($and, Input::get('year', ''));
		}

		if ($exclude != 'status') {
			$and = $this->utility_status->buildFilterQuery($and, Input::get('status', ''));
		}

		if ($exclude != 'body') {
			$and = $this->utility_body->buildFilterQuery($and, Input::get('body', ''));
		}

		if ($exclude != 'certified') {
			$and = $this->utility_certified->buildFilterQuery($and, Input::get('certified', ''));
		}

		if ($exclude != 'doors') {
			$and = $this->utility_doors->buildFilterQuery($and, Input::get('doors', ''));
		}

		if ($exclude != 'cylinders') {
			$and = $this->utility_cylinders->buildFilterQuery($and, Input::get('cylinders', ''));
		}

		if ($exclude != 'fuel') {
			$and = $this->utility_fuel->buildFilterQuery($and, Input::get('fuel', ''));
		}

		if ($exclude != 'drive') {
			$and = $this->utility_drive->buildFilterQuery($and, Input::get('drive', ''));
		}

		if ($exclude != 'interior') {
			$and = $this->utility_interior->buildFilterQuery($and, Input::get('interior', ''));
		}

		if ($exclude != 'exterior') {
			$and = $this->utility_exterior->buildFilterQuery($and, Input::get('exterior', ''));
		}

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
		} else if ($sort_by == 'mileage') {
			$sort = $this->utility_mileage->buildSortQuery($sort, $sort_order);
		} else if ($sort_by == 'year') {
			$sort = $this->utility_year->buildSortQuery($sort, $sort_order);
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
			$url = $source['url'];

			$make = $this->utility_make->getValue($source);
			$model = $this->utility_model->getValue($source);
			$price = $this->utility_price->getValue($source);
			$mileage = $this->utility_mileage->getValue($source);
			$trim = $this->utility_feature->getValue($source);
			$transmission = $this->utility_transmission->getValue($source);
			$dealer = $this->utility_dealer->getName($source);
			$dealer_address = $this->utility_dealer->getAddress($source);
			$image = $this->utility_photo->getValue($source);

			$result = array(
				'year' => $year,
				'make' => $make,
				'model' => $model,
				'url' => $url,
				'dealer' => $dealer,
				'price' => $price,
				'mileage' => $mileage,
				'trim' => $trim,
				'transmission' => $transmission,
				'dealer_address' => $dealer_address,
				'image' => $image
				);

			array_push($results, $result);
		}

		return $results;
	}

	public function executeAggregations()
	{
		$content = '';
		
		$filter = $this->buildFilterQuery('price');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_price->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('mileage');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_mileage->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('transmission');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_transmission->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('year');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_year->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('make');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_make->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('model');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_model->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('status');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_status->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('body');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_body->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('interior');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_interior->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('exterior');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_exterior->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('fuel');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_fuel->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('drive');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_drive->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('doors');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_doors->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('cylinders');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_cylinders->buildAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('photo');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_photo->buildAvailableAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;
		$aggs = $this->utility_photo->buildNotAvailableAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;

		$filter = $this->buildFilterQuery('certified');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_certified->buildCertifiedAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;
		$aggs = $this->utility_certified->buildNotCertifiedAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;
		
		$url = "http://localhost:9200/vehicles/vehicle/_msearch";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

		$json_response = curl_exec($curl);
		curl_close($curl);

		$results = json_decode($json_response, true);

		$aggregations = array(
			"price" => $this->utility_price->decodeAggregation($results['responses'][0]),
			"mileage" => $this->utility_mileage->decodeAggregation($results['responses'][1]),
			"transmission" => $this->utility_transmission->decodeAggregation($results['responses'][2]),
			"year" => $this->utility_year->decodeAggregation($results['responses'][3]),
			"make" => $this->utility_make->decodeAggregation($results['responses'][4]),
			"model" => $this->utility_model->decodeAggregation($results['responses'][5]),
			"status" => $this->utility_status->decodeAggregation($results['responses'][6]),
			"body" => $this->utility_body->decodeAggregation($results['responses'][7]),
			"interior" => $this->utility_interior->decodeAggregation($results['responses'][8]),
			"exterior" => $this->utility_exterior->decodeAggregation($results['responses'][9]),
			"fuel" => $this->utility_fuel->decodeAggregation($results['responses'][10]),
			"drive" => $this->utility_drive->decodeAggregation($results['responses'][11]),
			"doors" => $this->utility_doors->decodeAggregation($results['responses'][12]),
			"cylinders" => $this->utility_cylinders->decodeAggregation($results['responses'][13]),
			"photo" => $this->utility_photo->decodeAggregation($results['responses'][14], $results['responses'][15]),
			"certified" => $this->utility_certified->decodeAggregation($results['responses'][16], $results['responses'][17]),
		);

		return $aggregations;
	}

	public function findSelectedFilters($aggregations) 
	{
		$filters = array();

		$filters = $this->utility_make->findSelectedFilter($filters, $aggregations, Input::get('make', ''));
		$filters = $this->utility_model->findSelectedFilter($filters, $aggregations, Input::get('model', ''));
		$filters = $this->utility_price->findSelectedFilter($filters, $aggregations, Input::get('price', ''));
		$filters = $this->utility_mileage->findSelectedFilter($filters, $aggregations, Input::get('mileage', ''));
		$filters = $this->utility_year->findSelectedFilter($filters, $aggregations, Input::get('year', ''));
		$filters = $this->utility_body->findSelectedFilter($filters, $aggregations, Input::get('body', ''));
		$filters = $this->utility_certified->findSelectedFilter($filters, $aggregations, Input::get('certified', ''));
		$filters = $this->utility_exterior->findSelectedFilter($filters, $aggregations, Input::get('exterior', ''));
		$filters = $this->utility_interior->findSelectedFilter($filters, $aggregations, Input::get('interior', ''));
		$filters = $this->utility_cylinders->findSelectedFilter($filters, $aggregations, Input::get('cylinders', ''));
		$filters = $this->utility_transmission->findSelectedFilter($filters, $aggregations, Input::get('transmission', ''));
		$filters = $this->utility_drive->findSelectedFilter($filters, $aggregations, Input::get('drive', ''));
		$filters = $this->utility_fuel->findSelectedFilter($filters, $aggregations, Input::get('fuel', ''));
		$filters = $this->utility_doors->findSelectedFilter($filters, $aggregations, Input::get('doors', ''));
		$filters = $this->utility_status->findSelectedFilter($filters, $aggregations, Input::get('status', ''));
		$filters = $this->utility_photo->findSelectedFilter($filters, $aggregations, Input::get('photo', ''));

		return $filters;
	}

	public function findLocation()
	{
		$location_searched = Session::get('location_searched', '');
		if (empty($location_searched)) {
			$ip_address = $_SERVER['REMOTE_ADDR'];

			if(!empty($ip_address) && filter_var($ip_address, FILTER_VALIDATE_IP)) {
				$url = 'http://www.telize.com/geoip/'. $ip_address;
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$json_response = curl_exec($curl);
				curl_close($curl);
				Session::put('location_searched', 'true');

				$location = json_decode($json_response, true);
				
				if (array_key_exists('postal_code', $location)) {
					$zip_code = $location['postal_code'];
					Session::put('zip_code', $zip_code);
				}
			}
		}
	}
}
