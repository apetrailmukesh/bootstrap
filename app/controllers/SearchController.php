<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	protected $price_specification = 'spec-20';
	protected $miles_specification = 'spec-4';
	protected $description_specification = 'spec-19';
	protected $trim_specification = 'spec-1';
	protected $transmission_specification = 'spec-15';
	protected $engine_specification = 'spec-16';
	protected $dealer_address_specification = 'spec-7';
	protected $image_specification = 'spec-17';

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
		        "match" => array(
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
				array_push($sort, array($this->price_specification => array("order" => "desc", "mode" => "min")));
			} else if ($sort_order == 0) {
				array_push($sort, array($this->price_specification => array("order" => "asc", "mode" => "min")));
			}
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

			$price = 'Contact us for price';
			if (array_key_exists($this->price_specification, $source) && is_numeric($source[$this->price_specification])) {
				$price = '$ ' . $source[$this->price_specification];
			}

			$miles = '';
			if (array_key_exists($this->miles_specification, $source)) {
				$miles = $source[$this->miles_specification] . ' mi.';
			}

			$description = '';
			if (array_key_exists($this->description_specification, $source)) {
				$description = $source[$this->description_specification];
				$description = strip_tags($description);
				if (strlen($description) > 500) {
				    $stringCut = substr($description, 0, 250);
				    $description = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="#">Read More</a>'; 
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
}
