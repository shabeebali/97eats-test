<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Restaurants extends BaseController
{
	use ResponseTrait;
	public function index()
	{
		$model = new \App\Models\Restaurant();
		return $this->respond($model->findAll());
	}

	public function create()
	{
		$model = new \App\Models\Restaurant();
		$validation =  \Config\Services::validation();
        $validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'category' => ['label' => 'Category', 'rules' => 'required'],
			'delivery_method' => ['label' => 'Delivery Method', 'rules' => 'required'],
			'location' => ['label' => 'Location', 'rules' => 'required'],
        ]);
        if(!$validation->withRequest($this->request)
           ->run()) {
            $errors = $validation->getErrors();
            return $this->failValidationErrors($errors, 422);

        }
		$data = $this->request->getJSON(true);
		//return $this->respond($data);
		$restaurant = new \App\Entities\Restaurant();
		$restaurant->fill($data);
		// return $this->respond($restaurant->toArray());
		$modelID = $model->insert($restaurant);
		// return $this->respond($modelID);
		if($data['items']) {
			foreach($data['items'] as $item) {
				$itemModel = new \App\Models\Item();
				$itemEntity = new \App\Entities\Item();
				$itemEntity->fill($item);
				$itemEntity->restaurant_id = $modelID;
				$itemID = $itemModel->insert($itemEntity);
				if($item['addons']) {
					foreach($item['addons'] as $addon) {
						$addonModel = new \App\Models\ItemAddon();
						$addonEntity = new \App\Entities\ItemAddon();
						$addonEntity->fill($addon);
						$addonEntity->item_id = $itemID;
						$addonID = $addonModel->insert($addonEntity);
						foreach($addon['options'] as $option) {
							$optionModel = new \App\Models\ItemAddonOption();
							$optionEntity = new \App\Entities\ItemAddonOption();
							$optionEntity->fill($option);
							$optionEntity->item_addon_id = $addonID;
							$optionModel->insert($optionEntity);
						}
					}
				}
			}
		}
		return $this->respond([
			'message' => 'success'
		]);
	}

	public function show($id) {
		$model = new \App\Models\Restaurant();
		$restaurantEntity = $model->find($id);
		$itemModel = new \App\Models\Item();
		$addonModel = new \App\Models\ItemAddon();
		$optionModel = new \App\Models\ItemAddonOption();
		$items = $itemModel->where('restaurant_id',$restaurantEntity->id)->findAll();
		foreach($items as $itemIndex => $item) {
			$addons = $addonModel->where('item_id',$item->id)->findAll();
			$addonsArr = [];
			foreach($addons as $addonIndex => $addon) {
				$options = $optionModel->where('item_addon_id',$addon->id)->findAll();
				$temp = [
					'id' => $addon->id,
					'name' => $addon->name,
					'options' => $options
				];
				$addonsArr[] = $temp;
			}
			$items[$itemIndex]->addons = $addonsArr;
		}
		$restaurantEntity->items = $items;
		return $this->respond($restaurantEntity);
	}

	public function update($id)
	{
		// return $this->respond('olakka');
		$model = new \App\Models\Restaurant();
		$itemModel = new \App\Models\Item();
		$addonModel = new \App\Models\ItemAddon();
		$optionModel = new \App\Models\ItemAddonOption();
		$restaurant = $model->find($id);
		// return $this->respond($restaurant->toArray());
		$validation =  \Config\Services::validation();
        $validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'category' => ['label' => 'Category', 'rules' => 'required'],
			'delivery_method' => ['label' => 'Delivery Method', 'rules' => 'required'],
			'location' => ['label' => 'Location', 'rules' => 'required'],
        ]);
        if(!$validation->withRequest($this->request)
           ->run()) {
            $errors = $validation->getErrors();
            return $this->failValidationErrors($errors, 422);
        }
		$data = $this->request->getJSON(true);
		// return $this->respond($data);
		// $restaurant->fill($data);
		$restaurant->name = $data['name'];
		$restaurant->category = $data['category'];
		$restaurant->description = $data['description'];
		$restaurant->location = $data['location'];
		$restaurant->delivery_method = $data['delivery_method'];
		$restaurant->delivery_charge = $data['delivery_charge'];
		$restaurant->thumbnail_image = $data['thumbnail_image'];
		$restaurant->cover_image = $data['cover_image'];
		// return $this->respond($restaurant->toArray());
		$model->update($id,$restaurant);
		
		// return $this->respond($modelID);
		if($data['items']) {
			foreach($data['items'] as $item) {
				$newItem = false;
				if(array_key_exists('id',$item)){
					$itemEntity = $itemModel->find($item['id']);
					if(!$itemEntity) {
						$itemEntity = new \App\Entities\Item();
						$newItem = true;
					}
				} else {
					$newItem = true;
					$itemEntity = new \App\Entities\Item();
				}
				$itemEntity->name = $item['name'];
				$itemEntity->category = $item['category'];
				$itemEntity->description = $item['description'];
				$itemEntity->price = $item['price'];
				$itemEntity->thumbnail_image = $item['thumbnail_image'];
				$itemEntity->cover_image = $item['cover_image'];
				if($newItem) {
					$itemEntity->restaurant_id = $restaurant->id;
					$itemID = $itemModel->insert($itemEntity);
				} else {
					$itemID = $itemEntity->id;
					$itemModel->update($itemEntity->id,$itemEntity);
				}
				if($item['addons']) {
					foreach($item['addons'] as $addon) {
						$newAddon = false;
						if(array_key_exists('id',$addon)) {
							$addonEntity = $addonModel->find($addon['id']);
							if(!$addonEntity) {
								$addonEntity = new \App\Entities\ItemAddon();
								$newAddon = true;
							}
						} else {
							$addonEntity = new \App\Entities\ItemAddon();
							$newAddon = true;
						}
						$addonEntity->name = $addon['name'];
						if($newAddon){
							$addonEntity->item_id = $itemID;
							$addonID = $addonModel->insert($addonEntity);
						} else {
							$addonID = $addonEntity->id;
							$addonModel->save($itemEntity);
						}
						foreach($addon['options'] as $option) {
							$newOption = false;
							if(array_key_exists('id',$option)) {
								$optionEntity = $optionModel->find($option['id']);
								if(!$optionEntity){
									$optionEntity = new \App\Entities\ItemAddonOption();
									$newOption = true;
								}
							} else {
								$optionEntity = new \App\Entities\ItemAddonOption();
								$newOption = true;
							}
							$optionEntity->name = $option['name'];
							$optionEntity->price = $option['price'];
							if($newOption) {
								$optionEntity->item_addon_id = $addonID;
								$optionModel->insert($optionEntity);
							} else {
								$optionModel->save($optionEntity);
							}
						}
					}
				}
			}
		}
		return $this->respond([
			'message' => 'success'
		]);
	}

	public function delete($id)
	{
		$restaurantModel = new \App\Models\Restaurant();
		$itemModel = new \App\Models\Item();
		$addonModel = new \App\Models\ItemAddon();
		$optionModel = new \App\Models\ItemAddonOption();
		$items = $itemModel->where('restaurant_id',$id)->findAll();
		foreach($items as $item) {
			$addons = $addonModel->where('item_id',$item->id)->findAll();
			foreach($addons as $addon) {
				$options = $optionModel->where('item_addon_id',$addon->id)->findAll();
				foreach($options as $option) {
					$optionModel->delete($option->id);
				}
				$addonModel->delete($addon->id);
			}
			$itemModel->delete($item->id);
		}
		$restaurantModel->delete($id);
		return $this->respond([
			'message' => 'success'
		]);
	}
}
