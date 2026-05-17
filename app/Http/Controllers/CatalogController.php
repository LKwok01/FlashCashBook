<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PriceList;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $items = Item::with('activePrice')->orderBy('item_name')->get();

        return view('catalogm', ['items' => $items]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name'   => 'required|string|max:255|unique:items,item_name',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'price'       => 'required|numeric|min:0.01',
        ]);

        $item = Item::create([
            'item_name'   => $data['item_name'],
            'description' => $data['description'] ?? null,
            'is_active'   => $data['is_active'] ?? true,
        ]);

        PriceList::create([
            'item_id'    => $item->item_id,
            'price'      => $data['price'],
            'valid_from' => now(),
        ]);

        return redirect()->route('catalog')->with('success', 'Item added.');
    }

    public function toggleActive(Item $item)
    {
        $item->update(['is_active' => !$item->is_active]);

        return redirect()->route('catalog');
    }
}
