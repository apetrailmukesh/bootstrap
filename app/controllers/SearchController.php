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

		$location_info = '';
		if (!empty($zip_code) && !empty($distance)) {
			$location_info = $distance . ' miles from ' . $zip_code;
		}

		$title = $search_text;
		if (!empty($zip_code)) {
			$title = $title . ' near ' . $zip_code;
		}


		$response = $this->executeSearch();

		$input = Input::all();
		$data = array(
			'search_text' => $search_text,
			'title' => $title,
			'location_info' => $location_info,
			'total' => $response['total'],
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
			'results' => $results
		);

		return $response;		
	}

	public function buildQuery() 
	{
		$from = (Input::get('page', '1') - 1 ) * 10;
		$search_text = Input::get('search_text', '');
		$sort = $this->buildSortQuery();

		$query = array(
			"from" => $from,
			"size" => 10,
			"sort" => $sort,
		    "query" => array(
		        "term" => array(
		        	"_all" => $search_text
		        )
		    )
		);

		return $query;
	}

	public function buildSortQuery() 
	{
		$sort = array();

		$sort_parameters = explode("-", Input::get('sort', 'price-1'));
		$sort_by = $sort_parameters[0];
		$sort_order = $sort_parameters[1];

		if ($sort_by == 'price') {
			if ($sort_order == '1') {
				array_push($sort, array("specifications.Price" => array("order" => "desc", "mode" => "min")));
			} else if ($sort_order == 0) {
				array_push($sort, array("specifications.Price" => array("order" => "asc", "mode" => "min")));
			}
		} else if ($sort_by == 'miles') {
			if ($sort_order == '1') {
				array_push($sort, array("specifications.Miles" => array("order" => "desc", "mode" => "min")));
			} else if ($sort_order == 0) {
				array_push($sort, array("specifications.Miles" => array("order" => "asc", "mode" => "min")));
			}
		} else if ($sort_by == 'year') {
			if ($sort_order == '1') {
				array_push($sort, array("year" => array("order" => "desc")));
			} else if ($sort_order == 0) {
				array_push($sort, array("year" => array("order" => "asc")));
			}
		}

		array_push($sort, array("_score" => array("order" => "desc")));

		return $sort;
	}

	public function decodeResults($search_results)
	{
		$results = array();
		foreach ($search_results['hits']['hits'] as $value) {
			$year = $value['_source']['year'];
			$make = $value['_source']['make'];
			$model = $value['_source']['model'];
			$url = $value['_source']['url'];
			$dealer = $value['_source']['dealer'];

			$specifications = $value['_source']['specifications'];

			$price_specification = 'Price';
			$price = 'Contact us for price';
			if (array_key_exists($price_specification, $specifications) && is_numeric($specifications[$price_specification])) {
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
			$image = 'images/empty.png';
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

		return $results;
	}
}
