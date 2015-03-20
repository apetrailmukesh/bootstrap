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
					<a href="/browse/make">Makes</a>
					<a class="current">{{ $make->make }}</a>
				</nav>
				<h1>{{ $make->make }}</h1>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns block-list">
			@foreach($columns[0] as $column)
				<a href="{{ $column['link'] }}">{{ $column['title'] }}</a>
			@endforeach
		</div>
		<div class="small-12 medium-3 columns block-list">
			@foreach($columns[1] as $column)
				<a href="{{ $column['link'] }}">{{ $column['title'] }}</a>
			@endforeach
		</div>
		<div class="small-12 medium-3 columns block-list">
			@foreach($columns[2] as $column)
				<a href="{{ $column['link'] }}">{{ $column['title'] }}</a>
			@endforeach
		</div>
		<div class="small-12 medium-3 columns block-list">
			@foreach($columns[3] as $column)
				<a href="{{ $column['link'] }}">{{ $column['title'] }}</a>
			@endforeach
		</div>
	</div>
</section>
@stop