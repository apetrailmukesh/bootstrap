<?php

class AdvancedController extends BaseController {

	protected $layout = 'base';

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
			'search_text' => '',
			'zip_code' => $zip_code,
			'distance' => $distance,
			'status' => $this->getStatus(),
			'bodies' => $this->getBodyStyles()
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

	public function getBodyStyles() {
		$bodies = array();

		$body_styles = Body::orderBy('body')->get();
		foreach ($body_styles as $body_style) {
			$body = array();
			$body['id'] = 'advanced-body-' . $body_style->id;
			$body['class'] = $body_style->id;
			$body['name'] = $body_style->body;
			$body['end'] = '';
			array_push($bodies, $body);
		}

		if(!empty($bodies)) {
			end($bodies);
			$key = key($bodies);
			$bodies[$key]['end'] = 'end';
			reset($bodies);
		}

		return $bodies;
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
