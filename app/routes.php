<?php

Route::match(array('GET', 'POST'), '/', 'HomeController@index');

Route::match(array('GET', 'POST'), '/search', 'SearchController@index');