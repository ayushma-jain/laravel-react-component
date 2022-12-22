<html>
    <head>
		@include('includes.frontend.head')
    </head>
    <body id="page-top">
		
		<div >
			@include('includes.frontend.header')

			<div class="content">
				@yield('content')
			</div>
			<input type="hidden" name="hf_base_url" id="hf_base_url" value="{{ url('/') }}">
		   @include('includes.frontend.footer')
		</div>
		
    </body>
</html>