<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ItemAddonOptions extends BaseController
{
	use ResponseTrait;
	public function index()
	{
		//
	}
	public function delete($id)
	{
		$optionModel = new \App\Models\ItemAddonOption();
		$optionModel->delete($id);
		return $this->respond([
			'message' => 'success'
		]);
	}
}
