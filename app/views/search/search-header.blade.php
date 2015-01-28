<div class="hide-for-small search-bkgrd"> <!-- show for everything 640px and above -->
	<div class="row">
		<div class="small-3 columns">
			<h1 class="logo">
				<span>site</span><span>name</span><span>.com</span>
			</h1>
		</div>
		<div class="small-9 columns">
			<div class="row collapse">
				<div class="small-10 medium-11 large-11 columns">
					<input type="text" class="typeahead" placeholder="{{ $search_text }}" />
				</div>
				<div class="small-2 medium-1 large-1 columns">
					<a href="index.html" class="button postfix">GO</a>
				</div>
			</div>
		</div>
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
		<div class="small-12 column small-centered">
			<div class="row collapse">
				<div class="small-10 columns">
					<input type="text" class="typeahead" placeholder="{{ $search_text }}" />
				</div>
				<div class="small-2 columns">
					<a href="index.html" class="button postfix">GO</a>
				</div>
			</div>
		</div>
	</div>
</div>