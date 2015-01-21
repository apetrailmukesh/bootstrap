<?php

Route::get('/', array('as' => 'get.home', 'uses' => 'HomeController@index'));
Route::post('/', array('as' => 'post.home', 'uses' => 'HomeController@change'));

Route::get('/search', array('as' => 'get.search', 'uses' => 'SearchController@index'));
Route::post('/search', array('as' => 'post.search', 'uses' => 'SearchController@search'));

Route::get('/user/login', array('as' => 'get.user.login', 'uses' => 'UserController@getLogin'))->before('guest');
Route::post('/user/login', array('as' => 'post.user.login', 'uses' => 'UserController@login'));

Route::get('/user/register', array('as' => 'get.user.register', 'uses' => 'UserController@getRegister'))->before('guest');
Route::post('/user/register', array('as' => 'post.user.register', 'uses' => 'UserController@register'));

Route::get('/user/profile', array('as' => 'get.user.profile', 'uses' => 'UserController@getProfile'))->before('auth');
Route::post('/user/profile', array('as' => 'post.user.profile', 'uses' => 'UserController@profile'))->before('auth');

Route::get('/user/logout', array('as' => 'get.user.logout', 'uses' => 'UserController@logout'))->before('auth');