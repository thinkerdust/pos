<?php

namespace App\Controllers;

class C_dashboard extends BaseController
{
	public function index()
	{
		return view('admin/v_dashboard');
	}
}
