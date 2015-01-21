<?php

class HomeController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$input = Input::all();
		Input::flashOnly('zipCodeInput', 'distanceInput', 'searchTextInput');

		$zipCode = Input::get('zipCodeInput', '');
		$distance = Input::get('distanceInput', '');
		$searchText = Input::get('searchTextInput', '');

		$locationInfo = 'change location';
		if (!empty($zipCode) && !empty($distance)) {
			$locationInfo = $distance . ' miles from ' . $zipCode . ' (change)';
		}

		$data = array(
			'locationInfo' => $locationInfo
		);
		
		$this->layout->bodyClass = 'home';
		$this->layout->contents = View::make('home/home', $data);
	}
}
