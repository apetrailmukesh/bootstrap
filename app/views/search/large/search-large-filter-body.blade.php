<div id="bodyModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Body Style</h2>
	<form id="filter-by-body">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="body-any" value="0" checked><label for="body-any">Any Body Style</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['body'] as $body)
							@if($body['index']%2 === 0)
								<p><input type="checkbox" id="body-{{$body['key']}}" value="{{$body['key']}}"/><label for="body-{{$body['key']}}">{{ $body['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['body'] as $body)
							@if($body['index']%2 === 1)
								<p><input type="checkbox" id="body-{{$body['key']}}" value="{{$body['key']}}"/><label for="body-{{$body['key']}}">{{ $body['title'] }}</label></p>
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