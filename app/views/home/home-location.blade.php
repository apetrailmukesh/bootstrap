<div class="row">
	<div class="small-12 small-centered text-center column">
		<a href="#" class="fa-icon location" data-reveal-id="locationModal">{{ $location_info }}</a>
		<div id="locationModal" class="reveal-modal medium location-modal" data-reveal>
			<h2>Change Location</h2>
			{{ Form::open(array('route' => 'post.home.change')) }}
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
					{{ Form::text('zip_code', $zip_code,  array('placeholder'=>'12345', 'class' => 'zip-search')) }}
				</label>
			</div>
			<div class="small-12 medium-4 large-4 columns">
				<label><br />
					<button type="submit" class="radius">Update</button>
				</label>
			</div>
		</div>
		{{ Form::close() }}
		<a class="close-reveal-modal">&#215</a>
	</div>
</div>
</div>