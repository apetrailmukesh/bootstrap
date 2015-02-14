<div id="doorsModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Doors</h2>
	<form id="filter-by-doors">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="doors-any" value="0" checked><label for="doors-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['doors'] as $doors)
							@if($doors['index']%2 === 0)
								<p><input type="checkbox" id="doors-{{$doors['key']}}" value="{{$doors['key']}}"/><label for="doors-{{$doors['key']}}">{{ $doors['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['doors'] as $doors)
							@if($doors['index']%2 === 1)
								<p><input type="checkbox" id="doors-{{$doors['key']}}" value="{{$doors['key']}}"/><label for="doors-{{$doors['key']}}">{{ $doors['title'] }}</label></p>
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