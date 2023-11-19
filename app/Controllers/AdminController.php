<?php

namespace App\Controllers;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\AdminModel;
use App\Controllers\BaseController;


class AdminController extends ResourceController
{
    public function register()
    {
        $user = new AdminModel();
        $token = $this->verification(50);

        $data = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'token' => $token,
            'status' => 'active',
            'role' => 'user',
        ];

        $u = $user->save($data);

        if ($u) {
            return $this->respond(['msg' => 'okay', 'token' => $token]);
        } else {
            return $this->respond(['msg' => 'failed']);
        }
    }

    public function verification($length)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length);
    }

    public function login()
    {
        $username = $this->request->getVar("username");
        $password = $this->request->getVar("password");
        $admin = new AdminModel();
        $data = $admin->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            $authenticatedPassword = password_verify($password, $pass);

            if ($authenticatedPassword) {
                return $this->respond(['msg' => 'okay', 'token' => $data['token']], 200);
            } else {
                return $this->respond(['msg' => 'invalid password'], 200);
            }
        } else {
            return $this->respond(['msg' => 'no user found'], 200);
        }
    }

    public function index()
    {
        // Leave empty or add implementation if needed
    }
}
