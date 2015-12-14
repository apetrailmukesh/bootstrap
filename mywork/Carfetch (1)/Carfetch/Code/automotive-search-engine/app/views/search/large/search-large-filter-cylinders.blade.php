<div id="cylindersModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Cylinders</h2>
	<form id="filter-by-cylinders">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="cylinders-any" value="0" checked><label for="cylinders-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['cylinders'] as $cylinders)
							@if($cylinders['index']%2 === 0)
								<p><input type="checkbox" id="cylinders-{{$cylinders['key']}}" value="{{$cylinders['key']}}"/><label for="cylinders-{{$cylinders['key']}}">{{ $cylinders['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['cylinders'] as $cylinders)
							@if($cylinders['index']%2 === 1)
								<p><input type="checkbox" id="cylinders-{{$cylinders['key']}}" value="{{$cylinders['key']}}"/><label for="cylinders-{{$cylinders['key']}}">{{ $cylinders['title'] }}</label></p>
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