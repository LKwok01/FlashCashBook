<x-layout>
    <main class="flex-1 m-1">
    <div class="">
    <p class="text-lg text-gray-700">we're the forgotten generation, we want an open conversation</p><br>
    </div>
    <div class="p-4" x-data="{ open: false }">
        <button class="bg-blue-500 text-white py-2 px-4 rounded" @click="open = !open">Toggle</button>
        <div x-show="open">
            <p>This is the content that will be toggled.</p>
        </div>

    </div>
    <livewire:test-component />
    </main>
</x-layout>
