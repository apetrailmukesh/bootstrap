<?php

class UserController extends BaseController {

	protected $layout = 'base';

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
	        	return Redirect::route('get.user.profile');
	        }
	        else {
				return Redirect::to('user/login')->with('message', 'Invalid email or password')->withInput();
	        }
	    } else {
	        return Redirect::to('user/login')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
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
    		return Redirect::to('user/login')->with('message', 'Thanks for registering! Please log in to continue.');
	    } else {
	        return Redirect::to('user/register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
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
    		return Redirect::to('user/profile')->with('message', 'Profile updated successfully.');
	    } else {
	        return Redirect::to('user/profile')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
	    }
	}

	public function logout()
	{
		$this->layout->body_class = 'user';
		Auth::logout();
    	return Redirect::route('get.home');
	}
}
