<div id="transmissionModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Transmission</h2>
	<form id="filter-by-transmission">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="transmission-any" value="0" checked><label for="transmission-any">Any Transmission</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['transmission'] as $transmission)
							@if($transmission['index']%2 === 0)
								<p><input type="checkbox" id="transmission-{{$transmission['key']}}" value="{{$transmission['key']}}"/><label for="transmission-{{$transmission['key']}}">{{ $transmission['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['transmission'] as $transmission)
							@if($transmission['index']%2 === 1)
								<p><input type="checkbox" id="transmission-{{$transmission['key']}}" value="{{$transmission['key']}}"/><label for="transmission-{{$transmission['key']}}">{{ $transmission['title'] }}</label></p>
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