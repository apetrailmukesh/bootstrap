<div id="mobileExteriorModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Exterior Color</h2>
	<form id="mobile-filter-by-exterior">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-exterior-any" value="0" checked><label for="mobile-exterior-any">Any Color</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['exterior'] as $exterior)
					<p><input type="checkbox" id="mobile-exterior-{{$exterior['key']}}" value="{{$exterior['key']}}"/><label for="mobile-exterior-{{$exterior['key']}}">{{ $exterior['title'] }}</label></p>
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