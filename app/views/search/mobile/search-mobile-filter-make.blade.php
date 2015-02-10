<div id="mobileMakeModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Make</h2>
	<form id="mobile-filter-by-make">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-make-any" value="0" checked><label for="mobile-make-any">Any Make</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['make'] as $make)
					<p><input type="checkbox" id="mobile-make-{{$make['key']}}" value="{{$make['key']}}"/><label for="mobile-make-{{$make['key']}}">{{ $make['title'] }}</label></p>
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