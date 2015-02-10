<div id="makeModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Make</h2>
	<form id="filter-by-make">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="make-any" value="0" checked><label for="make-any">Any Make</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['make'] as $make)
							@if($make['index']%2 === 0)
								<p><input type="checkbox" id="make-{{$make['key']}}" value="{{$make['key']}}"/><label for="make-{{$make['key']}}">{{ $make['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['make'] as $make)
							@if($make['index']%2 === 1)
								<p><input type="checkbox" id="make-{{$make['key']}}" value="{{$make['key']}}"/><label for="make-{{$make['key']}}">{{ $make['title'] }}</label></p>
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