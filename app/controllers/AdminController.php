<?php

class AdminController extends BaseController {

	protected $layout = 'base';

	public function getSpecifications()
	{
		$this->layout->body_class = 'user';
		$data = array();
		$this->layout->contents = View::make('admin/admin-specifications', $data);
	}

	public function getUpload()
	{
		$this->layout->body_class = 'user';
		$data = array();
		$this->layout->contents = View::make('admin/admin-upload', $data);
	}

	public function getHistory()
	{
		$this->layout->body_class = 'user';
		$data = array();
		$this->layout->contents = View::make('admin/admin-history', $data);
	}
}
