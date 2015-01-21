<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = 'srp';

		$data = array(
			'zip_code' => Input::get('zip_code', ''),
			'distance' => Input::get('distance', ''),
			'search_text' => Input::get('search_text', '')
		);

		$this->layout->contents = View::make('search/search', $data);
	}

	public function search()
	{
		$this->layout->body_class = 'srp';

		Input::flashOnly('zip_code', 'distance', 'search_text');

		$input = Input::all();
		$data = array(
			'zip_code' => Input::get('zip_code', ''),
			'distance' => Input::get('distance', ''),
			'search_text' => Input::get('search_text', '')
		);
		$this->layout->contents = View::make('search/search', $data);
	}
}
