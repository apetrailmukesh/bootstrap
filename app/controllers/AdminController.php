<?php

class AdminController extends BaseController {

	protected $layout = 'base';

	public function getUpload()
	{
		$this->layout->body_class = 'user';
		$data = array(
			'files' => DataFile::all()
		);

		$this->layout->contents = View::make('admin/admin-upload', $data);
	}

	public function getDealers()
	{
		$this->layout->body_class = 'user';
		$data = array(
			'paid_dealers' => Dealer::where('paid' , '=', 1)->orderBy('dealer')->get(),
			'free_dealers' => Dealer::where('paid' , '=', 0)->orderBy('dealer')->get()
		);

		$this->layout->contents = View::make('admin/admin-dealers', $data);
	}

	public function getClicks()
	{
		$this->layout->body_class = 'user';
		
		$page = Input::query('page', '1');
		$size = 100;
		$skip = ($page - 1) * $size;
		$from = Input::query('from', '0000-00-00');
		$to = Input::query('to', '3000-00-00');

		$from = $from . ' 00:00:00';
		$to = $to . ' 23:59:59';

		$clicks = DB::table('click')->whereBetween('datetime', [$from, $to])->skip($skip)->take($size)->get();
		$total = DB::table('click')->whereBetween('datetime', [$from, $to])->count();
		
		$data = array(
			'clicks' => $clicks,
			'total' => $total
		);

		$this->layout->contents = View::make('admin/admin-clicks', $data);
	}

	public function getEditDealers($id)
	{
		$this->layout->body_class = 'user';

		$dealer = Dealer::find($id);

		$paid = false;
		if ($dealer->paid > 0) {
			$paid = true;
		}

		$clicks = '';
		if ($dealer->monthly_clicks > 0) {
			$clicks = $dealer->monthly_clicks;
		}

		$history = DealerHistory::where('dealer' , '=', $dealer->id)->orderBy('year', 'desc')->orderBy('month', 'desc')->get();

		$data = array(
			'id' => $dealer->id,
			'name' => $dealer->dealer,
			'paid' => $paid,
			'clicks' => $clicks,
			'dealer_history' => $history
		);

		$this->layout->contents = View::make('admin/admin-dealers-edit', $data);
	}

	public function editDealer()
	{
		$dealer = Dealer::find(Input::get('id'));

		$previous_status = $dealer->paid;

		$clicks = Input::get('clicks', '0');
		if (is_numeric($clicks)) {
			$dealer->monthly_clicks = $clicks;
		} else {
			$dealer->monthly_clicks = 0;
		}

		$paid = Input::get('paid', 'free');
		if ($paid === 'paid') {
			$dealer->paid = 1;
			$dealer->active = 1;
		} else {
			$dealer->paid = 0;
			$dealer->active = 0;
		}

		if ($previous_status != $dealer->paid) {
			if ($dealer->paid == 1) {
				$dealer->paid_clicks = 0;
			}

			DB::table('vehicle')->where('dealer', $dealer->id)->update(array('modified' => 1, 'paid' => $dealer->active));
		}
		
		$dealer->save();

    	return Redirect::route('get.admin.dealers');
	}

	public function upload()
	{
		$this->layout->body_class = 'user';
		if (Input::hasFile('file'))
		{
			if (Input::file('file')->isValid())
			{
				$validExtensions = array('csv');
				if (in_array(Input::file('file')->getClientOriginalExtension(), $validExtensions)) 
				{
					$file = new DataFile;
			    	$file->name = Input::file('file')->getClientOriginalName();
			    	$file->status = 'Pending';
			    	$file->save();

	    			Input::file('file')->move(storage_path().'/uploads/', $file->id.'.'.Input::file('file')->getClientOriginalExtension());
	    			return Redirect::route('get.admin.upload')->with('message', 'File uploaded successfully');
				}
				else
				{
					return Redirect::route('get.admin.upload')->with('message', 'Only files csv extension are allowed');
				}	
    		}
    		else 
    		{
    			return Redirect::route('get.admin.upload')->with('message', 'An error occurred while reading the file');
    		}
		}
		else
		{
			return Redirect::route('get.admin.upload')->with('message', 'Please select a file to be uploaded');
		}
	}

	public function downloadClicks()
	{
		$filename = "Vehicle_Clicks_" . time() . ".csv";
    	$handle = fopen($filename, 'w+');

		$from = Input::query('from', '0000-00-00');
		$to = Input::query('to', '3000-00-00');
		$from = $from . ' 00:00:00';
		$to = $to . ' 23:59:59';

		fputcsv($handle, array('VIN', 'Date', 'IP Address', 'Status'));

		$clicks = DB::table('click')->whereBetween('datetime', [$from, $to])->get();
		foreach ($clicks as $click) {
			fputcsv($handle, array($click->vin, $click->datetime, $click->ip, $click->paid == 0 ? 'Free' : 'Paid'));
		}

		fclose($handle);

		$headers = array(
            'Content-Type' => 'text/csv'
        );

        return Response::download($filename, 'VehicleClicksDetails.csv', $headers);
	}
}
