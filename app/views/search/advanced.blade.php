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
						<select id="advanced-make">
							<option value="">Any Make</option>
							@foreach($makes as $make)
								<option value="{{ $make['class'] }}">{{ $make['name']}}</option>
							@endforeach
						</select>
					</div>
					<div class="small-12 medium-5 large-4 columns end">
						<select id="advanced-model">
							<option value="">Any Model</option>
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
						<input type="text" placeholder="No Minimum" id="advanced-price-min"/>
					</div>
					<div class="small-7 medium-3 large-2 columns end">
						<label>Max Price</label>
						<input type="text" placeholder="No Maximum" id="advanced-price-max"/>
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
					<div class="small-7 medium-3 large-2 columns">
						<label>Min Mileage</label>
						<input type="text" placeholder="No Minimum" id="advanced-mileage-min"/>
					</div>
					<div class="small-7 medium-3 large-2 columns end">
						<label>Max Mileage</label>
						<input type="text" placeholder="No Maximum" id="advanced-mileage-max"/>
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
						<input type="text" placeholder="No Minimum" id="advanced-year-min"/>
					</div>
					<div class="small-7 medium-3 large-2 columns end">
						<label>To</label>
						<input type="text" placeholder="No Maximum" id="advanced-year-max"/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Exterior Color</legend>
					</div>
				</div>
				<div class="row" id="advanced-exterior">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="advanced-exterior-any" value="0" checked><label for="advanced-exterior-any">Any Exterior Color</label>
					</div>
					@foreach($exteriors as $exterior)
						<div class="small-12 medium-3 large-2 columns {{$exterior['end']}}">
							<input type="checkbox" id="{{$exterior['id']}}" class="{{$exterior['class']}}"><label for="{{$exterior['id']}}">{{$exterior['name']}}</label>
						</div>
					@endforeach
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Interior Color</legend>
					</div>
				</div>
				<div class="row" id="advanced-interior">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="advanced-interior-any" value="0" checked><label for="advanced-interior-any">Any Interior Color</label>
					</div>
					@foreach($interiors as $interior)
						<div class="small-12 medium-3 large-2 columns {{$interior['end']}}">
							<input type="checkbox" id="{{$interior['id']}}" class="{{$interior['class']}}"><label for="{{$interior['id']}}">{{$interior['name']}}</label>
						</div>
					@endforeach
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Engine</legend>
					</div>
				</div>
				<div class="row" id="advanced-cylinders">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="advanced-cylinders-any" value="0" checked><label for="advanced-cylinders-any">Any Engine</label>
					</div>
					@foreach($cylinders_count as $cylinders)
						<div class="small-12 medium-3 large-2 columns {{$cylinders['end']}}">
							<input type="checkbox" id="{{$cylinders['id']}}" class="{{$cylinders['class']}}"><label for="{{$cylinders['id']}}">{{$cylinders['name']}}</label>
						</div>
					@endforeach
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Transmission</legend>
					</div>
				</div>
				<div class="row" id="advanced-transmission">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="advanced-transmission-any" value="0" checked><label for="advanced-transmission-any">Any Transmission</label>
					</div>
					@foreach($transmissions as $transmission)
						<div class="small-12 medium-3 large-2 columns {{$transmission['end']}}">
							<input type="checkbox" id="{{$transmission['id']}}" class="{{$transmission['class']}}"><label for="{{$transmission['id']}}">{{$transmission['name']}}</label>
						</div>
					@endforeach
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Drivetrain</legend>
					</div>
				</div>
				<div class="row" id="advanced-drive">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="advanced-drive-any" value="0" checked><label for="advanced-drive-any">Any Drivetrain</label>
					</div>
					@foreach($drives as $drive)
						<div class="small-12 medium-3 large-2 columns {{$drive['end']}}">
							<input type="checkbox" id="{{$drive['id']}}" class="{{$drive['class']}}"><label for="{{$drive['id']}}">{{$drive['name']}}</label>
						</div>
					@endforeach
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Fuel Type</legend>
					</div>
				</div>
				<div class="row" id="advanced-fuel">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="advanced-fuel-any" value="0" checked><label for="advanced-fuel-any">Any Fuel Type</label>
					</div>
					@foreach($fuels as $fuel)
						<div class="small-12 medium-3 large-2 columns {{$fuel['end']}}">
							<input type="checkbox" id="{{$fuel['id']}}" class="{{$fuel['class']}}"><label for="{{$fuel['id']}}">{{$fuel['name']}}</label>
						</div>
					@endforeach
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="small-12 columns">
						<legend>Door Count</legend>
					</div>
				</div>
				<div class="row" id="advanced-doors">
					<div class="small-12 medium-3 large-2 columns">
						<input type="checkbox" id="advanced-doors-any" value="0" checked><label for="advanced-doors-any">Any Door Count</label>
					</div>
					@foreach($doors_count as $doors)
						<div class="small-12 medium-3 large-2 columns {{$doors['end']}}">
							<input type="checkbox" id="{{$doors['id']}}" class="{{$doors['class']}}"><label for="{{$doors['id']}}">{{$doors['name']}}</label>
						</div>
					@endforeach
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