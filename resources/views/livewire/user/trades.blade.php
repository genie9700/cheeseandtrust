<?php

use Livewire\Volt\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $trades;

    public function with(): array
    {
        $trades = Transaction::where('user_id', Auth::id())->get();

        // dd($trades);
        return [
            'trades' => $trades,
        ];
    }
}; ?>

<div>
    <div class="p-4">
        <p class="text-white font-bold text-xl mb-10 p-2">Trades</p>
        <div class="bg-[#131824] h-72 rounded-lg text-gray-400">
            <p class="bg-[#19202F] font-bold  p-3 rounded-t-lg">Trades</p>
            @if ($trades)
                @foreach ($trades as $trade)
                    <div class="flex space-x-4 py-2 px-4 justify-center">
                        <div class="text-[17px] font-medium text-white">
                            <span class="text-white">${{ number_format($trade->amount) }}</span> has been
                            @if ($trade->transaction_type == 'Credit')
                                <span class="text-green-700">Credited</span>
                            @elseif($trade->transaction_type == 'Bonus')
                            <span class="text-blue-700">Bonused</span>
                            @else
                                <span class="text-red-700">Debited</span>
                            @endif
                            to your Account
                            @ {{ $trade->created_at }}
                        </div>
                    </div>
                </div> 
                @endforeach
            @else
                <div class="flex space-x-4 py-2 px-4 justify-center">
                        <p class="text-white font-bold mb-96">You havent placed any trades yet</p>
                    </div> 
            @endif
        </div>
    </div>
</div>
