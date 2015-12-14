<div id="mobileStatusModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Condition</h2>
	<form id="mobile-filter-by-status">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-status-any" value="0" checked><label for="mobile-status-any">Any Condition</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['status'] as $status)
					<p><input type="checkbox" id="mobile-status-{{$status['key']}}" value="{{$status['key']}}"/><label for="mobile-status-{{$status['key']}}">{{ $status['title'] }}</label></p>
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