<div id="statusModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Condition</h2>
	<form id="filter-by-status">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="status-any" value="0" checked><label for="status-any">Any Condition</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['status'] as $status)
							@if($status['index']%2 === 0)
								<p><input type="checkbox" id="status-{{$status['key']}}" value="{{$status['key']}}"/><label for="status-{{$status['key']}}">{{ $status['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['status'] as $status)
							@if($status['index']%2 === 1)
								<p><input type="checkbox" id="status-{{$status['key']}}" value="{{$status['key']}}"/><label for="status-{{$status['key']}}">{{ $status['title'] }}</label></p>
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