<?php

use Livewire\Component;
use App\Models\Item;
use App\Models\PriceList;

new class extends Component
{
    public $items = [];
    public $item_name = '';
    public $description = '';
    public $price = '';
    public $is_active = true;

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = Item::with('activePrice')
            ->orderBy('item_name')
            ->get();
    }

    public function addItem()
    {
        $this->validate([
            'item_name'   => 'required|string|max:255|unique:items,item_name',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'price'       => 'required|numeric|min:0.1',
        ]);

        $item = Item::create([
            'item_name'   => $this->item_name,
            'description' => $this->description,
            'is_active'   => $this->is_active,
        ]);

        PriceList::create([
            'item_id'    => $item->item_id,
            'price'      => $this->price,
            'valid_from' => now(),
        ]);

        $this->reset(['item_name', 'description', 'price']);
        $this->is_active = true;
        $this->loadItems();
        $this->dispatch('close-form');
    }

    public function toggleActive($itemId)
    {
        $item = Item::where('item_id', $itemId)->first();
        $item?->update(['is_active' => !$item->is_active]);
        $this->loadItems();
    }
};

?>

<div>
    <h1 class="text-3xl font-bold text-gray-800 border-b border-gray-300 pb-1 mb-4">Catalog</h1>

    <div x-data="{ show: false }" @close-form.window="show = false" class="mb-6">
        <button @click="show = !show"
                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Item
        </button>

        <div x-show="show" x-transition class="mt-4 max-w-md bg-white border rounded-lg shadow p-4">
            <form wire:submit="addItem">
                <div class="mb-3">
                    <label for="item_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" wire:model="item_name" id="item_name" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('item_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" wire:model="description" id="description"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="mb-3">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                    <input type="number" wire:model="price" id="price" step="0.1" min="0.1" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" wire:model="is_active"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-400">
                        Active
                    </label>
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded text-sm">
                    Save Item
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($items as $item)
            <div class="bg-white border rounded-lg shadow p-4 flex flex-col">
                <h2 class="text-lg font-semibold text-gray-800">{{ $item->item_name }}</h2>

                <p class="text-sm text-gray-500 mt-1 flex-1">
                    {{ $item->description ?? 'No description' }}
                </p>

                <div class="mt-3 flex items-center justify-between">
                    <span class="text-xl font-bold text-gray-900">
                        {{ $item->activePrice?->price ? '$'.number_format($item->activePrice->price, 2) : 'N/A' }}
                    </span>

                    <span class="text-sm px-2 py-1 rounded font-medium
                        {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <button wire:click="toggleActive({{ $item->item_id }})"
                        class="mt-3 w-full text-sm py-1.5 rounded border font-medium
                        {{ $item->is_active
                            ? 'border-red-400 text-red-600 hover:bg-red-50'
                            : 'border-green-400 text-green-600 hover:bg-green-50' }}">
                    {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                </button>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center py-12">No items in catalog yet.</p>
        @endforelse
    </div>
</div>
