<div class="contain-to-grid">
	<nav class="top-bar" data-topbar role="navigation">
		<ul class="title-area">
			<li class="name"><!-- leave this empty --></li>
			<li class="toggle-topbar"><a href="#" class="fa-icon"><span></span></a></li>
		</ul>
		<section class="top-bar-section">
			<!-- right nav section -->
			<ul class="right">
				@if(Auth::check())
					@if(Auth::user()->role == 1)
						<li>{{ HTML::linkRoute('get.admin.specifications', 'Specifications' ) }}</li>
						<li>{{ HTML::linkRoute('get.admin.upload', 'Upload' ) }}</li>
					@else
						<li>{{ HTML::linkRoute('get.user.saved-cars', 'Saved Cars' ) }}</li>
						<li>{{ HTML::linkRoute('get.user.saved-searches', 'Saved Searches' ) }}</li>
					@endif
                    <li>{{ HTML::linkRoute('get.user.profile', 'Profile') }}</li>
                    <li>{{ HTML::linkRoute('get.user.logout', 'Logout') }}</li>
                @else
                    <li>{{ HTML::linkRoute('get.user.login', 'Sign In') }}</li>
                    <li>{{ HTML::linkRoute('get.user.register', 'Register') }}</li>
                @endif
			</ul>
		</section>
	</nav>
</div>