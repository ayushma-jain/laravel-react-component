<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request; 
use App\Models\UserRole;
use App\Models\User;
use Session;
use Hash;
use DB;

class ajaxController extends Controller
{
	/**
	   * Function to Save and Edit User data.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 24-September-2019
    */
	public function saveUser()
	{
		$input = Input::all();
		$userid = (isset($input['userid']) && !empty($input['userid']))? $input['userid'] : '';
		$User = new User;
		$User->name = $input['name'];
		$User->email = $input['email'];
		$User->mobile_number = $input['phoneNo'];
		$User->role_id = $input['user_role'];
		$User->status = 'Y';
		$User->parent_user_id = Session::get('user_id');
		$User->updated_at = NOW();
		$CheckAlreadyExist = '';
		if(!empty($userid)){
			$CheckAlreadyExist = $User->where(['id'=>$userid])->pluck('name')->first();
		}
		if(!empty($CheckAlreadyExist)){
			$updateValueArray = ['name'=>$input['name'],'email' => $input['email'],'mobile_number' => $input['phoneNo'],'role_id' => $input['user_role'],'updated_at' => NOW()];
			
			if(!empty($input['password'])){
				$updateValueArray['password'] = Hash::make($input['password']);
			}
			$updateQuery =DB::table('users')->where('id', $userid)->update($updateValueArray);
			if($updateQuery){
				echo 1;
			}else{
				echo 'Something went Wrong.....';
			}
		}else{
			$User->password = Hash::make($input['password']);
			$User->created_at = NOW();
			$CheckAlreadyExist = $User->where(['email'=>$input['email']])->pluck('name')->first();
			
			if(empty($CheckAlreadyExist)){
				if($User->save())
				{
					echo 1;
				}
				else
				{
					echo 'Something went Wrong.....';
				}
			}else{
				echo 'This email is already in use.';
			}
		}
	}
	
	/**
	   * Function to Delete User data.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 25-September-2019
    */
	
	public function deleteUser(){
		$input = Input::all();
		$userid = (isset($input['userid']) && !empty($input['userid']))? $input['userid'] : '';
		$user = new User;
		$deleteQuery = $user->where('id',$userid)->delete();
		if($deleteQuery){
			echo 1;
		}else{
			echo 0;
		}
	}
	/**
	   * Function to Active/Deactive user Status .
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 24-September-2019
    */
	public function suspendUser(){
		$input = Input::all();
		DB::enableQueryLog();
		$userid = (isset($input['userid']) && !empty($input['userid']))? $input['userid'] : '';
		$activeStatus =  $input['activeStatus'] ;
		$user = new User;
		$updateQuery = $user->where('id',$userid)->update(['status'=>$activeStatus]);
		if($updateQuery){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	/**
	   * Function to Save and Edit User Role data.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 25-September-2019
    */
    public function saveRole(){
		$input = Input::all();
		//echo '<pre>'; print_r($input['user_priviliges']);exit;
		$role_name = $input['role_name'];
		//echo '<pre>'; print_r(json_encode(json_decode($input['user_priviliges'])));exit;
		$role_id = $input['role_id'];
		$user_priviliges = $input['user_priviliges'];
		$user_role = new UserRole;
		$user_role->role_name = $role_name;
		$user_role->priviliges = $user_priviliges;
		$user_role->created_at = NOW();
		$user_role->updated_at = NOW();
		$CheckAlreadyExist = '';
		if(!empty($role_id)){
			$CheckAlreadyExist = $user_role->where(['id'=>$role_id])->pluck('role_name')->first();
		}
		if(!empty($CheckAlreadyExist)){
			$updateQuery =$user_role->where('id', $role_id)->update(['priviliges'=>$user_priviliges]);
			if($updateQuery){
				echo 1;
			}else{
				echo 'Something went Wrong.....';
			}
		}else{
			if($user_role->save()){
				echo 1;
			}else{
				echo 'Something went Wrong.....';
			}
		}
	}
	/**
	   * Function to Delete User Role data.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 25-September-2019
    */
	public function deleteUserRole(){
		$input = Input::all();
		$role_id = (isset($input['role_id']) && !empty($input['role_id']))? $input['role_id'] : '';
		$user_role = new UserRole;
		$deleteQuery = $user_role->where('id',$role_id)->delete();
		if($deleteQuery){
			echo 1;
		}else{
			echo 0;
		}
	}
	/**
	   * Function to Chech this Role is Assigned Any user Or not.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 25-September-2019
    */
	public function checkRoleAssign(){
		$input = Input::all();
		$role_id = (isset($input['role_id']) && !empty($input['role_id']))? $input['role_id'] : '';
		$user = new User;
		$checkAlreadyAssign = $user->where('role_id',$role_id)->pluck('name')->first();
		print_r($checkAlreadyAssign);
		if(!empty($checkAlreadyAssign)){
			echo 0;
		}else{
			echo 1;
		}
	}

}
