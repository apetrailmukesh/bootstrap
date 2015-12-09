<div id="dealerModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Dealer</h2>
	<form id="filter-by-dealer">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="dealer-any" value="0" checked><label for="dealer-any">Any Dealer</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['dealer'] as $dealer)
							@if($dealer['index']%2 === 0)
								<p><input type="checkbox" id="dealer-{{$dealer['key']}}" value="{{$dealer['key']}}"/><label for="dealer-{{$dealer['key']}}">{{ $dealer['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['dealer'] as $dealer)
							@if($dealer['index']%2 === 1)
								<p><input type="checkbox" id="dealer-{{$dealer['key']}}" value="{{$dealer['key']}}"/><label for="dealer-{{$dealer['key']}}">{{ $dealer['title'] }}</label></p>
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