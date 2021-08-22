<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Restaurant::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required'
        ]);
        $restaurant = new Restaurant;
        $restaurant->name = $request->name;
        $restaurant->category = $request->category;
        $restaurant->description = $request->description;
        $restaurant->location = $request->location;
        $restaurant->delivery_method = $request->delivery_method;
        $restaurant->delivery_charge = $request->delivery_charge;
        $restaurant->thumbnail_image = $request->thumbnail_image;
        $restaurant->cover_image = $request->cover_image;
        $restaurant->save();
        if($request->items) {
            foreach($request->items as $item) {
                $itemModel = new \App\Models\Item;
                $itemModel->name = $item['name'];
                $itemModel->category = $item['category'];
                $itemModel->price = $item['price'];
                $itemModel->description = $item['description'];
                $itemModel->thumbnail_image = $item['thumbnail_image'];
                $itemModel->cover_image = $item['cover_image'];
                $itemModel->restaurant_id = $restaurant->id;
                $itemModel->save();
                if ($item['addons']) {
                    foreach($item['addons'] as $addon) {
                        $addonModel = new \App\Models\ItemAddon;
                        $addonModel->name = $addon['name'];
                        $addonModel->item_id = $itemModel->id;
                        $addonModel->save();
                        foreach($addon['options'] as $option) {
                            $optionModel = new \App\Models\ItemAddonOption;
                            $optionModel->name = $option['name'];
                            $optionModel->price = $option['price'];
                            $addonModel->options()->save($optionModel);
                        }
                    }
                }
            }
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['items','items.addons','items.addons.options']);
        return $restaurant;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required'
        ]);
        $restaurant->name = $request->name;
        $restaurant->category = $request->category;
        $restaurant->description = $request->description;
        $restaurant->location = $request->location;
        $restaurant->delivery_method = $request->delivery_method;
        $restaurant->delivery_charge = $request->delivery_charge;
        $restaurant->thumbnail_image = $request->thumbnail_image;
        $restaurant->cover_image = $request->cover_image;
        $restaurant->save();
        if($request->items) {
            foreach($request->items as $item) {
                if (array_key_exists('id',$item)) {
                    $itemModel = \App\Models\Item::find($item['id']);
                    if(!$itemModel) {
                        $itemModel = new \App\Models\Item;
                    }
                } else {
                    $itemModel = new \App\Models\Item;
                }
                $itemModel->name = $item['name'];
                $itemModel->category = $item['category'];
                $itemModel->price = $item['price'];
                $itemModel->description = $item['description'];
                $itemModel->thumbnail_image = $item['thumbnail_image'];
                $itemModel->cover_image = $item['cover_image'];
                $itemModel->restaurant_id = $restaurant->id;
                $itemModel->save();
                if ($item['addons']) {
                    foreach($item['addons'] as $addon) {
                        if (array_key_exists('id',$addon)) {
                            $addonModel = \App\Models\ItemAddon::find($addon['id']);
                            if(!$addonModel) {
                                $addonModel = new \App\Models\ItemAddon;
                            }
                        } else {
                            $addonModel = new \App\Models\ItemAddon;
                        }
                        $addonModel->name = $addon['name'];
                        $addonModel->item_id = $itemModel->id;
                        $addonModel->save();
                        foreach($addon['options'] as $option) {
                            if (array_key_exists('id',$option)) {
                                $optionModel = \App\Models\ItemAddonOption::find($option['id']);
                                if(!$optionModel) {
                                    $optionModel = new \App\Models\ItemAddonOption;
                                }
                            } else {
                                $optionModel = new \App\Models\ItemAddonOption;
                            }
                            $optionModel->name = $option['name'];
                            $optionModel->price = $option['price'];
                            $optionModel->item_addon_id = $addonModel->id;
                            $optionModel->save();
                         }
                    }
                }
            }
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        if($restaurant->items->count() > 0) {
            foreach($restaurant->items as $item) {
                if($item->addons->count() > 0) {
                    foreach($item->addons as $addon) {
                        if($addon->options->count() > 0) {
                            foreach($addon->options as $option) {
                                $option->delete();
                            }
                        }
                        $addon->delete();
                    }
                }
                $item->delete();
            }
        }
        $restaurant->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
