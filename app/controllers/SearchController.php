<?php

class SearchController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$data = array();
		$this->layout->bodyClass = 'srp';
		$this->layout->contents = View::make('search', $data);
	}
}
