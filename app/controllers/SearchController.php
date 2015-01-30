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

		$response = $this->executeSearch();

		$input = Input::all();
		$data = array(
			'search_text' => $search_text,
			'location_info' => $location_info,
			'total' => $response['total'],
			'results' => $response['results']
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

			$price_specification = 'Price';
			$price = '';
			if (array_key_exists($price_specification, $specifications)) {
				$price = '$ ' . $specifications[$price_specification];
			}

			$miles_specification = 'Miles';
			$miles = '';
			if (array_key_exists($miles_specification, $specifications)) {
				$miles = $specifications[$miles_specification] . ' mi.';
			}

			$description_specification = 'Description';
			$description = '';
			if (array_key_exists($description_specification, $specifications)) {
				$description = $specifications[$description_specification];
				$description = strip_tags($description);
				if (strlen($description) > 500) {
				    $stringCut = substr($description, 0, 250);
				    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="#">Read More</a>'; 
				}
			}

			$trim_specification = 'Trim';
			$trim = '';
			if (array_key_exists($trim_specification, $specifications)) {
				$trim = $specifications[$trim_specification];
			}

			$transmission_specification = 'Transmission';
			$transmission = '';
			if (array_key_exists($transmission_specification, $specifications)) {
				$transmission = $specifications[$transmission_specification];
			}

			$engine_specification = 'Engine';
			$engine = '';
			if (array_key_exists($engine_specification, $specifications)) {
				$engine = $specifications[$engine_specification];
			}

			$dealer_address_specification = 'DealerAddress';
			$dealer_address = '';
			if (array_key_exists($dealer_address_specification, $specifications)) {
				$dealer_address = 'in ' . $specifications[$dealer_address_specification];
			}

			$image_specification = 'ImageUrls';
			$image = 'images/vehicle-01.png';
			if (array_key_exists($image_specification, $specifications)) {
				$image = $specifications[$image_specification];
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

		$total = $search_results['hits']['total'];

		$response = array(
			'total' => $total,
			'results' => $results
		);

		return $response;		
	}
}
