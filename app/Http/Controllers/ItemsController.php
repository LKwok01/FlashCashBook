<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::orderby('item_name')->paginate(10);
        return view('items.list', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     * responsible of insertin new items to the catalogue
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name'=> 'required|string|max:255|unique:items,item_name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        Item::create($data);
        return redirect()->route('items.list') ->with('success'. 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Items $items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Items $items)
    {
        //
    }
}
