<?php

namespace App\Http\Controllers;

class frontendController extends Controller
{
	public function __construct()
	{
		//Call this Middleware to Handle Back History Request
		//$this->middleware('revalidate');
	}
	/**
	   * Function to Load Login View.
	   * Created By : Ayushma Jain < ayushma.jain@gaurish.com >
	   * Created On : 23-September-2019
	   * @return view page
    */
	public function index()
	{
		return view('pages.frontend.home');
	}
	
	
}
