<?php

use App\Models\Expert;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public function copy($value)
    {
        $user = Auth::user();

        $user->experts()->create([
            'trader' => $value
        ]);

        $this->dispatch('save-copy', text: 'Expert copied successfully'); 
    }
}; ?>

<div>
    <div class="p-4">
    <p class="text-white font-bold text-xl mb-10 p-2">Copy Expert Trades</p>
    <div class="grid md:grid-cols-3 gap-4">

        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/sandy.jpeg') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">Sandy Jadeja</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">97.8</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">14.5%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">481</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">18</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(1)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/skyital.png') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">Skyital Ltc</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">88.6%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">20%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">1,100</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">7</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(2)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/amadeus.jpg') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">Amadeus Crypto</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">85.6%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">15%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">229</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">20</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(3)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/andrew.jpeg') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">Andrew Aziz</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">88%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">16.8%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">281</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">39</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(4)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/alertia.png') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">Alertia Mars</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">100%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">22%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">28</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">0</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(5)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" height="120" class="rounded-full" src="{{ asset('experts/crypto.webp') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">Crypto Shark</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">100%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">15%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">101</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">0</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(6)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/dabull.jpeg') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">DaBullRunner</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">92%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">0%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">1963</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">163</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(7)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/mark.jpeg') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">Mark Moss</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">90.2%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">12%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">191</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">21</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(8)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/wd.jpg') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">W D Gann</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">99.8%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">25%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">103</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">1</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(9)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>
        <div class="bg-[#131824] max-w-sm rounded-lg p-3">
            <img width="120" class="rounded-full" src="{{ asset('experts/tofiq.jpeg') }}" alt="">
            <p class="text-white font-bold text-3xl my-6">Tofiq Fazlullah CIA</p>
            <div class="flex space-x-3 font-bold p-1 mb-20">
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WIN RATE</p>
                    <p class="text-white">92%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">PROFIT SHARE</p>
                    <p class="text-white">15%</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">WINS</p>
                    <p class="text-white">288</p>
                </div>
                <div class="border border-gray-800 rounded-lg px-4 py-2">
                    <p class="text-blue-600 text-xs">LOSSES</p>
                    <p class="text-white">36</p>
                </div>
                
            </div>
            <div class="mb-6">
                <button wire:click="copy(10)" class="py-2  text-white font-bold bg-blue-500 w-full rounded-lg">Copy</button>
            </div>
        </div>

    </div>
  
</div>

@section('scripts')
<script>
    document.addEventListener('livewire:init', () => {
       Livewire.on('save-copy', (event) => {
        var delay = alertify.get('notifier','delay');
        alertify.set('notifier','position', 'top-right');

        alertify.set('notifier','delay', 2);
        alertify.success(event.text);
       });
    });
</script>
    
@endsection


</div>
