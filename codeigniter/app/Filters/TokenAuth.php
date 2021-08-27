<?php

namespace App\Filters;

use CodeIgniter\CodeIgniter;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Response;
use Config\Services;

class TokenAuth implements FilterInterface
{
	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param RequestInterface $request
	 * @param array|null       $arguments
	 *
	 * @return mixed
	 */
	public function before(RequestInterface $request, $arguments = null)
	{
		/*
		$response = Services::response();
		$response->setStatusCode(423);
		$response->setBody($request->getServer('HTTP_AUTHORIZATION'));
		return $response;
		*/
		$header = $request->getServer('HTTP_AUTHORIZATION');
		$requestToken = substr($header,7);
		$key = 'Laravel-97eats';
		//$decoded = JWT::decode($token, $key, array('HS256'));
		$tokenModel = new \App\Models\UserToken();
		$token = $tokenModel->where('token',$requestToken)->first();
		if(!$token) {
			$response = Services::response();
			$response->setStatusCode(401);
			$response->setBody(json_encode([
				'message' => 'Unauthenticated'
			]));
			return $response;
		} 
	}

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null        $arguments
	 *
	 * @return mixed
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//
	}
}
