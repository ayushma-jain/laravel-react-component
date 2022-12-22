$(document).ready(function(){
	
	// alphanumeric validation
	$(".allowNumericOnly").on("keypress keyup blur",function (event) {    
	   $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});
	//Bootstrap tooltip.
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
	
	
	/*  Add/Edit New User validation and Ajax call for Save/update Functionality */
	$('#addNewUser').on('click',function(){
		$('input,select').removeClass('required');
		$('#errorMsg').text('');
		var checkBlank = 1,id;
		var user_id = $('#userid').val();
		//reguler Expression for Password validation (AlphaNumeric).
		var strongRegex = new RegExp("^((?=.*[0-9])(?=.*[a-zA-Z])(?=\\S+$).{6,16})$");
		//Loop For Check Each Input Field value.
		$('.checkInputBlank').each(function(){
			id=$(this).attr('id');
			if($(this).val() == ''){
				if(user_id > 0 && id =='password'){
					
				}else{
					checkBlank = 0;
					$('#'+id).addClass('required');
				}
			}else{
				if(id == 'password')
				{
					var pwd = $('#password').val();
					var confirmpwd = $('#password_confirmation').val();
					if(strongRegex.test(pwd)){
						 if(confirmpwd ==''){
							 $('#password_confirmation').addClass('required');
								checkBlank = 0;
						 }else{
							 if(confirmpwd != pwd){
								 $('#errorMsg').text("password doesn't match");
								checkBlank = 0;
							 }
						 }
					}else{
						$('#errorMsg').text("Invalid password format(e.g pass12 etc).");
						checkBlank = 0;
					}
				}
				if(id == 'email'){
					var email = $('#email').val();
					//Reguler Expression for Email Check. 
					var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
					if(!pattern.test(email))
					{
						$('#errorMsg').text("Invalid email format");
						checkBlank = 0;
					}
				}
			}
		});
		if(checkBlank == 0){
				return false;
		}else{
				$.ajax({
				  url: $('#hf_base_url').val() + '/ajax/saveUser',
				  type: 'POST',
				  data: {'userid': user_id,'name':$('#name').val(),'phoneNo':$('#phoneNo').val(),'password':$('#password').val(),'email':$('#email').val(),'user_role':$('#user_role').val()},
				  cache: false,
				  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },  
				  success: function(data)
				  {
					 
					 if(data == 1){
						 window.location.href =  window.location.href;
					 }else{
						 
						 $('#errorMsg').text(data);
					 }
				  }
				});
			}
	});
	
	/*this Load Popup For Add ,Edit And View User */
	$('.addUserBtn,.editUserBtn').on('click',function(){
		$('form').get(0).reset();
		$('input,select').removeClass('required');
		$('#ModalLoginForm input,#ModalLoginForm select').attr('disabled',false);
		$('.passwordDiv,.saveBtnDiv').removeClass('d-none');
		$('#errorMsg').text('');
		var action = $(this).attr('action-type');
		if(action == 'edit' || action == 'view'){
			var user_id = $(this).attr('user-id');
			var data = jQuery.parseJSON($('#user_'+user_id).val());
			$('#userid').val(data.id);
			$('#name').val(data.name);
			$('#email').val(data.email);
			$('#phoneNo').val(data.mobile_number);
			$('#user_role').val(data.role_id);
			$('.passwordDiv').addClass('d-none');
			if(action == 'view'){
				$('.saveBtnDiv').addClass('d-none');
				$('#ModalLoginForm input,#ModalLoginForm select').attr('disabled',true);
			}
			$('#ModalLoginForm').modal('show');
		}else{
			$('#ModalLoginForm').modal('show');
		}
	});
	
	/*this is call on delete icon on User page and display confirmation Popup for Delete.*/
	$('.deleteUser').on('click',function(){
		var user_id = $(this).attr('user-id');
		$('#confirmationModal #delete_user').attr('rel',user_id);
		$('#confirmationModal').modal('show');
	});
	/*this function is call on the Confiramtion ok button click and perform delete user functionality.*/
	$('#delete_user').on('click',function(){
		var user_id = $(this).attr('rel');
		$.ajax({
			  url: $('#hf_base_url').val() + '/ajax/deleteUser',
			  type: 'POST',
			  data: {'userid': user_id},
			  cache: false,
			  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },  
			  success: function(data)
			  {
				 if(data == 1){
					 $('#confirmationModal').modal('hide');
					 $('#failedMsg').addClass('d-none');
					 $('#SuccessMsgModal').modal('show');
				 }else{
					 $('#confirmationModal').modal('hide');
					 $('#successMsg').addClass('d-none');
					 $('#SuccessMsgModal').modal('show');
				 }
				
			  }
		});
	});
	
	
	/*this is called on the Click of toggle Button from user page.*/
	$('.suspendUser').on('change',function(){
		var user_id = $(this).attr('user-id');
		var activeStatus = 'N';
		if($(this).is(":checked")){
			activeStatus ='Y';
		}
		$.ajax({
			  url: $('#hf_base_url').val() + '/ajax/suspendUser',
			  type: 'POST',
			  data: {'userid': user_id,'activeStatus' : activeStatus},
			  cache: false,
			  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },  
			  success: function(data)
			  {
				  if(data == 1){
					// window.location.href =window.location.href;
				  }else{
					  $('#suspendMsg').text('Something went wrong......')
				  }
			  }
		});
	});
	
	/*  Add/Edit New User Role validation and Ajax call for Save/update Functionality */
	$('#saveUserRoles').on('click',function(){
		var user_priviliges = {};
		var data;
		var checkBlank = 1,countPrivilige = 0;;
		var role_id = $('#role_id').val();
		var index;
		$('input').removeClass('required');
		$('#err_priv').text('');
		$("input[name='user_priv[]']:checked").each(function() {
			index = $(this).attr('data-parent');
			if(typeof user_priviliges[index] === 'undefined') {
				user_priviliges[index] = [];
			}
			user_priviliges[index].push($(this).val());
			countPrivilige++;
		});
		if((jQuery.inArray('add user', user_priviliges['user']) !== -1 || jQuery.inArray('edit user', user_priviliges['user']) !== -1) &&  jQuery.inArray('view user', user_priviliges['user']) === -1 )
		{
			user_priviliges['user'].push('view user');
		}
	
		user_priviliges = JSON.stringify(user_priviliges);
		if(countPrivilige == 0){
			$('#err_priv').text('Assign Priviliges');
			checkBlank = 0;
		}
		if($('#role_name').val() == ""){
			$('#role_name').addClass('required');
			checkBlank = 0;
		}
		if(checkBlank == 0){
			return false;
		}else{
			$.ajax({
			  url: $('#hf_base_url').val() + '/ajax/saveRole',
			  type: 'POST',
			  data: {'role_id':role_id,'role_name':$('#role_name').val(),'user_priviliges':user_priviliges},
			  cache: false,
			  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },  
			  success: function(data)
			  {
				 if(data == 1){
					 window.location.href =  window.location.href;
				 }else{
					 $('#error').text(data);
				 }
				
			  }
			});
		}
	});
	/*this Load Popup For Add ,Edit User Role Popup */
	$('.addUserRoleBtn,.editUserRoleBtn').on('click',function(){
		$('form').get(0).reset();
		$('input,select').removeClass('required');
		$('#addUserRoleModal input[type="text"]').attr('disabled',false);
		$('.passwordDiv').removeClass('d-none');
		$('#errorMsg').text('');
		var action = $(this).attr('action-type');
		if(action == 'edit'){
			var user_role_id = $(this).attr('user-role-id');
			var data = jQuery.parseJSON($('#userrole_'+user_role_id).val());
			//var user_privilege = jQuery.parseJSON($('#user_privilege_'+user_role_id).val());
			var user_privilege = JSON.parse(data.priviliges);
			$('#role_id').val(data.id);
			$('#role_name').val(data.role_name);
			$.each(user_privilege, function(key,value) {
				$('input[type=checkbox]').each(function(){
					
					if((key in user_privilege && $(this).val()==key) || jQuery.inArray($(this).val(), value) != -1){
						$(this).prop('checked',true);
					}
					
				}); 
			});
			$('#addUserRoleModal input[type="text"]').attr('disabled',true);
			$('#addUserRoleModal').modal('show');
		}else{
			$('#addUserRoleModal').modal('show');
		}
	});
	/*this is call on delete icon on User Role page and display confirmation Popup for Delete.*/
	$('.deleteUserRole').on('click',function(){
		var user_role_id = $(this).attr('user-role-id');
		console.log($('#hf_base_url').val() + '/ajax/checkRoleAssign');
		$.ajax({
			  url: $('#hf_base_url').val() + '/ajax/checkRoleAssign',
			  type: 'POST',
			  data: {'role_id': user_role_id},
			  cache: false,
			  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },  
			  success: function(data)
			  {
				 if(data == 1){
					 $('#confirmationRoleModal #delete_user_role').attr('rel',user_role_id);
					 $('#confirmationRoleModal').modal('show');
				 }else{
					$('#confirmationRoleModal').modal('hide');
					$('#failedMsg').text('This role is Already assigned to users So you can not deleted !!');
					$('#successMsg').text('');
					$('#SuccessRoleMsgModal').modal('show');
				 }
			  }
		});
		
	});
	/*this function is call on the Confiramtion ok button click and perform delete user role functionality.*/
	$('#delete_user_role').on('click',function(){
		var role_id = $(this).attr('rel');
		$.ajax({
			  url: $('#hf_base_url').val() + '/ajax/deleteRole',
			  type: 'POST',
			  data: {'role_id': role_id},
			  cache: false,
			  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },  
			  success: function(data)
			  {
				 if(data == 1){
					 $('#confirmationRoleModal').modal('hide');
					 $('#successMsg').text('SuccessFully Deleted');
					 $('#failedMsg').text('');
					 $('#SuccessRoleMsgModal').modal('show');
					 setTimeout(function(){ 
						window.location.href= window.location.href;
					 }, 2000);
					 
				 }else{
					 $('#confirmationRoleModal').modal('hide');
					 $('#successMsg').text('');
					 $('#failedMsg').text('Failed');
					 $('#SuccessRoleMsgModal').modal('show');
				 }
			  }
		});
	});
	
	/*trigger on the click of Pivileges select unselect Priviliges on all select chcekbox.*/
	$(document).on('click','.checkAll',function(){
		var type = $(this).attr('rel');
		$('.child_'+type).not(this).prop('checked', this.checked);
    });
	$(document).on('click','.child',function(){
		var type = $(this).attr('rel');
		var selectedStatus =0;
		$('.child_'+type).each(function(){
			if($(this).prop("checked") == false){
				selectedStatus = 1;
			}
		});
		if(selectedStatus == 1){
			$('.checkAll_'+type).prop('checked', false);
		}else{
			$('.checkAll_'+type).prop('checked', true);
		}
	});
	
	
});