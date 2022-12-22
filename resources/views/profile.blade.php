@extends('layouts.admin.master')
@section('content')
	<div class="row">
		<div class="col-7">
			<div class="card "> 
				<div class="card-header">
					<b>My Profile</b>
				</div>
				<div class="card-body">
					<form role="form" method="POST" action="">
						<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}"/>
						<input type="hidden" name="userid" id="userid" value="@if(isset($user_data['id'])){{$user_data['id']}} @endif"/>
						<input type="hidden"  name="user_role" id="user_role" value="{{ $user_data['role_id']}}"/>
						<span class="error_msg" id="errorMsg"></span><br/>
						<div class="row">
							<div class="form-group col-6">
								<label class="control-label">Full Name</label>
								<div>
									<input type="text" class="form-control input-lg checkInputBlank" name="name" id="name" value="@if(isset($user_data['name'])){{$user_data['name']}} @endif">
								</div>
							</div>
							<div class="form-group col-6">
								<label class="control-label">Mobile Number</label>
								<div>
									<input type="text" class="form-control input-lg checkInputBlank allowNumericOnly" name="phoneNo" id="phoneNo" value="@if(isset($user_data['mobile_number'])){{$user_data['mobile_number']}} @endif">
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="form-group col-12">
								<label class="control-label">Username / E-Mail Address</label>
								<div>
									<input type="email" class="form-control input-lg checkInputBlank" name="email" id="email" value="@if(isset($user_data['email'])){{$user_data['email']}} @endif">
								</div>
							</div>
						</div>
						<div class="row passwordDiv">
							<div class="form-group col-6">
								<label class="control-label">Password</label>
								<div>
									<input type="password" class="form-control input-lg checkInputBlank" name="password" id="password">
								</div>
							</div>
							<div class="form-group col-6">
								<label class="control-label">Confirm Password</label>
								<div>
									<input type="password" class="form-control input-lg" name="password_confirmation" id="password_confirmation">
								</div>
							</div>
						</div>
						<div class="form-group text-right">
							<div>
								<button type="button" class="btn btn-success " id="addNewUser"> Save </button>
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer">
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="card">
				<div class="card-header">
					<b>My Privileges</b>
				</div>
				<div class="card-body">
					<h5 class="pt-2"> <b > Role : @if(isset($user_data['role_name'])){{$user_data['role_name']}} @endif</b></h5>
					
						@if(isset($user_data['priviliges']))
							@php  $priviliges = json_decode($user_data['priviliges']); @endphp
						
							@if(isset($priviliges) && !empty($priviliges))
								@foreach($priviliges as $key=>$row)
									<h6 ><b style="text-transform: uppercase;">{{$key}} </b></h6>
									<ul>
										@foreach($row as $data)
										<li style="text-transform: uppercase;">{{$data}}</li>
										@endforeach
									</ul>
								@endforeach
							@endif
						@endif
					
				</div>
				<div class="card-footer">
				</div>
			</div>
		</div>
	</div>
@endsection