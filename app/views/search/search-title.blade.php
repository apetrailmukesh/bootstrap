<div class="row">
	<div class="small-12 columns">
		<h1>{{ $title }}</h1>
	</div>
</div>
<div class="row">
	<div class="small-12 medium-8 large-9 columns">
		<p class="location-change">We found <strong>{{ $total }} cars for sale</strong> within <a href="#" data-reveal-id="locationModal"><strong>{{ $location_info }}</strong></a></p>
		<div id="locationModal" class="reveal-modal medium location-modal" data-reveal>
			<h2>Change Location</h2>
			<form id="change-search-location">
			<div class="row">
				<div class="small-6 medium-4 large-4 columns">
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
				</label>
			</div>
			<div class="small-6 medium-4 large-4 columns">
				<label>Zip Code
					{{ Form::text('zip_code', $zip_code,  array('placeholder'=>'12345')) }}
				</label>
			</div>
			<div class="small-12 medium-4 large-4 columns">
				<label><br />
					<button type="submit" class="radius">Update</button>
				</label>
			</div>
		</div>
		</form>
		<a class="close-reveal-modal">&#215</a>
	</div>
</div>
@include('search/large/search-large-sort')
</div>