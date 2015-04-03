<?php

class CarController extends BaseController {

	protected $secret = '9bOgq1ani4S3Josh1xucuuuLXaAh7WOG';

	public function store()
	{
		$data = array('message' => 'Vehicle added successfully', 'success' => true);

		try {
			$input = Input::json();

			$vin = Input::get('vin', '');
			$sign = Input::get('sign', '');

			if (!empty($vin) && !empty($sign)) {
				$hash = hash('sha256', $vin . '-' . $this->secret);
				if ($hash == $sign) {
					$cars = Vehicle::where('vin' , '=', $vin);
					if ($cars->count() > 0) {
						$data['message'] = 'Vehicle already exists';
			    		$data['success'] = false;
					} else {
						$car = new Vehicle;

						$car->vin = $vin;
						$car->url = $input->get('url', '');
						$car->address = $input->get('address', '');
						$car->city = $input->get('city', '');
						$car->state = $input->get('state', '');
						$car->photo = $input->get('photo', '');

						$car->certified = $this->getBoolean($input, 'certified');

						$car->year = $this->getInt($input, 'year');
						$car->miles = $this->getInt($input, 'miles');
						$car->zip = $this->getInt($input, 'zip');
						$car->doors = $this->getInt($input, 'doors');
						$car->cylinders = $this->getInt($input, 'cylinders');

						$car->price = $this->getDouble($input, 'price');
						$car->latitude = $this->getDouble($input, 'latitude');
						$car->longitude = $this->getDouble($input, 'longitude');

						$car->make = $this->getPropertyId($input, 'make');
						$car->model = $this->getPropertyId($input, 'model');
						$car->feature = $this->getPropertyId($input, 'feature');
						$car->status = $this->getPropertyId($input, 'status');
						$car->body = $this->getPropertyId($input, 'body');
						$car->fuel = $this->getPropertyId($input, 'fuel');
						$car->drive = $this->getPropertyId($input, 'drive');
						$car->interior = $this->getPropertyId($input, 'interior');
						$car->exterior = $this->getPropertyId($input, 'exterior');
						$car->transmission = $this->getPropertyId($input, 'transmission');

						$this->setSuggestions($car, $input->get('make', ''), $input->get('model', ''));
				        
				        $car = $this->setDealerProperties($car, $input, 'dealer');  

				        $car->paid = 0;
				        $car->modified = 1;

				        $car->save();	
					}		
				} else {
					$data['message'] = 'Authentication failed';
	    			$data['success'] = false;
				}
			} else {
				$data['message'] = 'Required parameters missing';
	    		$data['success'] = false;
			}
	    }
	    catch(Illuminate\Database\QueryException $sql_exception) {
	    	$data['message'] = 'Invalid data found';
	    	$data['success'] = false;
	    }
	    catch(Exception $exception) {
	    	$data['message'] = 'Unknown error occurred';
	    	$data['message'] = $exception->getMessage();
	    	$data['success'] = false;
	    }

		return Response::json($data);
	}

	public function getBoolean($input, $property) {
		$value = $input->get($property, 'false');

		return strtolower($value) == 'true' ? 1 : 0;
	}

	public function getInt($input, $property) {
		$value = $input->get($property, '0');

		return is_numeric($value) ? $value : 0;
	}

	public function getDouble($input, $property) {
		$value = $input->get($property, '0');

		return is_numeric($value) ? $value : 0;
	}

	public function getPropertyId($input, $property) {
		$id = 0;
		$value = $input->get($property, '');

		if(strlen(trim($value)) > 0){
			$records = DB::select( DB::raw("SELECT * FROM ". $property ." WHERE ". $property ." = :record"), array(
				'record' => $value
			));

			if (count($records) > 0) {
				$id = $records[0]->id;
			} else {
				$id = DB::table($property)->insertGetId(
				    array($property => $value)
				);
			}
		}

		return $id;
    }

    public function setDealerProperties($car, $input, $property) {
    	$value = $input->get($property, '');

		if(strlen(trim($value)) > 0){
			$records = DB::select( DB::raw("SELECT * FROM ". $property ." WHERE ". $property ." = :record"), array(
				'record' => $value
			));

			if (count($records) > 0) {
				$car->dealer = $records[0]->id;
				$car->paid = $records[0]->active;
			} else {
				$car->paid = 0;
				$car->dealer = DB::table($property)->insertGetId(
				    array($property => $value,
				    	'paid' => 0,
				    	'active' => 0,
				    	'monthly_clicks' => 0,
				    	'current_clicks' => 0)
				);
			}
		}

		return $car;
    }

    public function setSuggestions($car, $make, $model) {
        if (strlen(trim($make)) > 0 && strlen(trim($model)) > 0) {
            
        	$records = DB::select( DB::raw("SELECT * FROM search_suggestion WHERE suggestion = :record"), array(
				'record' => $make
			));

			if (count($records) > 0) {
				$suggestion = new SearchSuggestion;
			    $suggestion->suggestion = $make;
			    $suggestion->make = $car->make;
			    $suggestion->model = 0;
			    $suggestion->rank = 1;
			    $suggestion->save();
			}

			$make_model = $make . ' ' . $model;

			$records = DB::select( DB::raw("SELECT * FROM search_suggestion WHERE suggestion = :record"), array(
				'record' => $make_model
			));

			if (count($records) > 0) {
				$suggestion = new SearchSuggestion;
			    $suggestion->suggestion = $make_model;
			    $suggestion->make = $car->make;
			    $suggestion->model = $car->model;
			    $suggestion->rank = 2;
			    $suggestion->save();
			}
		}
    }
}