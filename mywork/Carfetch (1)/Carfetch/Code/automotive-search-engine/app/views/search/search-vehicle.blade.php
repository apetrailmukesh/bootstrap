<article class="vehicle">
	<div class="row">
		<div class="small-12 columns">
			<h2><a href="/vehicle/?vin={{ $result['vin'] }}">{{ $result['year'] }} {{ $result['make'] }} {{ $result['model'] }} {{ $result['trim'] }}</a></h2>
			<p class="small secondary-text">{{ $result['url'] }}</p>
		</div>
	</div>
	<div class="row" data-equalizer>
		<div class="small-5 medium-3 large-3 columns" data-equalizer-watch>
			<a href="/vehicle/?vin={{ $result['vin'] }}">
				<img src="{{ $result['image'] }}" title="{{ $result['year'] }} {{ $result['make'] }} {{ $result['model'] }}">
				<p>
					<a class="fa-icon save" data-reveal-id="{{ $save_vehicle_popup }}" id="save-vehicle-{{$result['vin']}}">Save</a>
				</p>
			</a>
		</div>
		<div class="small-7 medium-9 large-9 columns" data-equalizer-watch>
			<p><span class="price"><strong>{{ $result['price'] }}</strong></span>{{ $result['mileage'] }}</p>
			<p>{{ $result['trim'] }} {{ $result['transmission'] }} {{ $result['body'] }} {{ $result['feature'] }} {{ $result['drive'] }}</p>
			<p><strong>{{ $result['dealer'] }}</strong> <span class="secondary-text">{{ $result['dealer_address'] }}</span></p>
		</div>
	</div>
</article>