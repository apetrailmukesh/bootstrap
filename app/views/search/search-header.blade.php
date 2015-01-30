<div class="hide-for-small search-bkgrd"> <!-- show for everything 640px and above -->
	<div class="row">
		<div class="small-3 columns">
			<h1 class="logo">
				<span>site</span><span>name</span><span>.com</span>
			</h1>
		</div>
		<form id="web_search" class="results-search-form">
			<div class="small-9 columns">
				<div class="row collapse">
					<div class="small-10 medium-11 large-11 columns">
						{{ Form::text('search_text', $search_text,  array('placeholder'=>'Enter make, model, or style', 'class' => 'typeahead')) }}
					</div>
					<div class="small-2 medium-1 large-1 columns">
						<button type="submit" class="button postfix">GO</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="show-for-small search-bkgrd"> <!-- mobile version -->
	<div class="row">
		<div class="small-10 columns">
			<h1 class="logo">
				<span>site</span><span>name</span><span>.com</span>
			</h1>
		</div>
		<div class="small-2 text-right columns">
			<span class="fa-icon search" id="open-mobile-search"></span>
		</div>
	</div>
	<div class="row not-visible" id="mobile-search-box">
		<form id="mobile_search" class="results-search-form">
			<div class="small-12 column small-centered">
				<div class="row collapse">
					<div class="small-10 columns">
						{{ Form::text('search_text', $search_text,  array('placeholder'=>'Enter make, model, or style', 'class' => 'typeahead')) }}
					</div>
					<div class="small-2 columns">
						<button type="submit" class="button postfix">GO</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>