<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
	'uses' => 'frontendController@index',
	'as'   => 'home'
]);

Route::get('/login', [
	'uses' => 'loginController@loginView',
	'as'   => 'login'
]);

Route::post('/login', [
	'uses' => 'loginController@userCheck'
]);

Route::group(['middleware' => 'adminMiddleware','revalidate'], function () {
	Route::get('dashboard', [
		'uses' => 'loginController@dashboard',
		'as'   => 'dashboard'
	]);
	Route::get('profile',[
	   'uses' => 'loginController@userProfile',
		'as'   => 'profile'
	]);

	Route::get('user',[
	   'uses' => 'loginController@userList',
		'as'   => 'user'
	]);
	Route::get('user_role',[
	   'uses' => 'loginController@userRoleList',
		'as'   => 'user_role'
	]);
});
//Ajax Controller.
Route::get('logout',[
   'uses' => 'loginController@logoutFromLogin',
	'as'   => 'logout'
]);
Route::post('ajax/saveRole',[
   'uses' => 'ajaxController@saveRole',
	'as'   => 'save-role'
]);

Route::post('ajax/saveUser',[
   'uses' => 'ajaxController@saveUser',
	'as'   => 'save-user'
]);
Route::post('ajax/deleteUser',[
   'uses' => 'ajaxController@deleteUser',
	'as'   => 'delete-user'
]);
Route::post('ajax/suspendUser',[
   'uses' => 'ajaxController@suspendUser',
	'as'   => 'suspend-user'
]);
Route::post('ajax/deleteRole',[
   'uses' => 'ajaxController@deleteUserRole',
	'as'   => 'delete-role'
]);
Route::post('ajax/checkRoleAssign',[
   'uses' => 'ajaxController@checkRoleAssign',
	'as'   => 'check-role-assign'
]);
