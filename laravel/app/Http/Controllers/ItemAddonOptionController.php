<?php

namespace App\Http\Controllers;

use App\Models\ItemAddonOption;
use Illuminate\Http\Request;

class ItemAddonOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemAddonOption  $itemAddonOption
     * @return \Illuminate\Http\Response
     */
    public function show(ItemAddonOption $itemAddonOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemAddonOption  $itemAddonOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemAddonOption $itemAddonOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemAddonOption  $itemAddonOption
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemAddonOption = \App\Models\ItemAddonOption::find($id);
        $itemAddonOption->delete();
        return response()->json([
            'message' => 'success',
            'olakka' => 'olakka'
        ]);
    }
}
