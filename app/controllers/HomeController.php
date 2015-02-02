<?php

class HomeController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = 'home';

		$zip_code = Session::get('zip_code', '');
		$distance = Session::get('distance', '50');

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

		$query = array(
			'zip_code' => $zip_code,
			'distance' => $distance,
			'search_text' => $search_text,
			'page' => 1,
			'sort' => 'price-1'
		);

		return Redirect::route('get.search', $query);
	}
}