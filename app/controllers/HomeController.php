<?php

class HomeController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = 'home';

		$zip_code = Session::get('zip_code', '');
		$distance = Session::get('distance', '50');
		
		if (empty($zip_code)) {
			$this->findLocation();
			$zip_code = Session::get('zip_code', '');
		}

		$location_info = 'change location';
		if (!empty($zip_code)) {
			$city_name = Session::get('city_name', '');
			$region_name = Session::get('region_name', '');
			if (!empty($zip_code) && !empty($zip_code)) {
				$location_info = $distance . ' miles from ' . $city_name . ', ' . $region_name . ' (change)';
			} else {
				$location_info = $distance . ' miles from ' . $zip_code . ' (change)';
			}
		}

		$data = array(
			'zip_code' => $zip_code,
			'distance' => $distance,
			'location_info' => $location_info
		);

		$this->layout->contents = View::make('home/home', $data);
	}

	public function change()
	{
		$this->layout->body_class = 'home';

		$zip_code = Input::get('zip_code', '');
		$distance = Input::get('distance', '50');

		Session::put('zip_code', $zip_code);
		Session::put('distance', $distance);
		
		$location_info = 'change location';
		if (!empty($zip_code) && !empty($distance)) {
			$location_info = $distance . ' miles from ' . $zip_code . ' (change)';
		}

		$data = array(
			'zip_code' => $zip_code,
			'distance' => $distance,
			'location_info' => $location_info
		);	

		$this->layout->contents = View::make('home/home', $data);
	}

	public function search()
	{
		$this->layout->body_class = 'srp';

		$zip_code = Session::get('zip_code', '');
		$distance = Session::get('distance', '');
		$search_text = Input::get('search_text', '');

		$query = array(
			'zip_code' => $zip_code,
			'distance' => $distance,
			'search_text' => $search_text,
			'page' => 1,
			'sort' => 'price-1'
		);

		return Redirect::route('get.search', $query);
	}

	public function findLocation()
	{
		try {
			$url = "http://api.ip2location.com/?ip=". $_SERVER['REMOTE_ADDR'] ."&key=demo&package=WS9&format=json";
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));

			$json_response = curl_exec($curl);
			curl_close($curl);

			$location = json_decode($json_response, true);

			if (!empty($location['zip_code'])) {
				Session::put('zip_code', $location['zip_code']);
				Session::put('city_name', $location['city_name']);
				Session::put('region_name', $location['region_name']);
				Session::put('latitude', $location['latitude']);
				Session::put('longitude', $location['longitude']);
			}
		} catch(Exception $e) {
			var_dump($e->getMessage());
		}
	}
}