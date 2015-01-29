<article class="vehicle">
	<div class="row">
		<div class="small-12 columns">
			<h2><a href="#">{{ $result['year'] }} {{ $result['make'] }} {{ $result['model'] }}</a></h2>
			<p class="small secondary-text">{{ $result['url'] }}</p>
		</div>
	</div>
	<div class="row" data-equalizer>
		<div class="small-5 medium-3 large-3 columns" data-equalizer-watch>
			<img src="images/vehicle-01.png" title="{YYYY} {Make} {Model} {Trim}">
			<p>
				<a href="#" class="fa-icon save">Save</a>
				<a href="#" class="fa-icon share">Share</a>
			</p>
		</div>
		<div class="small-7 medium-9 large-9 columns" data-equalizer-watch>
			<p><span class="price"><strong>{{ $result['price'] }}</strong></span>{{ $result['miles'] }}</p>
			<p>{Color}, {# of doors}, {Drivetrain}, {Body Style}, {Transmission}, {Engine}, {Stock # 00000000}</p>
			<p class="detailed-description secondary-text hide-for-small">{{ $result['description'] }}<a href="#"> Read More</a></p>
			<p><strong>{{ $result['dealer'] }}</strong> <span class="secondary-text">in {City Name}, {ST} ~ {00} mi. away</span></p>
		</div>
	</div>
</article>