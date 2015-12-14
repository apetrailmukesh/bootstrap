<div id="mileageModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Mileage</h2>
	<ul class="tabs" data-tab>
		<li class="tab-title active"><a href="#basicMileage">Basic</a></li>
		<li class="tab-title"><a href="#customMileage">Custom</a></li>
	</ul>
	<form id="filter-by-mileage">
		<div class="tabs-content">
			<div class="content active" id="basicMileage">
				<div class="row">
					<div class="small-12 columns border">
						<input type="radio" id="mileage-any" value="0" checked><label for="mileage-any">Any Mileage</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="row">
							<div class="small-6 columns">
								<p><input type="radio" id="mileage-1" value="1"/><label for="mileage-1">10,000 or less ({{ $aggregations['mileage'][1]}})</label></p>
								<p><input type="radio" id="mileage-2" value="2"/><label for="mileage-2">20,000 or less ({{ $aggregations['mileage'][2]}})</label></p>
								<p><input type="radio" id="mileage-3" value="3"/><label for="mileage-3">30,000 or less ({{ $aggregations['mileage'][3]}})</label></p>
							</div>
							<div class="small-6 columns">
								<p><input type="radio" id="mileage-4" value="4"/><label for="mileage-4">40,000 or less ({{ $aggregations['mileage'][4]}})</label></p>
								<p><input type="radio" id="mileage-5" value="5"/><label for="mileage-5">50,000 or less ({{ $aggregations['mileage'][5]}})</label></p>
								<p><input type="radio" id="mileage-6" value="6"/><label for="mileage-6">60,000 or less ({{ $aggregations['mileage'][6]}})</label></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content" id="customMileage">
				<div class="row">
					<div class="small-7 medium-6 columns">
						<label><strong>Min Mileage</strong></label>
						<input type="text" class="mileageMin"/>
					</div>
					<div class="small-7 medium-6 columns end">
						<label><strong>Max Mileage</strong></label>
						<input type="text" class="mileageMax"/>
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