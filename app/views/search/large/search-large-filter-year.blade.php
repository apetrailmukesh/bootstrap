<div id="yearModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Year</h2>
	<form id="filter-by-year">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="year-any" value="0" checked><label for="year-any">Any Year</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['year'] as $year)
							@if($year['index']%2 === 0)
								<p><input type="checkbox" id="year-{{$year['key']}}" value="{{$year['key']}}"/><label for="year-{{$year['key']}}">{{ $year['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['year'] as $year)
							@if($year['index']%2 === 1)
								<p><input type="checkbox" id="year-{{$year['key']}}" value="{{$year['key']}}"/><label for="year-{{$year['key']}}">{{ $year['title'] }}</label></p>
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