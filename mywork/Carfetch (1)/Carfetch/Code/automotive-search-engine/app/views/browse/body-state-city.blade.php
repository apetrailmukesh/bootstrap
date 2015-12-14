@section('contents')
<header>
	@include('header')
	@include('search/search-header')
</header>
<section role="main">
	<header>
		<div class="row">
			<div class="small-12 columns">
				<nav class="breadcrumbs" role="navigation">
					<a href="/" class="fa-icon home"></a>
					<a href="/browse/body">Body Styles</a>
					<a href="/browse/body/state/{{ $body->id }}">{{ $body->body}}</a>
					<a class="current">{{ $state['name']}}</a>
				</nav>
				<h1>{{ $body->body }} for sale in {{ $state['name']}}</h1>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="small-12 medium-4 columns block-list">
			@foreach($columns[0] as $column)
				<a href="{{ $column['link'] }}">{{ $column['title'] }}</a>
			@endforeach
		</div>
		<div class="small-12 medium-4 columns block-list">
			@foreach($columns[1] as $column)
				<a href="{{ $column['link'] }}">{{ $column['title'] }}</a>
			@endforeach
		</div>
		<div class="small-12 medium-4 columns block-list">
			@foreach($columns[2] as $column)
				<a href="{{ $column['link'] }}">{{ $column['title'] }}</a>
			@endforeach
		</div>
	</div>
</div>
</section>
@stop