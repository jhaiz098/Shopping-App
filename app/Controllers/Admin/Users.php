<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class Users extends BaseController
{
    public function add_user()
    {
        $validation = Services::validation();

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name'  => 'required|min_length[2]|max_length[50]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'password'   => 'required|min_length[6]',
            'role'       => 'required|in_list[admin,customer]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $userModel->insert([
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'       => $this->request->getPost('role'),
        ]);

        return redirect()->to('admin/users')
            ->with('success', 'User created successfully.');
    }

    public function update_user($id)
    {
        $validation = Services::validation();

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name'  => 'required|min_length[2]|max_length[50]',
            'email'      => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'       => 'required|in_list[admin,customer]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $userModel->update($id, [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'role'       => $this->request->getPost('role'),
        ]);

        return redirect()->to('admin/users')
            ->with('success', 'User updated successfully.');
    }

    public function delete_user($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('admin/users')
                ->with('errors', ['User not found.']);
        }

        $userModel->delete($id);

        return redirect()->to('admin/users')
            ->with('success', 'User deleted successfully.');
    }
}