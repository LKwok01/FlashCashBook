<?php

use Livewire\Component;

new class extends Component
{
    public $count = 0;
    public function increment(){
        $this->count++;
    }
};
?>

<div>
    {{-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius --}}
    <p>You have clicked the button {{ $count }} times.</p>
    <button wire:click="increment" class="bg-blue-500 text-white py-2 px-4 rounded">Click Me</button>
</div>