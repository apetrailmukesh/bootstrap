<?php

Route::get('/', array('as' => 'get.home', 'uses' => 'HomeController@index'));
Route::get('/search', array('as' => 'get.search', 'uses' => 'SearchController@index'));

Route::post('/', array('as' => 'post.home', 'uses' => 'HomeController@change'));
Route::post('/search', array('as' => 'post.home.start', 'uses' => 'HomeController@search'));

Route::get('/user/login', array('as' => 'get.user.login', 'uses' => 'UserController@getLogin'))->before('guest');
Route::get('/user/register', array('as' => 'get.user.register', 'uses' => 'UserController@getRegister'))->before('guest');
Route::get('/user/profile', array('as' => 'get.user.profile', 'uses' => 'UserController@getProfile'))->before('auth');
Route::get('/user/saved-cars', array('as' => 'get.user.saved-cars', 'uses' => 'UserController@getSavedCars'))->before('auth');
Route::get('/user/saved-searches', array('as' => 'get.user.saved-searches', 'uses' => 'UserController@getSavedSearches'))->before('auth');

Route::post('/user/login', array('as' => 'post.user.login', 'uses' => 'UserController@login'));
Route::post('/user/register', array('as' => 'post.user.register', 'uses' => 'UserController@register'));
Route::post('/user/profile', array('as' => 'post.user.profile', 'uses' => 'UserController@profile'))->before('auth');

Route::get('/admin/specifications', array('as' => 'get.admin.specifications', 'uses' => 'AdminController@getSpecifications'))->before('admin');
Route::get('/admin/specifications/add', array('as' => 'get.admin.specifications.add', 'uses' => 'AdminController@getSpecificationsAdd'))->before('admin');
Route::get('/admin/upload', array('as' => 'get.admin.upload', 'uses' => 'AdminController@getUpload'))->before('admin');

Route::post('/admin/specifications/add', array('as' => 'post.admin.specifications.add', 'uses' => 'AdminController@addSpecification'))->before('admin');
Route::post('/admin/upload', array('as' => 'post.admin.upload', 'uses' => 'AdminController@upload'))->before('admin');

Route::get('/user/logout', array('as' => 'get.user.logout', 'uses' => 'UserController@logout'))->before('auth');