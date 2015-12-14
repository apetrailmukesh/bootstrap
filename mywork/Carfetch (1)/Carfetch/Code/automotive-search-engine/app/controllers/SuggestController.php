<?php

class SuggestController extends BaseController {

	public function vehicle()
	{
		$data = array();
		$query = Input::get('query', '');

		$suggestions = SearchSuggestion::where('suggestion' , 'LIKE', '%'. $query.'%')->orderBy('rank', 'asc')->take(10)->get();

		foreach ($suggestions as $suggestion) {
			array_push($data, array('value' => $suggestion->suggestion));
		}

		return Response::json($data);
	}

	public function model()
	{
		$data = array();
		$make = Input::get('make', '');

		$models = DB::select( DB::raw("SELECT * FROM model WHERE id in (SELECT model FROM search_suggestion WHERE make = :make)"), array(
   			'make' => $make
 		));

		return Response::json($models);
	}

	public function makemodel()
	{
		$query = Input::get('query', '');

		$make = '';
		$model = '';
		$suggestion = SearchSuggestion::where('suggestion' , '=', strtoupper($query));
		if ($suggestion->count()) {
			$make = $suggestion->first()->make;

			if ($suggestion->first()->model > 0) {
				$model = $suggestion->first()->model;
			}
		}

		$zip_code = Session::get('zip_code', '');
		$distance = Session::get('distance', '50');

		$data = array("make" => $make, "model" => $model, "zip_code" => $zip_code, "distance" => $distance);

		return Response::json($data);
	}
}