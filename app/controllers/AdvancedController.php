<?php

class AdvancedController extends BaseController {

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

	public function index()
	{
		$this->layout->body_class = 'srp';

		$zip_code = Input::query('zip_code', '');
		$distance = Input::query('distance', '50');

		if (empty($zip_code)) {
			$this->findLocation();
			$zip_code = Session::get('zip_code', '');
		}

		Session::put('zip_code', $zip_code);
		Session::put('distance', $distance);

		$data = array(
			'search_text' => ''
		);

		$this->layout->contents = View::make('search/advanced', $data);
	}

	public function findLocation()
	{
		$location_searched = Session::get('location_searched', '');
		if (empty($location_searched)) {
			$ip_address = $_SERVER['REMOTE_ADDR'];

			if(!empty($ip_address) && filter_var($ip_address, FILTER_VALIDATE_IP)) {
				$url = 'http://www.telize.com/geoip/'. $ip_address;
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$json_response = curl_exec($curl);
				curl_close($curl);
				Session::put('location_searched', 'true');

				$location = json_decode($json_response, true);
				
				if (array_key_exists('postal_code', $location)) {
					$zip_code = $location['postal_code'];
					Session::put('zip_code', $zip_code);
				}
			}
		}
	}
}
