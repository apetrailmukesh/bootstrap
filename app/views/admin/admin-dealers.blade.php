@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="panel callout radius">
				<p class="tagline secondary-text">Paid Dealers</p>
				<table width="100%">
					<thead>
						<tr>
							<th width="40%" class="number-column">Name</th>
							<th width="20%" class="number-column">Monthly Limit</th>
							<th width="20%" class="number-column">Paid Clicks</th>
							<th width="20%" class="number-column">Total Clicks</th>
						</tr>
					</thead>
					<tbody>
						@foreach($paid_dealers as $dealer)
							<tr>
								<td>{{ HTML::linkRoute('get.admin.dealers.edit', $dealer->dealer, array($dealer->id)) }}</td>
								<td class="number-column">{{ $dealer->monthly_clicks }}</td>
								<td class="number-column">{{ $dealer->current_clicks }}</td>
								<td class="number-column">{{ $dealer->paid_clicks }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="panel">
				<p class="tagline secondary-text">Free Dealers</p>
				<table width="100%">
					<thead>
						<tr>
							<th width="70%" class="number-column">Name</th>
							<th width="30%" class="number-column">Total Clicks</th>
						</tr>
					</thead>
					<tbody>
						@foreach($free_dealers as $dealer)
							<tr>
								<td>{{ HTML::linkRoute('get.admin.dealers.edit', $dealer->dealer, array($dealer->id)) }}</td>
								<td class="number-column">{{ $dealer->current_clicks }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@stop