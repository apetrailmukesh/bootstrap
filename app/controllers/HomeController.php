<?php

class HomeController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = 'home';

		$zip_code = Session::get('zip_code', '');
		$distance = Session::get('distance', '50');
		
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

	public function start()
	{
		$this->layout->body_class = 'srp';

		$zip_code = Session::get('zip_code', '');
		$distance = Session::get('distance', '');
		$search_text = Input::get('search_text', '');

		$query = array(
			'zip_code' => $zip_code,
			'distance' => $distance,
			'search_text' => $search_text,
		);

		return Redirect::route('get.search', $query);
	}
}