@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<ul class="tabs" data-tab>
			  	<li class="tab-title active"><a href="#paid">Paid Dealers</a></li>
			  	<li class="tab-title"><a href="#free">Free Dealers</a></li>
			</ul>
			<div class="tabs-content">
			  	<div class="content active" id="paid">
					<div class="row collapse">
						<div class="small-10 medium-11 large-11 columns">
							<table width="100%">
								<thead>
									<tr>
										<th width="60%">Name</th>
										<th width="15%">Total Clicks</th>
										<th width="15%">Current Clicks</th>
										<th width="10%">Edit</th>
									</tr>
								</thead>
								<tbody>
									@foreach($paid_dealers as $dealer)
										<tr>
											<td>{{ $dealer->dealer }}</td>
											<td>{{ $dealer->default_clicks }}</td>
											<td>{{ $dealer->current_clicks }}</td>
											<td>{{ HTML::linkRoute('get.admin.dealers.edit', 'Edit', array($dealer->id)) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>    	
			  	</div>
			  	<div class="content" id="free">
					<div class="row collapse">
						<div class="small-10 medium-11 large-11 columns">
							<table width="100%">
								<thead>
									<tr>
										<th width="60%">Name</th>
										<th width="15%">Total Clicks</th>
										<th width="15%">Current Clicks</th>
										<th width="10%">Edit</th>
									</tr>
								</thead>
								<tbody>
									@foreach($free_dealers as $dealer)
										<tr>
											<td>{{ $dealer->dealer }}</td>
											<td>{{ $dealer->default_clicks }}</td>
											<td>{{ $dealer->current_clicks }}</td>
											<td>{{ HTML::linkRoute('get.admin.dealers.edit', 'Edit', array($dealer->id)) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>    	
			  	</div>
			</div>
		</div>
	</div>
</section>
@stop