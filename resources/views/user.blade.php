@extends('layouts.admin.master')
@section('content')
@php $privileges = (Session::has('priviliges')) ? (array)Session::get('priviliges') : array(); @endphp

	<div class="row">
		<div class="col-10">
			<div class="card">
				<div class="header">
					<span id="suspendMsg" class="error_msg"></span><br/>
					@if (in_array("add user", $privileges['user'])) 
						<h4 class="title">USER LIST <input type="button" value="ADD USER" class="btn btn-sm btn-dark addUserBtn f-right " action-type="add"/></h4>
					@endif
				</div>
				<div class="p-2">
					 <table class="table table-borderd text-center mb-0">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone Number</th>
								<th>Action</th>
								<th>Active/Deactive</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($user_list) && count($user_list) > 0)
								@php $i=1; @endphp
								@foreach($user_list as $user)
								<tr>
									<input type="hidden" value="{{ json_encode($user) }}" id="user_{{$user['id']}}"/>
									<td>{{$i}}</td>
									<td>{{ $user['name']}}</td>
									<td>{{ $user['email']}}</td>
									<td>@if(!empty($user['mobile_number'])){{ $user['mobile_number']}}@else{{ '_' }} @endif</td>
									<td>
										<span>
											@if (in_array("edit user", $privileges['user'])) 
												<i class="fas fa-pencil-alt editUserBtn c_pointer" action-type="edit" user-id="{{$user['id']}}" data-toggle="tooltip" title="EDIT" data-placement="left"></i>
											@endif
											@if (in_array("view user", $privileges['user'])) 
												<i class="fas fa-eye editUserBtn c_pointer" action-type="view" user-id="{{$user['id']}}"  data-toggle="tooltip" title="VIEW" data-placement="bottom"></i>
											@endif
											@if (in_array("delete user", $privileges['user'])) 
												<i class="fas fa-trash-alt deleteUser c_pointer" user-id="{{$user['id']}}"  data-toggle="tooltip" title="DELETE"  data-placement="right"></i>
											@endif
											
										</span>
									</td>
									<td>
										@if (in_array("edit user", $privileges['user'])) 
											<span data-toggle="tooltip" title="SUSPEND" data-placement="right">
												<label class="switch">
													<input type="checkbox" class="suspendUser" user-id="{{$user['id']}}" @if($user['status'] =='Y'){{'checked'}}@endif />
													<span class="slider round"></span>
												</label>
											</span>
										@endif
									</td>
								</tr>
								@php $i++; @endphp
								@endforeach
							@else
								<tr>
									<td colspan="6" class="text-left">
										<b>No data found....</b>
									</td>
								</tr>
							@endif
						</tbody>
					 </table>
				</div>
				<div class="footer"></div>
			</div>
		</div>
	</div>
	<!-- Add/Edit/View User Modal Popup -->
	<div id="ModalLoginForm" class="modal fade">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">ADD USER</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form role="form" method="POST" action="">
						<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="userid" id="userid" value="">
						<span class="error_msg" id="errorMsg"></span><br/>
						<div class="row">
							<div class="form-group col-6">
								<label class="control-label">Full Name</label>
								<div>
									<input type="text" class="form-control input-lg checkInputBlank" name="name" id="name" value="">
								</div>
							</div>
							<div class="form-group col-6">
								<label class="control-label">Mobile Number</label>
								<div>
									<input type="text" class="form-control input-lg checkInputBlank allowNumericOnly" name="phoneNo" id="phoneNo" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-8">
								<label class="control-label">Username / E-Mail Address</label>
								<div>
									<input type="email" class="form-control input-lg checkInputBlank" name="email" id="email" value="">
								</div>
							</div>
							<div class="form-group col-4">
								<label class="control-label">User Role</label>
								<div>
									<select class="form-control checkInputBlank" name="user_role" id="user_role">
										<option value="">SELECT ROLE</option>
										@if(isset($user_role_list) && count($user_role_list)>0)
											@foreach($user_role_list as $role)
												<option value="{{ $role['id'] }}">{{ $role['role_name'] }}</option>
											@endforeach
										@endif
									</select>
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
						<!--<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label class="control-label">Password</label>
									<div>
										<input type="password" class="form-control input-lg" name="password">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">Confirm Password</label>
									<div>
										<input type="password" class="form-control input-lg" name="password_confirmation">
									</div>
								</div>
							</div>
							<div class="col-6">
								<!--<div class="form-group">
									<label class="control-label">Gender</label>
									<div class="m-2 pb-1">
										<div class="custom-control custom-radio mb-3 d-inline">
											<input type="radio" class="custom-control-input" id="male" name="gender" value="male"  />
											<label class="custom-control-label" for="male">Male</label>
									
										</div>
										<div class="custom-control custom-radio mb-3  d-inline">
											<input type="radio" class="custom-control-input" id="female" name="gender" value="female" />
											<label class="custom-control-label" for="female">Female</label>
											
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">User Role</label>
									<div>
										<select class="form-control" name="user_role">
											<option value="admin">Admin</option>
										</select>
									</div>
								</div>
							</div>
						</div>-->
						<div class="form-group text-right">
							<div>
								<button type="button" class="btn btn-success saveBtnDiv" id="addNewUser"> Save </button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>	

	<!-- Delete User Confimation Modal popup -->
	<div id="confirmationModal" class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<h5>Are you Sure Do you want to delete this user ?</h5>
				 </div>   
					
				<div class="modal-footer">		
					<div class="form-group text-right">
						<div>
							<button type="button" class="btn btn-success " id="delete_user" rel="">Yes</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
						</div>
					</div>
					
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>	
	
	<!-- Delete User Message Modal popup -->
	<div id="SuccessMsgModal" class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<h5 class="text text-success" id="successMsg">SuccessFully Deleted</h5>
					 <h5 class="text text-danger" id="failedMsg">Failed</h5>
				 </div>   
					
				<div class="modal-footer">		
					<div class="form-group text-right">
						<div>
							<button type="button" class="btn btn-danger" onClick="window.location.reload();">Ok</button>
						</div>
					</div>
					
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>		
@endsection