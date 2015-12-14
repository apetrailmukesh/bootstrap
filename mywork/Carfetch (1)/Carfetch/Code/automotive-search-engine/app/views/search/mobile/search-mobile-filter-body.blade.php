<div id="mobileBodyModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Body Style</h2>
	<form id="mobile-filter-by-body">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-body-any" value="0" checked><label for="mobile-body-any">Any Body Style</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['body'] as $body)
					<p><input type="checkbox" id="mobile-body-{{$body['key']}}" value="{{$body['key']}}"/><label for="mobile-body-{{$body['key']}}">{{ $body['title'] }}</label></p>
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