<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	protected $utility_make;
	protected $utility_model;
	protected $utility_price;
	protected $utility_mileage;
	protected $utility_description;
	protected $utility_trim;
	protected $utility_transmission;
	protected $utility_engine;
	protected $utility_dealer;
	protected $utility_photo;
	protected $utility_year;

	public function __construct() {
		$this->utility_make = new UtilityMake();
		$this->utility_model = new UtilityModel();
    	$this->utility_price = new UtilityPrice();
    	$this->utility_mileage = new UtilityMileage();
    	$this->utility_description = new UtilityDescription();
    	$this->utility_trim = new UtilityTrim();
    	$this->utility_transmission = new UtilityTransmission();
    	$this->utility_engine = new UtilityEngine();
    	$this->utility_dealer = new UtilityDealer();
    	$this->utility_photo = new UtilityPhoto();
    	$this->utility_year = new UtilityYear();
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
			$mileage = $this->utility_mileage->getValue($source);
			$description = $this->utility_description->getValue($source);
			$trim = $this->utility_trim->getValue($source);
			$transmission = $this->utility_transmission->getValue($source);
			$engine = $this->utility_engine->getValue($source);
			$dealer_address = $this->utility_dealer->getValue($source);
			$image = $this->utility_photo->getValue($source);

			$result = array(
				'year' => $year,
				'make' => $make,
				'model' => $model,
				'url' => $url,
				'dealer' => $dealer,
				'price' => $price,
				'mileage' => $mileage,
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

		$filter = $this->buildFilterQuery('transmission');
		$query = $this->buildSearchQuery($filter);
		$aggs = $this->utility_transmission->buildAutomaticAggregationQuery();
		$search_query = array("size" => 0, "query" => $query, "aggs" => $aggs);
		$sub_query = json_encode($search_query);
		$content = $content . "{}" . PHP_EOL. $sub_query . PHP_EOL;
		$aggs = $this->utility_transmission->buildManualAggregationQuery();
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
			"photo" => $this->utility_photo->decodeAggregation($results['responses'][2], $results['responses'][3]),
			"transmission" => $this->utility_transmission->decodeAggregation($results['responses'][4], $results['responses'][5]),
			"year" => $this->utility_year->decodeAggregation($results['responses'][6]),
			"make" => $this->utility_make->decodeAggregation($results['responses'][7]),
			"model" => $this->utility_model->decodeAggregation($results['responses'][8])
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
		$filters = $this->utility_transmission->findSelectedFilter($filters, $aggregations, Input::get('transmission', ''));
		$filters = $this->utility_photo->findSelectedFilter($filters, $aggregations, Input::get('photo', ''));

		return $filters;
	}
}
