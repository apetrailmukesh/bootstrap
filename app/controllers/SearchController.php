<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = 'srp';

		$zip_code = Input::query('zip_code', '');
		$distance = Input::query('distance', '50');
		$search_text = Input::query('search_text', '');

		Session::put('zip_code', $zip_code);
		Session::put('distance', $distance);

		$location_info = 'change location';
		if (!empty($zip_code) && !empty($distance)) {
			$location_info = $distance . ' miles from ' . $zip_code;
		}

		$results = $this->executeSearch();

		$input = Input::all();
		$data = array(
			'search_text' => $search_text,
			'location_info' => $location_info,
			'results' => $results
		);

		$this->layout->contents = View::make('search/search', $data);
	}

	public function search()
	{
		$this->layout->body_class = 'srp';

		$currentQuery = Input::query();
		$queryToAdd = array(
			'search_text' => Input::get('search_text', '')
		);

		$query = array_merge($queryToAdd, $currentQuery);

		return Redirect::route('get.search', $query);
	}

	public function executeSearch()
	{
		$url = "http://localhost:9200/vehicles/vehicle/_search"; 
		$query = array(
		    "query" => array(
		        "term" => array(
		        	"_all" => Input::get('search_text', '')
		        )
		    )
		);

		$content = json_encode($query);
		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

		$json_response = curl_exec($curl);
		curl_close($curl);

		$search_results = json_decode($json_response, true);

		$results = array();
		foreach ($search_results['hits']['hits'] as $value) {
			$year = $value['_source']['year'];
			$make = $value['_source']['make'];
			$model = $value['_source']['model'];
			$url = $value['_source']['url'];
			$dealer = $value['_source']['dealer'];

			$specifications = $value['_source']['specifications'];

			$price_specification = '20';
			$price = '';
			if (array_key_exists($price_specification, $specifications)) {
				$price = '$ ' . $specifications[$price_specification];
			}

			$miles_specification = '4';
			$miles = '';
			if (array_key_exists($miles_specification, $specifications)) {
				$miles = $specifications[$miles_specification] . ' mi.';
			}

			$description_specification = '19';
			$description = '';
			if (array_key_exists($description_specification, $specifications)) {
				$description = substr($specifications[$description_specification], 0, 250);
			}

			$result = array(
				'year' => $year,
				'make' => $make,
				'model' => $model,
				'url' => $url,
				'dealer' => $dealer,
				'price' => $price,
				'miles' => $miles,
				'description' => $description
			);

    		array_push($results, $result);
		}

		return $results;		
	}
}
