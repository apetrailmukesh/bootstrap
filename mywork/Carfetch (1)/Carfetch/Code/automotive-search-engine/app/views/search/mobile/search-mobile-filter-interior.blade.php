<div id="mobileInteriorModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Interior Color</h2>
	<form id="mobile-filter-by-interior">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-interior-any" value="0" checked><label for="mobile-interior-any">Any Color</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['interior'] as $interior)
					<p><input type="checkbox" id="mobile-interior-{{$interior['key']}}" value="{{$interior['key']}}"/><label for="mobile-interior-{{$interior['key']}}">{{ $interior['title'] }}</label></p>
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