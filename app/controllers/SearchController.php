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

		if (empty($zip_code)) {
			$this->findLocation();
			$zip_code = Session::get('zip_code', '');
		}

		Session::put('zip_code', $zip_code);
		Session::put('distance', $distance);

		$title = '';

		$make_filter = Input::get('make', '');
		$makes = explode("-", $make_filter);

		$model_filter = Input::get('model', '');
		$models = explode("-", $model_filter);

		foreach ($makes as $make) {
			$entities = Make::where('id' , '=', $make);
			if ($entities->count()) {
				$entity = $entities->first();
				$title = $title . $entity->make . ' ';
			}
		}

		$models_available = false;
		foreach ($models as $model) {
			$entities = Model::where('id' , '=', $model);
			if ($entities->count()) {
				$entity = $entities->first();
				$title = $title . $entity->model . ' - ';

				$models_available = true;
			}
		}

		if ($models_available == true) {
			$title = substr($title, 0, -2);
		}

		$search_title = $title;

		$search_text = '';
		if (sizeof($makes) == 1 && sizeof($models) <= 1) {
			$entities = Make::where('id' , '=', $makes[0]);
			if ($entities->count()) {
				$entity = $entities->first();
				$search_text = $entity->make;

				if (sizeof($models) == 1) {
					$entities = Model::where('id' , '=', $models[0]);
					if ($entities->count()) {
						$entity = $entities->first();
						$search_text = $search_text . ' ' .$entity->model;						
					}
				}
			}
		}

		$search_location = '';
		$location_info = 'change location';
		if (!empty($zip_code)) {
			$locations = Location::where('zip_code' , '=', $zip_code);
			if ($locations->count()) {
				$location = Location::where('zip_code' , '=', $zip_code)->first();
				$city = $location->city;
				$state = $location->state;
				if (!empty($city) && !empty($state)) {
					if ($distance == 0) {
						$search_location = 'Within ' . 'unlimited miles from ' . $city . ', ' . $state;
						$location_info = 'unlimited miles from ' . $city . ', ' . $state . ' (change)';
					} else {
						$search_location = 'Within ' . $distance . ' miles from ' . $city . ', ' . $state;
						$location_info = $distance . ' miles from ' . $city . ', ' . $state . ' (change)';
					}

					if (strlen($title) > 0) {
						$title = $title . ' near ' . $city . ', ' . $state;
					}
				}
			}
		}

		$results = $this->executeSearch();
		$aggregations = $this->executeAggregations();
		$selected_filters = $this->findSelectedFilters($aggregations);
		$remaining_filters = $this->findRemainingFilters();

		$search_filter = '';
		foreach($selected_filters as $filter) {
			$search_filter = $search_filter . '<strong -class->' . $filter['name'] . ':' . '</strong>';
			foreach($filter['values'] as $value) {
				$search_filter = $search_filter . $value['title'] . ',';
			}
			$search_filter = substr($search_filter, 0, -1) . ' ';
		}

		$paid = $aggregations['paid'];
		$page = Input::get('page', '1');
		$from = ($page - 1 ) * 10;
		$featured = -1;
		$standard = -1;
		if ($paid > 0 && $page == 1) {
			$featured = 0;
		}

		if ($from == $paid) {
			$standard = 0;
		} else if ($paid - $from < 9) {
			$standard = $paid - $from;
		}

		$new_status_id = '';
		$used_status_id = '';
		$statuses = Status::all();
		foreach ($statuses as $status) {
			if ($status->status == 'Used') {
				$used_status_id = $status->id;
			} else if ($status->status == 'New') {
				$new_status_id = $status->id;
			}
		}

		$tab = array();
		$tab['all_link'] = '';
		$tab['new_link'] = $new_status_id;
		$tab['used_link'] = $used_status_id;

		$all_count = 0;
		$new_count = 0;
		$used_count = 0;

		$status_aggs = $aggregations['status'];
		if (array_key_exists($new_status_id, $status_aggs)) {
			$new_count = $status_aggs[$new_status_id]['count'];
		}
 		
		if (array_key_exists($used_status_id, $status_aggs)) {
			$used_count = $status_aggs[$used_status_id]['count'];
		}

		$all_count = $new_count + $used_count;

		$tab['all_count'] = '(' . $all_count . ')';
 		$tab['new_count'] = '(' . $new_count . ')';
		$tab['used_count'] = '(' . $used_count . ')';

		$tab['all_class'] = 'inactive';
		$tab['new_class'] = 'inactive';
		$tab['used_class'] = 'inactive';

		$selected_status = Input::get('status', '');
		if ($selected_status == $new_status_id) {
			$tab['new_class'] = 'active';
		} else if ($selected_status == $used_status_id) {
			$tab['used_class'] = 'active';
		} else {
			$tab['all_class'] = 'active';
		}

		$save_search_popup = 'saveSearchModalGuest';
		$save_vehicle_popup = 'saveVehicleModalGuest';
		if(Auth::check()){
			$save_search_popup = 'saveSearchModalUser';
			$save_vehicle_popup = 'saveVehicleModalUser';			
		}

		$data = array(
			'zip_code' => $zip_code,
			'distance' => $distance,
			'search_text' => $search_text,
			'title' => $title,
			'location_info' => $location_info,
			'total' => $results['total'],
			'selected_filters' => $selected_filters,
			'remaining_filters' => $remaining_filters,
			'results' => $results['results'],
			'aggregations' => $aggregations,
			'standard' => $standard,
			'featured' => $featured,
			'tab' => $tab,
			'save_search_popup' => $save_search_popup,
			'save_vehicle_popup' => $save_vehicle_popup,
			'search_title' => $search_title,
			'search_location' => $search_location,
			'search_filter' => $search_filter
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
			$and = $this->utility_price->buildCustomFilterQuery($and, Input::get('price-custom', ''));
		}

		if ($exclude != 'mileage') {
			$and = $this->utility_mileage->buildFilterQuery($and, Input::get('mileage', ''));
			$and = $this->utility_mileage->buildCustomFilterQuery($and, Input::get('mileage-custom', ''));
		}

		if ($exclude != 'photo') {
			$and = $this->utility_photo->buildFilterQuery($and, Input::get('photo', ''));
		}

		if ($exclude != 'transmission') {
			$and = $this->utility_transmission->buildFilterQuery($and, Input::get('transmission', ''));
		}

		if ($exclude != 'year') {
			$and = $this->utility_year->buildFilterQuery($and, Input::get('year', ''));
			$and = $this->utility_year->buildCustomFilterQuery($and, Input::get('year-custom', ''));
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

		array_push($sort, array("paid" => array("order" => "desc")));

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

		return $sort;
	}

	public function decodeResults($search_results)
	{
		$results = array();
		foreach ($search_results['hits']['hits'] as $value) {
			$source = $value['_source'];

			$vin = $source['vin'];
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
			$body = $this->utility_body->getValue($source);
			$feature = $this->utility_feature->getValue($source);
			$drive = $this->utility_drive->getValue($source);

			$result = array(
				'vin' => $vin,
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
				'image' => $image,
				'body' => $body,
				'feature' => $feature,
				'drive' => $drive
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

		$filter = $this->buildFilterQuery('none');
		$query = $this->buildSearchQuery($filter);
		$aggs = array("paid" => array("filter" => array("term" => array("paid" => 1))));
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
			"paid" => $results['responses'][18]['aggregations']['paid']['doc_count']
		);

		return $aggregations;
	}

	public function findSelectedFilters($aggregations) 
	{
		$filters = array();

		$filters = $this->utility_make->findSelectedFilter($filters, $aggregations, Input::get('make', ''));
		$filters = $this->utility_model->findSelectedFilter($filters, $aggregations, Input::get('model', ''));
		$filters = $this->utility_price->findSelectedFilter($filters, $aggregations, Input::get('price', ''), Input::get('price-custom', ''));
		$filters = $this->utility_mileage->findSelectedFilter($filters, $aggregations, Input::get('mileage', ''), Input::get('mileage-custom', ''));
		$filters = $this->utility_year->findSelectedFilter($filters, $aggregations, Input::get('year', ''), Input::get('year-custom', ''));
		$filters = $this->utility_body->findSelectedFilter($filters, $aggregations, Input::get('body', ''));
		$filters = $this->utility_certified->findSelectedFilter($filters, $aggregations, Input::get('certified', ''));
		$filters = $this->utility_exterior->findSelectedFilter($filters, $aggregations, Input::get('exterior', ''));
		$filters = $this->utility_interior->findSelectedFilter($filters, $aggregations, Input::get('interior', ''));
		$filters = $this->utility_cylinders->findSelectedFilter($filters, $aggregations, Input::get('cylinders', ''));
		$filters = $this->utility_transmission->findSelectedFilter($filters, $aggregations, Input::get('transmission', ''));
		$filters = $this->utility_drive->findSelectedFilter($filters, $aggregations, Input::get('drive', ''));
		$filters = $this->utility_fuel->findSelectedFilter($filters, $aggregations, Input::get('fuel', ''));
		$filters = $this->utility_doors->findSelectedFilter($filters, $aggregations, Input::get('doors', ''));
		$filters = $this->utility_photo->findSelectedFilter($filters, $aggregations, Input::get('photo', ''));

		return $filters;
	}

	public function findRemainingFilters()
	{
		$remaining = array();

		if (empty(Input::get('make', ''))) array_push($remaining, array('name' => "Make", "modal" => "make"));
		if (empty(Input::get('model', ''))) array_push($remaining, array('name' => "Model", "modal" => "model"));
		if (empty(Input::get('price', '')) && empty(Input::get('price-custom', ''))) array_push($remaining, array('name' => "Price", "modal" => "price"));
		if (empty(Input::get('mileage', '')) && empty(Input::get('mileage-custom', ''))) array_push($remaining, array('name' => "Mileage", "modal" => "mileage"));
		if (empty(Input::get('year', '')) && empty(Input::get('year-custom', ''))) array_push($remaining, array('name' => "Year", "modal" => "year"));
		if (empty(Input::get('body', ''))) array_push($remaining, array('name' => "Style", "modal" => "body"));
		if (empty(Input::get('certified', ''))) array_push($remaining, array('name' => "Certification", "modal" => "certified"));
		if (empty(Input::get('exterior', ''))) array_push($remaining, array('name' => "Exterior Color", "modal" => "exterior"));
		if (empty(Input::get('interior', ''))) array_push($remaining, array('name' => "Interior Color", "modal" => "interior"));
		if (empty(Input::get('cylinders', ''))) array_push($remaining, array('name' => "Cylinders", "modal" => "cylinders"));
		if (empty(Input::get('transmission', ''))) array_push($remaining, array('name' => "Transmission", "modal" => "transmission"));
		if (empty(Input::get('drive', ''))) array_push($remaining, array('name' => "Drivetrain", "modal" => "drive"));
		if (empty(Input::get('fuel', ''))) array_push($remaining, array('name' => "Fuel", "modal" => "fuel"));
		if (empty(Input::get('doors', ''))) array_push($remaining, array('name' => "Door Count", "modal" => "doors"));
		if (empty(Input::get('photo', ''))) array_push($remaining, array('name' => "Photos", "modal" => "photo"));

		return $remaining;
	}

	public function findLocation()
	{
		$location_searched = Session::get('location_searched', '');
		if (empty($location_searched)) {
			$zip_code = 90001;
			Session::put('zip_code', $zip_code);
			Session::put('location_searched', 'true');
		}
	}
}
