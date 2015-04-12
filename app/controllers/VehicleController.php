<?php

class VehicleController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$vin = Input::get('vin', '');
		$vehicle = Vehicle::where('vin' , '=', $vin)->first();
		$dealer = Dealer::where('id' , '=', $vehicle->dealer)->first();

		$click = new Click;
		$click->vin = $vehicle->vin;
		$click->dealer = $dealer->dealer;
		$click->state = $vehicle->state;
		$click->datetime = date("Y-m-d H:i:s");
		$click->ip = $_SERVER['REMOTE_ADDR'];
		$click->paid = $vehicle->paid;
		$click->save();
		
		$dealer->current_clicks = $dealer->current_clicks + 1;
		if ($vehicle->paid > 0) {
			$dealer->paid_clicks = $dealer->paid_clicks + 1;
		}

		if ($dealer->active == 1 && $dealer->monthly_clicks <= $dealer->paid_clicks) {
			$dealer->active = 0;
			DB::table('vehicle')->where('dealer', $dealer->id)->update(array('paid' => 0, 'modified' => 1));
		}

		$dealer->save();

		return Redirect::to($vehicle->url);
	}

	public function adsParameter()
	{
		$make_input = Input::get('make', '');
		$model_input = Input::get('model', '');
		$body_input = Input::get('body', '');
		$status_input = Input::get('status', '');

		$statuses = '';
		$makes = '';
		$models = '';
		$bodies = '';

		$new_status_id = '';
		$used_status_id = '';
		$status_values = Status::all();
		foreach ($status_values as $status) {
			if ($status->status == 'PreOwned') {
				$used_status_id = $status->id;
			} else if ($status->status == 'New') {
				$new_status_id = $status->id;
			}
		}

		if ($status_input == $new_status_id) {
			$statuses = 'New-';
		} else if ($status_input == $used_status_id) {
			$statuses = 'Used-';
		}

		foreach (explode("-", $make_input) as $make) {
			$entities = Make::where('id' , '=', $make);
			if ($entities->count()) {
				$entity = $entities->first();
				$makes = $makes . $entity->make . '-';
			}
		}

		foreach (explode("-", $model_input) as $model) {
			$entities = Model::where('id' , '=', $model);
			if ($entities->count()) {
				$entity = $entities->first();
				$models = $models . $entity->model . '-';
			}
		}

		foreach (explode("-", $body_input) as $body) {
			$entities = Body::where('id' , '=', $body);
			if ($entities->count()) {
				$entity = $entities->first();
				$bodies = $bodies . $entity->body . '-';
			}
		}

		$ads = '';
		if (!empty($statuses)) {
			$ads = $ads . $statuses;
		}

		if (!empty($makes)) {
			$ads = $ads . $makes;
		}

		if (!empty($models)) {
			$ads = $ads . $models;
		}

		if (!empty($bodies)) {
			$ads = $ads . $bodies;
		}

		if (!empty($ads)) {
			$ads = substr($ads, 0, -1);
		}

		return Response::json(array('ads' => $ads));
	}
}