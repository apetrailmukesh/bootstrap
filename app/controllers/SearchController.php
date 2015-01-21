<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = 'srp';
		$data = array(
			'zipCode' => Input::get('zipCodeInput', ''),
			'distance' => Input::get('distanceInput', ''),
			'searchText' => Input::get('searchTextInput', '')
		);
		$this->layout->contents = View::make('search/search', $data);
	}

	public function search()
	{
		$this->layout->body_class = 'srp';
		$input = Input::all();
		Input::flashOnly('zipCodeInput', 'distanceInput', 'searchTextInput');
		$data = array(
			'zipCode' => Input::get('zipCodeInput', ''),
			'distance' => Input::get('distanceInput', ''),
			'searchText' => Input::get('searchTextInput', '')
		);
		$this->layout->contents = View::make('search/search', $data);
	}
}
