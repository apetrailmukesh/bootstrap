<div id="mobileDoorsModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Doors</h2>
	<form id="mobile-filter-by-doors">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-doors-any" value="0" checked><label for="mobile-doors-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['doors'] as $doors)
					<p><input type="checkbox" id="mobile-doors-{{$doors['key']}}" value="{{$doors['key']}}"/><label for="mobile-doors-{{$doors['key']}}">{{ $doors['title'] }}</label></p>
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