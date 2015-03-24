<div id="mobileMileageModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Mileage</h2>
	<ul class="tabs" data-tab>
		<li class="tab-title active"><a href="#basicMileageMobile">Basic</a></li>
		<li class="tab-title"><a href="#customMileageMobile">Custom</a></li>
	</ul>
	<form id="mobile-filter-by-mileage">		
		<div class="tabs-content">
			<div class="content active" id="basicMileageMobile">
				<div class="row">
					<div class="small-12 columns border">
						<input type="radio" id="mobile-mileage-any" value="0" checked><label for="mobile-mileage-any">Any Mileage</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="row">
							<div class="small-12 columns">
								<p><input type="radio" id="mobile-mileage-1" value="1"/><label for="mobile-mileage-1">10,000 or less ({{ $aggregations['mileage'][1]}})</label></p>
								<p><input type="radio" id="mobile-mileage-2" value="2"/><label for="mobile-mileage-2">20,000 or less ({{ $aggregations['mileage'][2]}})</label></p>
								<p><input type="radio" id="mobile-mileage-3" value="3"/><label for="mobile-mileage-3">30,000 or less ({{ $aggregations['mileage'][3]}})</label></p>
								<p><input type="radio" id="mobile-mileage-4" value="4"/><label for="mobile-mileage-4">40,000 or less ({{ $aggregations['mileage'][4]}})</label></p>
								<p><input type="radio" id="mobile-mileage-5" value="5"/><label for="mobile-mileage-5">50,000 or less ({{ $aggregations['mileage'][5]}})</label></p>
								<p><input type="radio" id="mobile-mileage-6" value="6"/><label for="mobile-mileage-6">60,000 or less ({{ $aggregations['mileage'][6]}})</label></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content" id="customMileageMobile">
				<div class="row">
					<div class="small-7 medium-6 columns">
						<label><strong>Min Mileage</strong></label>
						<input type="text" placeholder="No Minimum" class="mileageMin"/>
					</div>
					<div class="small-7 medium-6 columns end">
						<label><strong>Max Mileage</strong></label>
						<input type="text" placeholder="No Maximum" class="mileageMax"/>
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