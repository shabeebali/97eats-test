<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class Home extends BaseController
{
	use ResponseTrait;
	public function index()
	{
		return view('welcome_message');
	}

	public function user()
	{
		$header = $this->request->getServer('HTTP_AUTHORIZATION');
		$requestToken = substr($header,7);
		$key = 'Laravel-97eats';
		// return $this->respond($requestToken);
		$decoded = JWT::decode($requestToken,$key,array('HS256'));
		return $this->respond((array) $decoded);
	}
}
