<div id="mobileTransmissionModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Transmission</h2>
	<form id="mobile-filter-by-transmission">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-transmission-any" value="0" checked><label for="mobile-transmission-any">Any Transmission</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['transmission'] as $transmission)
					<p><input type="checkbox" id="mobile-transmission-{{$transmission['key']}}" value="{{$transmission['key']}}"/><label for="mobile-transmission-{{$transmission['key']}}">{{ $transmission['title'] }}</label></p>
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