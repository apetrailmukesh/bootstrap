{{ Form::open(array('route' => 'post.search')) }}
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="row collapse">
				<div class="small-10 medium-11 large-11 columns">
					{{ Form::text('search_text', Input::old('search_text'),  array('placeholder'=>'Enter make, model, or style', 'class' => 'typeahead')) }}
				</div>
				<div class="small-2 medium-1 large-1 columns">
					<button type="submit" class="button postfix">GO</button>
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}