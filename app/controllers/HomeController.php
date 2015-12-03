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
					if ($distance == 0) {
						$location_info = 'unlimited miles from ' . $city . ', ' . $state . ' (change)';
					} else {
						$location_info = $distance . ' miles from ' . $city . ', ' . $state . ' (change)';
					}
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