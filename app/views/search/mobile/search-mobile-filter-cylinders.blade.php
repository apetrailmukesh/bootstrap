<div id="mobileCylindersModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Cylinders</h2>
	<form id="mobile-filter-by-cylinders">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-cylinders-any" value="0" checked><label for="mobile-cylinders-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['cylinders'] as $cylinders)
					<p><input type="checkbox" id="mobile-cylinders-{{$cylinders['key']}}" value="{{$cylinders['key']}}"/><label for="mobile-cylinders-{{$cylinders['key']}}">{{ $cylinders['title'] }}</label></p>
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