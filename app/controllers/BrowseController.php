<?php

class BrowseController extends BaseController {

	protected $layout = 'base';

	public function make()
	{
		$this->layout->body_class = '';

		$columns = array(array(), array(), array(), array(), array(), array());

		$makes = Make::orderBy('make')->get();
		foreach($makes as $key=>$value) {
			$make = array('link' => '/browse/make/model/' . $value->id, 'title' => $value->make);
			array_push($columns[$key % 6], $make);
		}

		$data = array(
			'search_text' => '',
			'columns' => $columns
			);

		$this->layout->contents = View::make('browse/make', $data);
	}

	public function makeModel($id)
	{
		$this->layout->body_class = '';

		$make = Make::find($id);
		$columns = array(array(), array(), array(), array());

		$models = DB::select( DB::raw("SELECT * FROM model WHERE id in (SELECT model FROM search_suggestion WHERE make = :make)"), array(
			'make' => $make->id
		));

		foreach($models as $key=>$value) {
			$model = array('link' => '/browse/make/model/state/' . $make->id . '-' . $value->id, 'title' => $make->make . ' ' . $value->model);
			array_push($columns[$key % 4], $model);
		}

		$data = array(
			'search_text' => '',
			'make' => $make,
			'columns' => $columns
		);

		$this->layout->contents = View::make('browse/make-model', $data);
	}

	public function makeModelState($id)
	{
		$this->layout->body_class = '';

		$make = Make::find(explode("-", $id)[0]);
		$model = Model::find(explode("-", $id)[1]);

		$columns = array(array(), array(), array());

		$states = $this->getStates();

		foreach($states as $key=>$value) {
			$link =  '/browse/make/model/state/city/' . $id . '-' . $value['code'];
			$title = $make->make . ' ' . $model->model . ' for sale in ' . $value['name'];
			$state = array('link' => $link, 'title' => $title);
			array_push($columns[$key % 3], $state);
		}

		$data = array(
			'search_text' => '',
			'make' => $make,
			'model' => $model,
			'columns' => $columns
		);

		$this->layout->contents = View::make('browse/make-model-state', $data);
	}

	public function makeModelStateCity($id)
	{
		$this->layout->body_class = '';

		$make = Make::find(explode("-", $id)[0]);
		$model = Model::find(explode("-", $id)[1]);

		$state = null;
		foreach($this->getStates() as $entity) {
    		if (explode("-", $id)[2] == $entity['code']) {
        		$state = $entity;
        		break;
    		}
		}

		$columns = array(array(), array(), array());

		$cities = DB::select( DB::raw("SELECT DISTINCT city FROM vehicle WHERE make = :make AND model = :model AND state = :state ORDER BY city"), array(
			'make' => $make->id,
			'model' => $model->id,
			'state' => $state['code']
		));

		foreach($cities as $key=>$value) {
			$location = Location::where('state' , '=', $state['code'])->where('city' , '=', $value->city);
			if ($location->count()) {
				$zip = $location->first()->zip_code;
				$search = $make->make . ' ' . $model->model;
				$link =  '/search?make='.$make->id.'&model='.$model->id.'&zip_code='.$zip.'&search_text='.$search.'&distance=50&page=1&sort=price-1';
				$title = $make->make . ' ' . $model->model . ' for sale in ' . $value->city . ', ' . $state['code'];
				$city = array('link' => $link, 'title' => $title);
				array_push($columns[$key % 3], $city);
			}
		}

		$data = array(
			'search_text' => '',
			'make' => $make,
			'model' => $model,
			'state' => $state,
			'columns' => $columns
		);

		$this->layout->contents = View::make('browse/make-model-state-city', $data);
	}

	public function body()
	{
		$this->layout->body_class = 'srp';

		$data = array(
			'search_text' => ''
			);

		$this->layout->contents = View::make('browse/body', $data);
	}

	public function location()
	{
		$this->layout->body_class = 'srp';

		$data = array(
			'search_text' => ''
			);

		$this->layout->contents = View::make('browse/location', $data);
	}

	public function getStates() {
		return array(
			array('code' => 'AL', 'name' =>'Alabama'),
			array('code' => 'AK', 'name' =>'Alaska'),
			array('code' => 'AZ', 'name' =>'Arizona'),
			array('code' => 'AR', 'name' =>'Arkansas'),
			array('code' => 'CA', 'name' =>'California'),
			array('code' => 'CO', 'name' =>'Colorado'),
			array('code' => 'CT', 'name' =>'Connecticut'),
			array('code' => 'DE', 'name' =>'Delaware'),
			array('code' => 'DC', 'name' =>'District of Columbia'),
			array('code' => 'FL', 'name' =>'Florida'),
			array('code' => 'GA', 'name' =>'Georgia'),
			array('code' => 'HI', 'name' =>'Hawaii'),
			array('code' => 'ID', 'name' =>'Idaho'),
			array('code' => 'IL', 'name' =>'Illinois'),
			array('code' => 'IN', 'name' =>'Indiana'),
			array('code' => 'IA', 'name' =>'Iowa'),
			array('code' => 'KS', 'name' =>'Kansas'),
			array('code' => 'KY', 'name' =>'Kentucky'),
			array('code' => 'LA', 'name' =>'Louisiana'),
			array('code' => 'ME', 'name' =>'Maine'),
			array('code' => 'MD', 'name' =>'Maryland'),
			array('code' => 'MA', 'name' =>'Massachusetts'),
			array('code' => 'MI', 'name' =>'Michigan'),
			array('code' => 'MN', 'name' =>'Minnesota'),
			array('code' => 'MS', 'name' =>'Mississippi'),
			array('code' => 'MO', 'name' =>'Missouri'),
			array('code' => 'MT', 'name' =>'Montana'),
			array('code' => 'NE', 'name' =>'Nebraska'),
			array('code' => 'NV', 'name' =>'Nevada'),
			array('code' => 'NH', 'name' =>'New Hampshire'),
			array('code' => 'NJ', 'name' =>'New Jersey'),
			array('code' => 'NM', 'name' =>'New Mexico'),
			array('code' => 'NY', 'name' =>'New York'),
			array('code' => 'NC', 'name' =>'North Carolina'),
			array('code' => 'ND', 'name' =>'North Dakota'),
			array('code' => 'OH', 'name' =>'Ohio'),
			array('code' => 'OK', 'name' =>'Oklahoma'),
			array('code' => 'OR', 'name' =>'Oregon'),
			array('code' => 'PA', 'name' =>'Pennsylvania'),
			array('code' => 'RI', 'name' =>'Rhode Island'),
			array('code' => 'SC', 'name' =>'South Carolina'),
			array('code' => 'SD', 'name' =>'South Dakota'),
			array('code' => 'TN', 'name' =>'Tennessee'),
			array('code' => 'TX', 'name' =>'Texas'),
			array('code' => 'UT', 'name' =>'Utah'),
			array('code' => 'VT', 'name' =>'Vermont'),
			array('code' => 'VA', 'name' =>'Virginia'),
			array('code' => 'WA', 'name' =>'Washington'),
			array('code' => 'WV', 'name' =>'West Virginia'),
			array('code' => 'WI', 'name' =>'Wisconsin'),
			array('code' => 'WY', 'name' =>'Wyoming'),
		);
	}
}
