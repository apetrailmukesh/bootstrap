<?php

class AdvancedController extends BaseController {

	protected $layout = 'base';

	public function index()
	{
		$this->layout->body_class = '';

		$zip_code = Input::query('zip_code', '');
		$distance = Input::query('distance', '50');

		if (empty($zip_code)) {
			$this->findLocation();
			$zip_code = Session::get('zip_code', '');
		}

		Session::put('zip_code', $zip_code);
		Session::put('distance', $distance);

		$data = array(
			'search_text' => '',
			'zip_code' => $zip_code,
			'distance' => $distance,
			'status' => $this->getStatus(),
			'makes' => $this->getPropertiesList(Make::orderBy('make')->get(), 'make'),
			'bodies' => $this->getPropertiesList(Body::orderBy('body')->get(), 'body'),
			'transmissions' => $this->getPropertiesList(Transmission::orderBy('transmission')->get(), 'transmission'),
			'drives' => $this->getPropertiesList(Drive::orderBy('drive')->get(), 'drive'),
			'interiors' => $this->getPropertiesList(Interior::orderBy('interior', 'DESC')->take(10)->get(), 'interior'),
			'exteriors' => $this->getPropertiesList(Exterior::orderBy('exterior', 'DESC')->take(10)->get(), 'exterior'),
			'fuels' => $this->getPropertiesList(Fuel::orderBy('fuel')->get(), 'fuel'),
			'doors_count' => $this->getDoorsCounts(),
			'cylinders_count' => $this->getCylindersCounts()
		);

		$this->layout->contents = View::make('search/advanced', $data);
	}

	public function getStatus() {
		$new_status_id = '';
		$used_status_id = '';
		$statuses = Status::all();
		foreach ($statuses as $status) {
			if ($status->status == 'PreOwned') {
				$used_status_id = $status->id;
			} else if ($status->status == 'New') {
				$new_status_id = $status->id;
			}
		}

		$status = array();
		$status['new_id'] = $new_status_id;
		$status['used_id'] = $used_status_id;

		return $status;
	}

	public function getDoorsCounts() {
		$entities = array();

		$doors = Vehicle::distinct()->select('doors')->orderBy('doors')->where('doors', '>', 0)->get();
		foreach ($doors as $door) {
			array_push($entities, (object)['id' => $door->doors, 'doors' => $door->doors . ' Doors']);
		}

		return $this->getPropertiesList($entities, 'doors');
	}

	public function getCylindersCounts() {
		$entities = array();

		$cylinders = Vehicle::distinct()->select('cylinders')->orderBy('cylinders')->where('cylinders', '>', 0)->get();
		foreach ($cylinders as $cylinder) {
			array_push($entities, (object)['id' => $cylinder->cylinders, 'cylinders' => $cylinder->cylinders . ' Cylinders']);
		}

		return $this->getPropertiesList($entities, 'cylinders');
	}

	public function getPropertiesList($entities, $column) {
		$properties = array();

		foreach ($entities as $entity) {
			$property = array();
			$property['id'] = 'advanced-' . $column . '-' . $entity->id;
			$property['class'] = $entity->id;
			$property['name'] = $entity->$column;
			$property['end'] = '';
			array_push($properties, $property);
		}

		if(!empty($properties)) {
			end($properties);
			$key = key($properties);
			$properties[$key]['end'] = 'end';
			reset($properties);
		}

		return $properties;
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
