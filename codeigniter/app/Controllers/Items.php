<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Items extends BaseController
{
	use ResponseTrait;
	public function index()
	{
		//
	}

	public function delete($id)
	{
		$itemModel = new \App\Models\Item();
		$addonModel = new \App\Models\ItemAddon();
		$optionModel = new \App\Models\ItemAddonOption();
		$addons = $addonModel->where('item_id',$id)->findAll();
		foreach($addons as $addon) {
			$options = $optionModel->where('item_addon_id',$addon->id)->findAll();
			foreach($options as $option) {
				$optionModel->delete($option->id);
			}
			$addonModel->delete($addon->id);
		}
		$itemModel->delete($id);
		return $this->respond([
			'message' => 'success'
		]);
	}
}
