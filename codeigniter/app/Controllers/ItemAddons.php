<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ItemAddons extends BaseController
{
	use ResponseTrait;
	public function index()
	{
		
	}
	public function delete($id)
	{
		$addonModel = new \App\Models\ItemAddon();
		$optionModel = new \App\Models\ItemAddonOption();
		$options = $optionModel->where('item_addon_id',$id)->findAll();
		foreach($options as $option) {
			$optionModel->delete($option->id);
		}
		$addonModel->delete($id);
		return $this->respond([
			'message' => 'success'
		]);
	}
}
