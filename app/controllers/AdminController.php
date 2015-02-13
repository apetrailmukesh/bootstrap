<?php

class AdminController extends BaseController {

	protected $layout = 'base';

	public function getUpload()
	{
		$this->layout->body_class = 'user';
		$data = array(
			'action' => 'Insert',
			'files' => DataFile::all()
		);

		$this->layout->contents = View::make('admin/admin-upload', $data);
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
			    	$file->action = Input::get('action');
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
