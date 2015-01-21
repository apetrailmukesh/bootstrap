<?php

class HomeController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = 'home';

		$data = array(
			'location_info' => 'change location'
		);

		$this->layout->contents = View::make('home/home', $data);
	}

	public function change()
	{
		$this->layout->body_class = 'home';

		Input::flashOnly('zip_code', 'distance', 'search_text');
		$input = Input::all();

		$zip_code = Input::get('zip_code', '');
		$distance = Input::get('distance', '');
		$search_text = Input::get('search_text', '');
		
		$location_info = 'change location';
		if (!empty($zip_code) && !empty($distance)) {
			$location_info = $distance . ' miles from ' . $zip_code . ' (change)';
		}

		$data = array(
			'location_info' => $location_info
		);	

		$this->layout->contents = View::make('home/home', $data);
	}
}
