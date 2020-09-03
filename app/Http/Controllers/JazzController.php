<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class JazzController extends Controller
{
	public function index(Request $request)
	{
		dd($request['Response']);
	}

}