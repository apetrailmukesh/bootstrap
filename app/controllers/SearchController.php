<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$input = Input::all();
		Input::flashOnly('zipCodeInput', 'distanceInput', 'searchTextInput');

		$data = array(
			'zipCode' => Input::get('zipCodeInput', ''),
			'distance' => Input::get('distanceInput', ''),
			'searchText' => Input::get('searchTextInput', '')
		);
		
		$this->layout->bodyClass = 'srp';
		$this->layout->contents = View::make('search/search', $data);
	}
}
