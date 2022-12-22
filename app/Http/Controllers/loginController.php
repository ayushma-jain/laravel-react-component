<?php

namespace App\Http\Controllers;

use Hash; 
use Session;
use Request;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use App\Models\UserRole;


class loginController extends Controller
{
	public function __construct()
	{
		//Call this Middleware to Handle Back History Request
		$this->middleware('revalidate');
	}
	/**
	   * Function to Load Login View.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 23-September-2019
	   * @return view page
    */
	public function loginView()
	{
		if (!Session::has('user_id'))
		{
			return view('login');
		}
		else
		{
			return redirect('dashboard');	
		}	
	}
	/**
	   * Function to Load Admin Dashboard View.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 23-September-2019
	   * @return view page
    */
	public function dashboard()
	{
		return view('dashboard');
	}
	/**
	   * Function to Check User login User is valid OR not.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 24-September-2019
	   * @return view page
    */
    public function userCheck()
	{
		$user = new User;
		if( Request::isMethod('post') && Session::token() == Request::get('_token'))
		{
			$get_input = Request::all();
			
			$rules = [
					  'email'          => 'required',
					  'pwd'          => 'required'
			 ];
			 $messages = [
				'email.required'   =>  'email field is required',
				'pwd.required'   =>  'password field is required'
			 ];
			$validator = Validator:: make($get_input, $rules, $messages);
			if($validator->fails())
			{
				return redirect()-> back()
				->withInput(Request::except('pwd'))
				->withErrors( $validator );
			}
			else
			{
				
				$email      =      Request::get('email');
				$password   =      bcrypt(Request::get('pwd'));
				$data       =       $user->where(['email'=>$email,'status'=>'Y'])
									->join('role_list','role_list.id','=','users.role_id')
									->select('users.*','role_list.priviliges')->first();
				if(!empty($data) && isset($data->password) && isset($data->id))
				{
					if(Hash::check(Request::get('pwd'), $data->password))
					{
						if(Session::has('user_id'))
						{
							Session::forget('user_id');
							Session::forget('user_name');
							Session::forget('priviliges');
							Session::put('user_id', $data->id);
							Session::put('user_name', $data->name);
							Session::put('priviliges', json_decode($data->priviliges));
						}
						elseif(!Session::has('user_id')){
						   Session::put('user_id', $data->id); 
						   Session::put('user_name', $data->name); 
						   Session::put('priviliges', json_decode($data->priviliges)); 
						}
						 return redirect('dashboard');
					}else{
						Session::flash('error-message', 'Incorrect Password');
						return redirect()->back();
					}
				}else{
					Session::flash('error-message', 'Invalid User');
					return redirect()->back();
				}
			}
		}
	}
	/**
	   * Function to Load User page.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 24-September-2019
	   * @return view page
    */
	public function userList(){
		$data =array();
		$user_role = new UserRole;
		$user = new User;
		$data['user_role_list'] =  $user_role->where('id','!=',1)->get()->toArray();
		if(Session::has('user_id') && Session::get('user_id') == 1)
		{
			$data['user_list'] =  $user->where('role_id','!=',1)->get()->toArray();
		}else{
			$data['user_list'] =  $user->where('role_id','!=',1)->where('parent_user_id','=',Session::get('user_id'))->get()->toArray();
		}
		
		return view('user',$data);
	}
	/**
	   * Function to Load User Role page.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 24-September-2019
	   * @return view page
    */
	public function userRoleList(){
		$data =array();
		$user_role = new UserRole;
		if(Session::has('user_id') && Session::get('user_id') == 1){
			$data['user_role_list'] =  $user_role::all()->toArray();
			return view('user_roles',$data);
		}else{
			return redirect()->back();
		}
	}
	/**
	   * Function to Logout user.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 24-September-2019
	   * @return view page
    */
	 public function logoutFromLogin()
	{
		if(Session::has('user_id'))
		{
			Session::forget('user_id');
			Session::forget('user_name');
			Session::forget('priviliges');
		}
		return redirect('/'); 
	}
	/**
	   * Function to Edit Profile View page.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 25-September-2019
	   * @return view page
    */
	public function userProfile(){
		$data =array();
		$user_role = new UserRole;
		$user = new User;
		$data['user_data'] = $user->where(['users.id'=>Session::get('user_id')])
					->join('role_list','role_list.id','=','users.role_id')
					->select('users.*','role_list.priviliges','role_list.role_name')
					->first()->toArray();
		return view('profile',$data);
	}
}
