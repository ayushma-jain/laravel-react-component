<header class="header">
	<nav class="navbar navbar-expand-lg navbar-bgcolor info-color">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
			aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		 </button>
		 <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
			<div class="navbar-header">
			   <h4 class="text text-secondary">Dashboard</h4>
			</div>
			<ul class="nav navbar-nav">
				<li class="active nav-item"><a class="nav-link" href="javascript:;">Home</a></li>
				<li class="nav-item"><a class="nav-link" href="javascript:;">Page 1</a></li>
				<li class="nav-item"><a class="nav-link" href="javascript:;">Page 2</a></li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user"></i> @if(Session::has('user_name')){{ Session::get('user_name')}} @else {{'Profile'}} @endif 
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
						<a class="dropdown-item" href="{{ url('profile') }}">Edit Profile</a>
						<a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</header>