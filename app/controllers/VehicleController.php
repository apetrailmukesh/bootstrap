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
}