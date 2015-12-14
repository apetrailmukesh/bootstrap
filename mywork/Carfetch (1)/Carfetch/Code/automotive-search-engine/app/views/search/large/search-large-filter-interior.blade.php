<div id="interiorModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Interior Color</h2>
	<form id="filter-by-interior">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="interior-any" value="0" checked><label for="interior-any">Any Color</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['interior'] as $interior)
							@if($interior['index']%2 === 0)
								<p><input type="checkbox" id="interior-{{$interior['key']}}" value="{{$interior['key']}}"/><label for="interior-{{$interior['key']}}">{{ $interior['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['interior'] as $interior)
							@if($interior['index']%2 === 1)
								<p><input type="checkbox" id="interior-{{$interior['key']}}" value="{{$interior['key']}}"/><label for="interior-{{$interior['key']}}">{{ $interior['title'] }}</label></p>
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