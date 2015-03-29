<?php

class UserController extends BaseController {

	protected $layout = 'base';

	protected $utility_make;
	protected $utility_model;
	protected $utility_price;
	protected $utility_mileage;
	protected $utility_feature;
	protected $utility_transmission;
	protected $utility_dealer;
	protected $utility_photo;
	protected $utility_year;
	protected $utility_status;
	protected $utility_body;
	protected $utility_certified;
	protected $utility_interior;
	protected $utility_exterior;
	protected $utility_doors;
	protected $utility_cylinders;
	protected $utility_fuel;
	protected $utility_drive;

	public function __construct() {
		$this->utility_make = new UtilityMake();
		$this->utility_model = new UtilityModel();
    	$this->utility_price = new UtilityPrice();
    	$this->utility_mileage = new UtilityMileage();
    	$this->utility_feature = new UtilityFeature();
    	$this->utility_transmission = new UtilityTransmission();
    	$this->utility_dealer = new UtilityDealer();
    	$this->utility_photo = new UtilityPhoto();
    	$this->utility_year = new UtilityYear();
    	$this->utility_status = new UtilityStatus();
    	$this->utility_certified = new UtilityCertified();
    	$this->utility_exterior = new UtilityExterior();
    	$this->utility_interior = new UtilityInterior();
    	$this->utility_drive = new UtilityDrive();
    	$this->utility_fuel = new UtilityFuel();
    	$this->utility_doors = new UtilityDoors();
    	$this->utility_cylinders = new UtilityCylinders();
    	$this->utility_body = new UtilityBody();
  	}

	public function getLogin()
	{
		$this->layout->body_class = 'user';
		$data = array();
		$this->layout->contents = View::make('user/user-login', $data);
	}

	public function getRegister()
	{
		$this->layout->body_class = 'user';
		$data = array();
		$this->layout->contents = View::make('user/user-register', $data);
	}

	public function getProfile()
	{
		$this->layout->body_class = 'user';
		$data = array(
			'first_name' => Auth::user()->first_name,
			'last_name' => Auth::user()->last_name
		);

		$this->layout->contents = View::make('user/user-profile', $data);
	}

	public function getSavedCars()
	{
		$this->layout->body_class = 'srp';
		$saved_car_count = 0;
		$saved_search_count = 0;

		$results = array();
		if (Auth::check()) {
			$sort = Input::get('sort', '');
			$sort_query = 'datetime DESC';
			if ($sort == 'date-0') {
				$sort_query = 'datetime ASC';
			} else if ($sort == 'price-1') {
				$sort_query = 'price DESC';
			} else if ($sort == 'price-0') {
				$sort_query = 'price ASC';
			} else if ($sort == 'mileage-1') {
				$sort_query = 'miles DESC';
			} else if ($sort == 'mileage-0') {
				$sort_query = 'miles ASC';
			} else if ($sort == 'year-1') {
				$sort_query = 'year DESC';
			} else if ($sort == 'year-0') {
				$sort_query = 'year ASC';
			}

			$cars = DB::select( DB::raw("SELECT * FROM saved_car s INNER JOIN vehicle v ON s.vehicle = v.vin WHERE s.user = :user ORDER BY " . $sort_query), array(
   				'user' => Auth::user()->id
 			));

			$searches = DB::select( DB::raw("SELECT * FROM saved_search WHERE user = :user"), array(
   				'user' => Auth::user()->id
 			)); 			

			$saved_car_count = count($cars);
			$saved_search_count = count($searches);

			foreach ($cars as $vehicle) {
				$vin = $vehicle->vin;
				$year = $vehicle->year;
				$url = $vehicle->url;

				$source = array();
				$source['make'] = $vehicle->make;
				$source['model'] = $vehicle->model;
				$source['price'] = $vehicle->price;
				$source['miles'] = $vehicle->miles;
				$source['trim'] = $vehicle->feature;
				$source['transmission'] = $vehicle->transmission;
				$source['dealer'] = $vehicle->dealer;
				$source['address'] = $vehicle->address;
				$source['city'] = $vehicle->city;
				$source['state'] = $vehicle->state;
				$source['photo'] = $vehicle->photo;
				$source['body'] = $vehicle->body;
				$source['feature'] = $vehicle->feature;
				$source['drive'] = $vehicle->drive;

				$make = $this->utility_make->getValue($source);
				$model = $this->utility_model->getValue($source);
				$price = $this->utility_price->getValue($source);
				$mileage = $this->utility_mileage->getValue($source);
				$trim = $this->utility_feature->getValue($source);
				$transmission = $this->utility_transmission->getValue($source);
				$dealer = $this->utility_dealer->getName($source);
				$dealer_address = $this->utility_dealer->getAddress($source);
				$image = $this->utility_photo->getValue($source);
				$body = $this->utility_body->getValue($source);
				$feature = $this->utility_feature->getValue($source);
				$drive = $this->utility_drive->getValue($source);

				$result = array(
					'vin' => $vin,
					'year' => $year,
					'make' => $make,
					'model' => $model,
					'url' => $url,
					'dealer' => $dealer,
					'price' => $price,
					'mileage' => $mileage,
					'trim' => $trim,
					'transmission' => $transmission,
					'dealer_address' => $dealer_address,
					'image' => $image,
					'body' => $body,
					'feature' => $feature,
					'drive' => $drive
				);

				array_push($results, $result);
			}			
		}

		$data = array(
			'search_text' => '',
			'results' => $results,
			'saved_car_count' => $saved_car_count,
			'saved_search_count' => $saved_search_count
		);

		$this->layout->contents = View::make('user/user-saved-cars', $data);
	}

