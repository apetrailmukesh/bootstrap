<div id="mobileYearModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Year</h2>
	<form id="mobile-filter-by-year">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-year-any" value="0" checked><label for="mobile-year-any">Any Year</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['year'] as $year)
					<p><input type="checkbox" id="mobile-year-{{$year['key']}}" value="{{$year['key']}}"/><label for="mobile-year-{{$year['key']}}">{{ $year['title'] }}</label></p>
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