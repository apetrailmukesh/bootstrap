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

	public function getSpecificationsAdd()
	{
		$this->layout->body_class = 'user';
		$data = array();
		$this->layout->contents = View::make('admin/admin-specifications-add', $data);
	}

	public function getUpload()
	{
		$this->layout->body_class = 'user';
		$data = array(
			'action' => 'Insert',
			'files' => DataFile::all()
		);

		$this->layout->contents = View::make('admin/admin-upload', $data);
	}

	public function addSpecification()
	{
		$this->layout->body_class = 'user';
		Input::flashOnly('name', 'display', 'type', 'enabled');
		
		$rules = array(
		    'name'=>'required|alpha|min:2',
			'display'=>'required|alpha|min:2',
			'type'=>'required'
	    );

		$validator = Validator::make(Input::all(), $rules);
	    if ($validator->passes()) {
	        $specificationType = new SpecificationType;
		    $specificationType->name = Input::get('name');
		    $specificationType->display = Input::get('display');
		    $specificationType->type = Input::get('type');

		    if (Input::get('enabled') === 'true') {
			    $specificationType->enabled = 1;
			} else {
			    $specificationType->enabled = 0;
			}

		    $specificationType->save();
    		return Redirect::route('get.admin.specifications')->with('message', 'Specification type added successfully');
	    } else {
	        return Redirect::route('get.admin.specifications.add')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
	    }
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