	public function getSavedSearches()
	{
		$this->layout->body_class = 'srp';
		$saved_car_count = 0;
		$saved_search_count = 0;

		$results = array();
		if (Auth::check()) {
			$sort = Input::get('sort', '');
			$sort_query = 'datetime DESC';
			if ($sort == 'date-0') {
				$sort_query = 'datetime ASC';
			}

			$cars = DB::select( DB::raw("SELECT * FROM saved_car WHERE user = :user"), array(
   				'user' => Auth::user()->id
 			));

			$searches = DB::select( DB::raw("SELECT * FROM saved_search WHERE user = :user ORDER BY " . $sort_query), array(
   				'user' => Auth::user()->id
 			));			

			$saved_car_count = count($cars);
			$saved_search_count = count($searches);

			foreach ($searches as $search) {
				$result = array(
					'id' => $search->id,
					'title' => $search->title,
					'filter' => str_replace("-class-", "class='fa-icon dot'", $search->filter),
					'location' => $search->location,
					'query' => '/search' . $search->query,
					'time' => 'Saved on ' . date_format(date_create($search->datetime), 'd/m/Y')
				);

				array_push($results, $result);
			}			
		}

		$data = array(
			'search_text' => '',
			'results' => $results,
			'saved_car_count' => $saved_car_count,
			'saved_search_count' => $saved_search_count
		);

		$this->layout->contents = View::make('user/user-saved-searches', $data);
	}

	public function login()
	{
		$this->layout->body_class = 'user';
		$rules = array(
			'email'=>'required|email',
			'password'=>'required|alpha_num'
	    );
	    $validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$data = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);
	        if (Auth::attempt($data)) {
	        	return Redirect::route('get.home');
	        }
	        else {
				return Redirect::route('get.user.login')->with('message', 'Invalid email or password')->withInput();
	        }
	    } else {
	        return Redirect::route('get.user.login')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
	    }
	}

	public function register()
	{
		$this->layout->body_class = 'user';
		$rules = array(
		    'first_name'=>'required|alpha|min:2',
			'last_name'=>'required|alpha|min:2',
			'email'=>'required|email|unique:user',
			'password'=>'required|alpha_num|between:6,20'
	    );
		$validator = Validator::make(Input::all(), $rules);
	    if ($validator->passes()) {
	        $user = new User;
		    $user->first_name = Input::get('first_name');
		    $user->last_name = Input::get('last_name');
		    $user->email = Input::get('email');
		    $user->password = Hash::make(Input::get('password'));
		    $user->role = 0;
		    $user->save();
    		return Redirect::route('get.user.login')->with('message', 'Thanks for registering! Please log in to continue.');
	    } else {
	        return Redirect::route('get.user.register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
	    }
	}

	public function profile()
	{
		$this->layout->body_class = 'user';
		$rules = array(
		    'first_name'=>'required|alpha|min:2',
			'last_name'=>'required|alpha|min:2'
	    );
		$validator = Validator::make(Input::all(), $rules);
	    if ($validator->passes()) {
		    Auth::user()->first_name = Input::get('first_name');
		    Auth::user()->last_name = Input::get('last_name');
		    Auth::user()->save();
    		return Redirect::route('get.user.profile')->with('message', 'Profile updated successfully.');
	    } else {
	        return Redirect::route('get.user.profile')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
	    }
	}

	public function logout()
	{
		$this->layout->body_class = 'user';
		Auth::logout();
    	return Redirect::route('get.home');
	}

	public function saveCar()
	{
		$this->layout->body_class = 'user';
		$vin = Input::get('vin', '');
		if (Auth::check() && !empty($vin)) {
			$values = Vehicle::where('vin' , '=', $vin);
			if ($values->count()) {
				$car = new SavedCar;
				$car->vehicle = $values->first()->vin;
				$car->user =  Auth::user()->id;
				$car->datetime = date("Y-m-d H:i:s");
				$car->save();
			}
		}
	}

	public function saveSearch()
	{
		$this->layout->body_class = 'user';

		$title = Input::get('title', '');
		$filter = Input::get('filter', '');
		$location = Input::get('location', '');
		$query = Input::get('query', '');

		if (Auth::check()) {
			$search = new SavedSearch;
			$search->title = $title;
			$search->filter = $filter;
			$search->location = $location;
			$search->query = $query;
			$search->user =  Auth::user()->id;
			$search->datetime = date("Y-m-d H:i:s");
			$search->save();
		}
	}

	public function removeSavedCar() {
		$this->layout->body_class = 'user';
		$vin = Input::get('vin', '');
		if (Auth::check() && !empty($vin)) {
			DB::table('saved_car')->where('vehicle' , '=', $vin)->where('user' , '=', Auth::user()->id)->delete();
		}

		return Response::json(array('success' => true));
	}

	public function removeSavedSearch() {
		$this->layout->body_class = 'user';
		$id = Input::get('id', '');
		if (Auth::check() && !empty($id)) {
			DB::table('saved_search')->where('id' , '=', $id)->delete();
		}

		return Response::json(array('success' => true));
	}
}
