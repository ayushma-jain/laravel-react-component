<html>
    <head>
		@include('includes.admin.head')
    </head>
    <body>
		@if(Request::is('/'))
			<div class="content">
				@yield('content')
			</div>
	    @else
			
		@include('includes.admin.sidebar')
		<div class="main-panel">
			@include('includes.admin.header')

			<div class="content">
				@yield('content')
			</div>
			<input type="hidden" name="hf_base_url" id="hf_base_url" value="{{ url('/') }}">
		   @include('includes.admin.footer')
		</div>
		@endif
    </body>
</html>