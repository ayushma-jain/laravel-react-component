@extends('layouts.admin.master')
@section('content')
	<div class="row">
		<div class="col-7">
			<div class="card">
				<div class="header">
					<h4 class="title">USER ROLE LIST <input type="button" value="ADD USER ROLE" class="btn btn-sm btn-dark addUserRoleBtn f-right"  action-type="add"/></h4>
				</div>
				<div class="p-2">
					<table class="table table-borderd mb-0">
						<thead>
							<tr>
								<th>S.No</th>
								<th class="w-50">Role Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($user_role_list) && count($user_role_list)>0)
								@php $i=1; @endphp
								@foreach($user_role_list as $role)
									<tr>
										<input type="hidden" id="userrole_{{$role['id']}}" value="{{ json_encode($role) }}"/>
										<input type="hidden" id="user_privilege_{{$role['id']}}" value="{{$role['priviliges']}}"/>
										<td>{{ $i }}</td>
										<td>{{ $role['role_name'] }}</td>
										<td>
											@if($role['id'] != 1)
												<span>
													<i class="fas fa-pencil-alt editUserRoleBtn c_pointer" action-type="edit" user-role-id="{{$role['id']}}" data-toggle="tooltip" title="EDIT" data-placement="left"></i>
													<i class="fas fa-trash-alt deleteUserRole c_pointer" user-role-id="{{$role['id']}}" data-toggle="tooltip" title="DELETE" data-placement="right"></i>
												</span>
											@endif
										</td>
										
									  </tr>
								  @php $i++; @endphp
								@endforeach
							@endif
						</tbody>
					 </table>
				</div>
				<div class="footer">
				</div>
			</div>
		</div>
	</div>
	<!-- Add/Edit User Role Modal Popup -->
	<div id="addUserRoleModal" class="modal fade">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">USER ROLE</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form role="form" method="POST" action="">
						<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="role_id" id="role_id" value=>
						<span class="error_msg" id="error"></span><br/>
						<div class="form-group">
							<label class="control-label">Role Name</label>
							<div>
								<input type="text" class="form-control input-lg" name="role_name" id="role_name" value="">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Priviliges</label><span id="err_priv" class="error_msg"></span>
							<div class="row">
								<!--<div class="col-12">
									<div class="form-check user_privilige">
										<label class="form-check-label mt-2">
											<input class="form-check-input" type="checkbox" name="user_priv[]" value="add role"/> <b>User</b>
										</label>
									</div>
								</div>-->
								<div class="col-12">
									<div class="form-check user_privilige mr-5">
										<label class="form-check-label">
											<input class="form-check-input checkAll checkAll_user"  type="checkbox" rel="user" value="user"/> <b>User</b>
										</label>
									</div>
									<div class="form-check user_privilige">
										<label class="form-check-label">
											<input class="form-check-input child child_user" type="checkbox" name="user_priv[]"  rel="user"  value="add user" data-parent="user"/> ADD USER
										</label>
									</div>
									<div class="form-check user_privilige">
										<label class="form-check-label">
											<input class="form-check-input child child_user" type="checkbox" name="user_priv[]"  rel="user" value="edit user" data-parent="user"/> EDIT USER
										</label>
									</div>
									<div class="form-check user_privilige">
										<label class="form-check-label">
											<input class="form-check-input child child_user" type="checkbox" name="user_priv[]" rel="user"  value="view user" data-parent="user"/> View USER
										</label>
									</div>
									<div class="form-check user_privilige">
										<label class="form-check-label">
											<input class="form-check-input child child_user" type="checkbox" name="user_priv[]"  rel="user" value="delete user" data-parent="user"/> DELETE USER
										</label>
									</div>
								</div>
							</div>
							<div class="row mt-4">
								<div class="col-12">
									<div class="form-check user_privilige mr-5">
										<label class="form-check-label">
											<input class="form-check-input checkAll checkAll_user_role" type="checkbox" rel="user_role "value="user role"/> <b>User Role</b>
										</label>
									</div>
									<div class="form-check user_privilige">
										<label class="form-check-label">
											<input class="form-check-input child child_user_role" type="checkbox" name="user_priv[]"  rel="user_role" value="add role" data-parent="user role"/> ADD ROLE
										</label>
									</div>
									<div class="form-check user_privilige">
										<label class="form-check-label">
											<input class="form-check-input child child_user_role" type="checkbox" name="user_priv[]" rel="user_role" value="edit role" data-parent="user role"/> EDIT ROLE
										</label>
									</div>
									<div class="form-check user_privilige">
										<label class="form-check-label">
											<input class="form-check-input child child_user_role" type="checkbox" name="user_priv[]" rel="user_role" value="view role" data-parent="user role"/> VIEW ROLE
										</label>
									</div>
									<div class="form-check user_privilige">
										<label class="form-check-label">
											<input class="form-check-input child child_user_role" type="checkbox" name="user_priv[]" rel="user_role" value="delete role" data-parent="user role"/> DELETE ROLE
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group text-right">
							<div>
								<button type="button" class="btn btn-success" id="saveUserRoles"> Save </button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>	

	<!-- Delete User Role Confimation Modal popup -->
	<div id="confirmationRoleModal" class="modal fade">
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
							<button type="button" class="btn btn-success " id="delete_user_role" rel="">Yes</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
						</div>
					</div>
					
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>	
	
	<!-- Delete User Role Message Modal popup -->
	<div id="SuccessRoleMsgModal" class="modal fade">
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
							<button type="button" class="btn btn-danger okBtn" data-dismiss="modal">Ok</button>
						</div>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	
@endsection