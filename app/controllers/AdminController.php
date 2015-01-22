<?php

class AdminController extends BaseController {

	protected $layout = 'base';

	public function getSpecifications()
	{
		$this->layout->body_class = 'user';
		$data = array(
			'specification_types' => SpecificationType::all()
		);

		$this->layout->contents = View::make('admin/admin-specifications', $data);
	}

	public function getUpload()
	{
		$this->layout->body_class = 'user';
		$data = array(
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
				$file = new DataFile;
		    	$file->name = Input::file('file')->getClientOriginalName();
		    	$file->status = 'Uploaded';
		    	$file->logs = '';
		    	$file->save();

    			Input::file('file')->move(storage_path().'/upload/', Input::file('file')->getClientOriginalName());
    			return Redirect::route('get.admin.upload')->with('message', 'File uploaded successfully');
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
