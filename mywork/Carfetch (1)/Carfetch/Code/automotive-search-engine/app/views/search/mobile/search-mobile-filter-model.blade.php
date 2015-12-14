<div id="mobileModelModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Model</h2>
	<form id="mobile-filter-by-model">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-model-any" value="0" checked><label for="mobile-model-any">Any Model</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['model'] as $model)
					<p><input type="checkbox" id="mobile-model-{{$model['key']}}" value="{{$model['key']}}"/><label for="mobile-model-{{$model['key']}}">{{ $model['title'] }}</label></p>
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