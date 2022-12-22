@extends('layouts.frontend.master')
@section('content')
	<div class="mainDiv container" style=" display: flex;justify-content: center;align-items: center;margin-top:5%">
		<div class="loginDiv">
			<div class="row ">
				<div class="col-12 mb-2 mt-2 text-center">
					<!--<h1>Login</h1>-->
					<img class="circle rounded w-50" src="{{ URL::asset('images/GTPL LOGO.jpg') }}" />
				</div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="email">Username : </label>
					<input type="email" class="form-control" name="email" id="email">
				</div>
				<div class="form-group">
					<label for="pwd">Password :</label>
					<input type="password" class="form-control" name="pwd" id="pwd">
				</div>
				<div class="error_msg">
					@if($errors->has('email'))
						{{$errors->get('email')[0]}}
					@elseif($errors->has('pwd'))
						{{$errors->get('pwd')[0]}}
					@elseif(Session::has('error-message'))
						{{Session::get('error-message')}}
					@endif
				</div>
				<button type="submit" id="login" class="btn btn-dark w-100 mt-3">login<i class="fas fa-sign-in-alt ml-2"></i></button>
				<div class="form-group text-center">
					<label class="text text-dark mt-5 ">Don't have Account ? <a class="text text-orange" href="javascript:;"><b>Sign up</b></a></label>
				</div>
			</form>
		</div>
	</div>
@endsection