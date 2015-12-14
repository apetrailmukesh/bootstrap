<div id="mobileFuelModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Fuel Type</h2>
	<form id="mobile-filter-by-fuel">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-fuel-any" value="0" checked><label for="mobile-fuel-any">Any Fuel Type</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['fuel'] as $fuel)
					<p><input type="checkbox" id="mobile-fuel-{{$fuel['key']}}" value="{{$fuel['key']}}"/><label for="mobile-fuel-{{$fuel['key']}}">{{ $fuel['title'] }}</label></p>
				@endforeach
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