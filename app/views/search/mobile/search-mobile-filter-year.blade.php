<div id="mobileYearModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Year</h2>
	<ul class="tabs" data-tab>
		<li class="tab-title active"><a href="#basicYearMobile">Basic</a></li>
		<li class="tab-title"><a href="#customYearMobile">Custom</a></li>
	</ul>
	<form id="mobile-filter-by-year">		
		<div class="tabs-content">
			<div class="content active" id="basicYearMobile">
				<div class="row">
					<div class="small-12 columns border">
						<input type="checkbox" id="mobile-year-any" value="0" checked><label for="mobile-year-any">Any Year</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="row">
							<div class="small-12 columns">
								@foreach($aggregations['year'] as $year)
									<p><input type="checkbox" id="mobile-year-{{$year['key']}}" value="{{$year['key']}}"/><label for="mobile-year-{{$year['key']}}">{{ $year['title'] }}</label></p>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content" id="customYearMobile">
				<div class="row">
					<div class="small-7 medium-6 columns">
						<label><strong>From</strong></label>
						<input type="text" placeholder="No Minimum" class="yearMin"/>
					</div>
					<div class="small-7 medium-6 columns end">
						<label><strong>To</strong></label>
						<input type="text" placeholder="No Maximum" class="yearMax"/>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="small 12 columns">
				<button type="submit" class="radius">Update Results</button>
				<a class="close-reveal-modal cancel">Cancel</a>
			</div>
		</div>              
	</form>
	<a class="close-reveal-modal">&#215</a>
</div>