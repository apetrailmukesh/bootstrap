<?php

class HomeController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = 'home';
		$data = array(
			'locationInfo' => 'change location'
		);
		$this->layout->contents = View::make('home/home', $data);
	}

	public function change()
	{
		$this->layout->body_class = 'home';
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
		$this->layout->contents = View::make('home/home', $data);
	}
}
