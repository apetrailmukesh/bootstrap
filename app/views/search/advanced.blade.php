@section('contents')
<header>
	@include('header')
	@include('search/search-header')
</header>
<section role="main">
	<header>
		<div class="row">
			<div class="small-12 columns">
				<h1>Advanced Search</h1>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="small-12 columns">
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Condition</legend>
					</div>
				</div>
				<div class="row" id="advanced-status">
					<div class="small-12 medium-3 large-2 columns">
						<input type="radio" name="condition" id="advanced-status-any" value="0" checked><label for="advanced-status-any">Any Condition</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="radio" name="condition" id="advanced-status-new" class="{{$status['new_id']}}"><label for="advanced-status-new">New</label>
					</div>
					<div class="small-12 medium-3 large-2 columns end">
						<input type="radio" name="condition" id="advanced-status-used" class="{{$status['used_id']}}"><label for="advanced-status-used">Used</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Body Style</legend>
					</div>
				</div>
				<div class="row" id="advanced-body">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="advanced-body-any" value="0" checked><label for="advanced-body-any">Any Body Style</label>
					</div>
					@foreach($bodies as $body)
						<div class="small-12 medium-3 large-2 columns {{$body['end']}}">
							<input type="checkbox" id="{{$body['id']}}" class="{{$body['class']}}"><label for="{{$body['id']}}">{{$body['name']}}</label>
						</div>
					@endforeach
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Make &amp; Model</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-3 large-2 columns">
						<select>
							<option value="0">Any Make</option>
						</select>
					</div>
					<div class="small-12 medium-5 large-4 columns end">
						<select>
							<option value="0">Any Model</option>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Price</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-7 medium-3 large-2 columns">
						<label>Min Price</label>
						<input type="text" placeholder="No Minimum" />
					</div>
					<div class="small-7 medium-3 large-2 columns end">
						<label>Max Price</label>
						<input type="text" placeholder="No Maximum" />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Mileage</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-7 medium-3 large-2 columns end">
						<input type="text" placeholder="No Maximum" />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Years</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-7 medium-3 large-2 columns">
						<label>From</label>
						<select>
							<option value="1920">1920</option>
						</select>
					</div>
					<div class="small-7 medium-3 large-2 columns end">
						<label>To</label>
						<select>
							<option value="2016">2016</option>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Exterior Color</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorAny" checked><label for="extcolorAny">Any Color</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorBeige"><label for="extcolorBeige">Beige</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorBlack"><label for="extcolorBlack">Black</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorBlue"><label for="extcolorBlue">Blue</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorBrown"><label for="extcolorBrown">Brown</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorGold"><label for="extcolorGold">Gold</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorGray"><label for="extcolorGray">Gray</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorGreen"><label for="extcolorGreen">Green</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorOrange"><label for="extcolorOrange">Orange</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorPurple"><label for="extcolorPurple">Purple</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorRed"><label for="extcolorRed">Red</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorSilver"><label for="extcolorSilver">Silver</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="extcolorWhite"><label for="extcolorWhite">White</label>
					</div>
					<div class="small-12 medium-3 large-2 columns end">
						<input type="checkbox" id="extcolorYellow"><label for="extcolorYellow">Yellow</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Interior Color</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorAny" checked><label for="intcolorAny">Any Color</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorBeige"><label for="intcolorBeige">Beige</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorBlack"><label for="intcolorBlack">Black</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorBlue"><label for="intcolorBlue">Blue</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorBrown"><label for="intcolorBrown">Brown</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorGray"><label for="intcolorGray">Gray</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorGreen"><label for="intcolorGreen">Green</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorOrange"><label for="intcolorOrange">Orange</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorRed"><label for="intcolorRed">Red</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorSilver"><label for="intcolorSilver">Silver</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorWhite"><label for="intcolorWhite">White</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="intcolorYellow"><label for="intcolorYellow">Yellow</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Engine</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="engineAny" checked><label for="engineAny">Any Engine</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="engine3Cyl"><label for="engine3Cyl">3 Cylinders</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="engine4Cyl"><label for="engine4Cyl">4 Cylinders</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="engine5Cyl"><label for="engine5Cyl">5 Cylinders</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="engine6Cyl"><label for="engine6Cyl">6 Cylinders</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="engine8Cyl"><label for="engine8Cyl">8 Cylinders</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="engine10Cyl"><label for="engine10Cyl">10 Cylinders</label>
					</div>
					<div class="small-12 medium-3 large-2 columns end">
						<input type="checkbox" id="engine12Cyl"><label for="engine12Cyl">12 Cylinders</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Transmission</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="transAny" checked><label for="transAny">Any Trans.</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="transAuto"><label for="transAuto">Automatic</label>
					</div>
					<div class="small-12 medium-3 large-2 columns end">
						<input type="checkbox" id="transMan"><label for="transMan">Manual</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Drivetrain</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="drivetrainAny" checked><label for="drivetrainAny">Any Drivetrain</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="drivetrain4WD"><label for="drivetrain4WD">4WD</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="drivetrainAWD"><label for="drivetrainAWD">AWD</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="drivetrainFWD"><label for="drivetrainFWD">FWD</label>
					</div>
					<div class="small-12 medium-3 large-2 columns end">
						<input type="checkbox" id="drivetrainRWD"><label for="drivetrainRWD">RWD</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Fuel Type</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="fuelTypeAny" checked><label for="fuelTypeAny">Any Fuel Type</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="fuelTypeDiesel"><label for="fuelTypeDiesel">Diesel</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="fuelTypeE85"><label for="fuelTypeE85">E-85/Gasoline</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="fuelTypeElectric"><label for="fuelTypeElectric">Electric</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="fuelTypeGas"><label for="fuelTypeGas">Gasoline</label>
					</div>
					<div class="small-12 medium-3 large-2 columns end">
						<input type="checkbox" id="fuelTypeHybrid"><label for="fuelTypeHybrid">Hybrid/Gasoline</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Door Count</legend>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="doorCountAny" checked><label for="doorCountAny">Any Door Count</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="doorCount2"><label for="doorCountAny">2 Doors</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="doorCount3"><label for="doorCountAny">3 Doors</label>
					</div>
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="doorCount4"><label for="doorCountAny">4 Doors</label>
					</div>
					<div class="small-12 medium-3 large-2 columns end">
						<input type="checkbox" id="doorCount5"><label for="doorCountAny">5 Doors</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Location</legend>
					</div>
				</div>
				<div class="row" id="advanced-location">
					<div class="small-7 medium-3 large-2 columns">
						<label>Distance
							{{ Form::select('distance', [
							'10' => '10 Miles',
							'25' => '25 Miles',
							'50' => '50 Miles',
							'75' => '75 Miles',
							'100' => '100 Miles',
							'150' => '150 Miles',
							'200' => '200 Miles',
							'250' => '250 Miles',
							'500' => '500 Miles',
							'0' => 'Unlimited'], $distance)
						}}
					</div>
					<div class="small-7 medium-3 large-2 columns end">
						<label>Zip Code
							{{ Form::text('zip_code', $zip_code,  array('placeholder'=>'12345', 'class' => 'zip-search')) }}
						</label>
					</div>
				</div>
				<div class="row">
					<div class="small-7 medium-3 large-2 columns end">
						<button type="submit" class="radius" id="advanced-search-submit">Start Search</button>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</section>
@stop