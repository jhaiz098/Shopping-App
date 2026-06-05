<?php

namespace App\Controllers;

use App\Models\UserModel;
use Config\Services;
use PSpell\Config;

class Auth extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function registerAuth()
    {
        $validation = Services::validation();

        $rules = [
            'first_name' => [
                'rules' => 'required',
                'errors' => [
                    'First Name is required.'
                ]
            ],

            'last_name' => [
                'rules' => 'required',
                'errors' => [
                    'Last Name is Required.'
                ]
            ],

            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Please enter a valid email address.',
                    'is_unique' => 'Email already exists.'
                ]
            ],

            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must be at least 8 characters.'
                ]
            ],

            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Confirm Password is required.',
                    'matches' => 'Passwords do not match.'
                ]
            ]
        ];

        if(!$this->validate($rules))
        {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash(
                    $this->request->getPost('password'),
                    PASSWORD_DEFAULT
                ),
            'role' => 'customer'
        ];

        $userModel->insert($data);

        return redirect()->to('login')
            ->with('success', 'Registration Successful.');

    }

    public function loginAuth()
    {
        $validation = Services::validation();

        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Please enter a valid email address.'
                ]
            ],

            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must be at least 8 characters.'
                ] 
            ]
        ];

        if(!$this->validate($rules))
        {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel
            ->where('email', $email)
            ->first();

        if(!$user)
        {
            return redirect()->back()
                ->with('errors', ['Email not found.']);
        }
        
        if(!password_verify($password, $user['password']))
        {
            return redirect()->back()
                ->with('errors', ['Invalid Password.']);
        }

        session()->set([
            'user_id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'isLoggedIn' => true,
        ]);

        if($user['role'] == 'admin')
        {
            return redirect()->to('/admin');
        }

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
