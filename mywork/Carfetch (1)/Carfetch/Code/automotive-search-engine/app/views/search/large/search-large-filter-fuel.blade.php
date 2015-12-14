<div id="fuelModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Fuel Type</h2>
	<form id="filter-by-fuel">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="fuel-any" value="0" checked><label for="fuel-any">Any Fuel Type</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['fuel'] as $fuel)
							@if($fuel['index']%2 === 0)
								<p><input type="checkbox" id="fuel-{{$fuel['key']}}" value="{{$fuel['key']}}"/><label for="fuel-{{$fuel['key']}}">{{ $fuel['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['fuel'] as $fuel)
							@if($fuel['index']%2 === 1)
								<p><input type="checkbox" id="fuel-{{$fuel['key']}}" value="{{$fuel['key']}}"/><label for="fuel-{{$fuel['key']}}">{{ $fuel['title'] }}</label></p>
							@endif
						@endforeach
					</div>
				</div>
				<div class="row">
					<div class="small 12 columns">
						<button type="submit" class="radius">Update Results</button>
						<a class="close-reveal-modal cancel">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal">&#215</a>
</div>