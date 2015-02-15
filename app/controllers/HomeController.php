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
			$locations = Location::where('zip_code' , '=', $zip_code);
			if ($locations->count()) {
				$location = Location::where('zip_code' , '=', $zip_code)->first();
				$city = $location->city;
				$state = $location->state;
				if (!empty($city) && !empty($state)) {
					$location_info = $distance . ' miles from ' . $city . ', ' . $state . ' (change)';
				}
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
		if (!empty($zip_code)) {
			$locations = Location::where('zip_code' , '=', $zip_code);
			if ($locations->count()) {
				$location = Location::where('zip_code' , '=', $zip_code)->first();
				$city = $location->city;
				$state = $location->state;
				if (!empty($city) && !empty($state)) {
					$location_info = $distance . ' miles from ' . $city . ', ' . $state . ' (change)';
				}
			}
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

		$make = '';
		$model = '';
		$suggestion = SearchSuggestion::where('suggestion' , '=', strtoupper($search_text));
		if ($suggestion->count()) {
			$make = $suggestion->first()->make;
			$model = $suggestion->first()->model;
		}

		$query = array(
			'search_text' => $search_text,
			'zip_code' => $zip_code,
			'distance' => $distance,
			'make' => $make,
			'model' => $model,
			'page' => 1,
			'sort' => 'price-1'
		);

		return Redirect::route('get.search', $query);
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