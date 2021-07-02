<?php

namespace App\Controllers;

use App\Models\Users_model;

class Authenticate extends BaseController
{
	public function login()
	{
        $data['title'] = 'Login - POS';
		return view('auth/v_login', $data);
	}

    public function authenticate()
    {
        $model = new Users_model();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where(['username' => $username])->first();

        if($data)
        {
            if(password_verify($password, $data['password']))
            {
                session()->set([
                    "user_id" => $data['id'],
                    "username" => $data['username'],
                    "email" => $data['email'],
                    "logged_in" => TRUE
                ]);
                return redirect()->to('admin/dashboard');
            }else{
                session()->setFlashdata('error', 'Password salah!');
                return redirect()->back();
            }
        }else{
            session()->setFlashdata('error', 'Username & Password salah!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        $data['title'] = 'Register - POS';
        return view('auth/v_register', $data);
    }

    public function proses_register()
    {
        $rules = [
            'username'          => 'required|min_length[3]|is_unique[users.username]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'password'          => 'required|min_length[5]',
            'confirm_password'  => 'matches[password]'
        ];

        if($this->validate($rules))
        {
            $model = new Users_model();
            $data = [
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $model->save($data);
            return redirect()->to('/login');
        }else{
            $data['validation'] = $this->validator;
            $data['title'] = 'Register - POS';
            return view('auth/v_register', $data);
        }
    }
}
