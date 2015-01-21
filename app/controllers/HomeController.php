<?php

class HomeController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$data = array();
		$this->layout->bodyClass = 'home';
		$this->layout->contents = View::make('home', $data);
	}
}
