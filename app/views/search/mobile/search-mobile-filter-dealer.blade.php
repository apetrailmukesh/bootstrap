<div id="mobileDealerModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Dealer</h2>
	<form id="mobile-filter-by-dealer">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-dealer-any" value="0" checked><label for="mobile-dealer-any">Any Dealer</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['dealer'] as $dealer)
					<p><input type="checkbox" id="mobile-dealer-{{$dealer['key']}}" value="{{$dealer['key']}}"/><label for="mobile-dealer-{{$dealer['key']}}">{{ $dealer['title'] }}</label></p>
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