<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
class Auth extends BaseController
{
    use ResponseTrait;
	public function login() 
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
            'password' => ['label' => 'Password', 'rules' => 'required']
        ]);
        if(!$validation->withRequest($this->request)
           ->run()) {
            $errors = $validation->getErrors();
            return $this->failValidationErrors($errors, 422);

        }
        // return $request->toArray();
        $userModel = new \App\Models\User();
        $user = $userModel->where('email',$this->request->getVar('email'))->first();
        // return $user;
        // return bcrypt($request->password);
        if(!$user) {
            return $this->respond([
                'message' => 'Incorrect Credentials1'
            ], 422);
        } else {
            if (password_verify($this->request->getVar('password'), $user['password'])) {
                
                $key = 'Laravel-97eats';
                $time = time();
                $payload = [
                    'user_id' => $user['id'],
                    'user_email' => $user['email'],
                    'init' => $time,
                    'expires_at' => $time + (2 * 365 * 24 * 60 * 60)
                ];
                $token = JWT::encode($payload, $key);
                $tokenModel = new \App\Models\UserToken();
                $tokenModel->save([
                    'token' => $token,
                    'user_id' => $user['id']
                ]);
                return $this->respond([
                    'message' => 'authenticated',
                    'token' => $token
                ],200);
            } else {
                return $this->respond([
                    'message' => 'Incorrect Credentials2'
                ],422);
            }
        }
    }

    public function register()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
            'password' => ['label' => 'Password', 'rules' => 'strong_password'],
            'password_confirmation' => ['label' => 'Password Confirmation', 'rules' => 'required|matches[password]'],
        ]);
        if(!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            return $this->failValidationErrors($errors, 422);
        }
        $user = new \App\Models\User();
        // return $user;
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
        ];

        $user->save($data);
        return $this->respond([
            'message' => 'success'
        ]); 
        
	}

    public function check_password_strength($password) {

    }
}
