@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="small-12 medium-7 large-7 columns small-centered">
		<div class="panel callout radius">
			<p class="tagline secondary-text">{{ $name }}</p>
			{{ Form::open(array('route' => 'post.admin.dealers.edit')) }}
				<div class="row">
				    {{ Form::hidden('id', $id) }}
					{{ Form::checkbox('paid', 'paid', $paid) }} Paid
					{{ Form::text('clicks', $clicks,  array('placeholder'=>'Clicks per Month')) }}
					<button type="submit" class="button postfix">UPDATE</button>
				</div>
			{{ Form::close() }}
		</div>
		@if($paid > 0)
		<div class="panel">
			<p class="tagline secondary-text">History</p>
			<table width="100%">
				<thead>
					<tr>
						<th width="25%" class="number-column">Year</th>
						<th width="25%" class="number-column">Month</th>
						<th width="25%" class="number-column">Paid Clicks</th>
						<th width="25%" class="number-column">Total Clicks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($dealer_history as $history)
						<tr>
							<td class="number-column">{{ $history->year }}</td>
							<td class="number-column">{{ $history->month }}</td>
							<td class="number-column">{{ $history->paid_clicks }}</td>
							<td class="number-column">{{ $history->total_clicks }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endif
	</div>
</section>
@stop