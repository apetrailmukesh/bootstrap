<?php

class Vehicle extends Eloquent {

	protected $table = 'vehicle';
	protected $primaryKey = 'vin';
	public $timestamps = true;
}
