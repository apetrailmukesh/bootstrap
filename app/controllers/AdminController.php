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

		$data = array(
			'id' => $dealer->id,
			'name' => $dealer->dealer,
			'paid' => $paid,
			'clicks' => $clicks
		);

		$this->layout->contents = View::make('admin/admin-dealers-edit', $data);
	}

	public function editDealer()
	{
		$dealer = Dealer::find(Input::get('id'));

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
		
		$dealer->save();

		DB::table('vehicle')->where('dealer', $dealer->id)->update(array('modified' => 1, 'paid' => $dealer->active));

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
}
