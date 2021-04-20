<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		$data['sidebar'] = 'dashboard';
		return view('admin/v_dashboard', $data);
	}
}
