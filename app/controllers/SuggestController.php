<?php

class SuggestController extends BaseController {

	public function vehicle()
	{
		$data = array();
		$query = Input::get('query', '');
		
		array_push($data, array('value' => 'AA'));
		array_push($data, array('value' => 'AAA'));
		array_push($data, array('value' => 'AAAA'));

		return Response::json($data);
	}

	public function zip()
	{
		$data = array();
		$query = Input::get('query', '');

		$locations = Location::where('zip_code' , 'LIKE', $query.'%')->take(10)->get();

		foreach ($locations as $location) {
			array_push($data, array('value' => $location->zip_code));
		}

		return Response::json($data);
	}
}