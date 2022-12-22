<div class="sidebar-wrapper">
	<aside>
		<div class="sidebar left">
			<div class="user-panel sidebar-header">
				<div class="simple-text logo-mini">
					<div class="logo-img"><img src="{{ URL::asset('images/GTPL LOGO.jpg') }}" class="w-100" alt="User Image"></div>
				</div>
				<div class="simple-text">
					Creative
				</div>
			</div>
			
            <ul class="list-sidebar">
				<li class="@if(Request::is('dashboard')){{'active'}}@endif"> 
					<a href="{{ url('dashboard') }}" class="@if(Request::is('dashboard')){{'active'}}@endif"> 
						<i class="fa fa-th-large"></i> <span class="nav-label"> Dashboards </span> 
					</a>
					
				</li>
				<!--<li > 
					<a href="#" class="">
						<i class="fa fa-laptop"></i> 
						<span class="nav-label">Grid options</span>
					</a> 
				</li>-->
			 
				@if(Session::has('user_id') && Session::get('user_id') == 1) 
				<li class="@if(Request::is('user_role')){{'active'}}@endif"> 
					<a href="{{ route('user_role') }}" class="@if(Request::is('user_role')){{'active'}}@endif" >
						<i class="fa fa-shopping-cart"></i> 
						<span class="nav-label">user roles</span>
					</a>
				</li>
				@endif 
				<li class="@if(Request::is('user')){{'active'}}@endif"> 
					<a href="{{ route('user') }}"  class="@if(Request::is('user')){{'active'}}@endif">
						<i class="fa fa-table"></i> 
						<span class="nav-label">Users</span>
					</a>
					
				</li>
				<!--<li> 
					<a href="#" data-toggle="collapse" data-target="#e-commerce" class="collapsed ">
						<i class="fa fa-shopping-cart"></i> 
						<span class="nav-label">E-commerce</span><span class="fa fa-chevron-left pull-right"></span>
					</a>
					<ul  class="sub-menu collapse" id="e-commerce" >
					  <li><a href=""> Products grid</a></li>
					  <li><a href=""> Products list</a></li>
					  <li><a href="">Product edit</a></li>
					  <li><a href=""> Product detail</a></li>
					  <li><a href="">Cart</a></li>
					  <li><a href=""> Orders</a></li>
					  <li><a href=""> Credit Card form</a> </li>
					</ul> 
				</li>-->
			</ul>
		</div>
	</aside>
</div>