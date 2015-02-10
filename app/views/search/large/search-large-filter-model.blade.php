<div id="modelModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Model</h2>
	<form id="filter-by-model">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="model-any" value="0" checked><label for="model-any">Any model</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['model'] as $model)
							@if($model['index']%2 === 0)
								<p><input type="checkbox" id="model-{{$model['key']}}" value="{{$model['key']}}"/><label for="model-{{$model['key']}}">{{ $model['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['model'] as $model)
							@if($model['index']%2 === 1)
								<p><input type="checkbox" id="model-{{$model['key']}}" value="{{$model['key']}}"/><label for="model-{{$model['key']}}">{{ $model['title'] }}</label></p>
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