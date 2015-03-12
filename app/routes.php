<?php

Route::get('/', array('as' => 'get.home', 'uses' => 'HomeController@index'));
Route::get('/search', array('as' => 'get.search', 'uses' => 'SearchController@index'));
Route::get('/advanced', array('as' => 'get.advanced', 'uses' => 'AdvancedController@index'));
Route::get('/vehicle', array('as' => 'get.vehicle', 'uses' => 'VehicleController@index'));

Route::post('/', array('as' => 'post.home.change', 'uses' => 'HomeController@change'));

Route::get('/user/login', array('as' => 'get.user.login', 'uses' => 'UserController@getLogin'))->before('guest');
Route::get('/user/register', array('as' => 'get.user.register', 'uses' => 'UserController@getRegister'))->before('guest');
Route::get('/user/profile', array('as' => 'get.user.profile', 'uses' => 'UserController@getProfile'))->before('auth');
Route::get('/user/saved-cars', array('as' => 'get.user.saved-cars', 'uses' => 'UserController@getSavedCars'))->before('auth');
Route::get('/user/saved-searches', array('as' => 'get.user.saved-searches', 'uses' => 'UserController@getSavedSearches'))->before('auth');

Route::post('/user/login', array('as' => 'post.user.login', 'uses' => 'UserController@login'));
Route::post('/user/register', array('as' => 'post.user.register', 'uses' => 'UserController@register'));
Route::post('/user/profile', array('as' => 'post.user.profile', 'uses' => 'UserController@profile'))->before('auth');

Route::get('/admin/upload', array('as' => 'get.admin.upload', 'uses' => 'AdminController@getUpload'))->before('admin');
Route::get('/admin/dealers', array('as' => 'get.admin.dealers', 'uses' => 'AdminController@getDealers'))->before('admin');
Route::get('/admin/clicks', array('as' => 'get.admin.clicks', 'uses' => 'AdminController@getClicks'))->before('admin');
Route::get('/admin/dealers/edit/{id}', array('as' => 'get.admin.dealers.edit', 'uses' => 'AdminController@getEditDealers'))->before('admin');

Route::post('/admin/upload', array('as' => 'post.admin.upload', 'uses' => 'AdminController@upload'))->before('admin');
Route::post('/admin/clicks', array('as' => 'post.admin.clicks', 'uses' => 'AdminController@downloadClicks'))->before('admin');
Route::post('/admin/dealers/edit/{id}', array('as' => 'post.admin.dealers.edit', 'uses' => 'AdminController@editDealer'))->before('admin');

Route::get('/user/logout', array('as' => 'get.user.logout', 'uses' => 'UserController@logout'))->before('auth');

Route::get('/suggest/vehicle', array('as' => 'get.suggest.vehicle', 'uses' => 'SuggestController@vehicle'));
Route::get('/suggest/model', array('as' => 'get.suggest.model', 'uses' => 'SuggestController@model'));
Route::get('/suggest/makemodel', array('as' => 'get.suggest.makemodel', 'uses' => 'SuggestController@makemodel'));