<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Deposit;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use WithFileUploads;

    public $asset ='';
    public $amount ='';
    public $payment_slip;

    public function rules()
    {
        return 
        [
            'asset' => 'required|string',
            'amount' => 'required|integer',
            'payment_slip' => 'image|required|max:2024'
        ];
    }

    public function save()
    {
        $validated = $this->validate(); 

        if($this->payment_slip){
           $image =  $validated['payment_slip']->store('deposit', 'public');
        }

        $ref = bin2hex(random_bytes(6));

        // dd($ref); 

        
        $user = Auth::user();
        // dd($user);
        $user->deposits()->create([
            'ref' => $ref,
            'method' => $validated['asset'],
            'amount' => $validated['amount'],
            'status' => 0,
            'payment_slip' => $image,

        ]);

        $this->reset();
        $this->dispatch('save-deposit', text: 'Deposited Successfully'); 

    }

    public function with(): array
    {
        $deposits = Deposit::where('user_id', Auth::id())->get();

        return [
            'deposits' => $deposits,
        ];
    }

}; ?>

<div>
    <div class="p-4">
    {{-- deposit --}}
    <div class="mb-24">
        <p class="text-white font-bold text-xl mb-10">Deposit</p>

        <div class="md:grid md:grid-cols-3 md:gap-4">
            {{-- payment method --}}
            <div class="mb-6 md:mb-0">
                <div class="bg-[#131824] rounded-lg pb-3">
                    <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Choose Method</p>
                    <div class="p-2">
                        <div id="accordion-collapse" data-accordion="collapse"
                            data-active-classes="bg-[#161C2A] text-white">
                            <div class="bg-[#161C2A] rounded-xl mb-2">
                                <h2 id="accordion-collapse-heading-1">
                                    <button type="button"
                                        class="flex items-center space-x-2 w-full p-5 font-medium rtl:text-right text-gray-500
                                            rounded-t-xl focus:ring-gray-800"
                                        data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                                        aria-controls="accordion-collapse-body-1">
                                        <img width="30" height="10" class="rounded-full"
                                            src="data:image/jpeg;base64,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"
                                            alt="">
                                        <span class="font-bold text-lg">Bitcoin</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-1" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-1">
                                    <div class="p-5">
                                        <p class="font-bold text-lg text-white">Address</p>
                                        <input
                                            class="text-sm text-gray-400 font-bold border border-gray-800 rounded-lg 
                                            p-3 mt-2 w-full"
                                            id="textToCopy1" value="bc1qwmhmg8kjtyp9zxa97zfeyd0j8ud7upkq9mvze3">
                                        <p class="text-center text-white font-bold border border-gray-800 rounded-lg p-3 mt-2 cursor-pointer hover:bg-gray-800 
                                            hover:text-blue-500"
                                            id="copyButton1">Tap to copy address</p>
                                    </div>
                                </div>

                            </div>

                            <div class="bg-[#161C2A] rounded-xl mb-2">
                                <h2 id="accordion-collapse-heading-2">
                                    <button type="button"
                                        class="flex items-center space-x-2 w-full p-5 font-medium rtl:text-right text-gray-500
                                            rounded-t-xl focus:ring-gray-800"
                                        data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                                        aria-controls="accordion-collapse-body-2">
                                        <img width="30" height="10" class="rounded-full"
                                            src="data:image/png;base64,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"
                                            alt="ethereum icon">
                                        <span class="font-bold text-lg">Ethereum</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-2" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-2">
                                    <div class="p-5">
                                        <p class="font-bold text-lg text-white">Address</p>
                                        <input
                                            class="text-sm text-gray-400 font-bold border border-gray-800 rounded-lg 
                                            p-3 mt-2 w-full"
                                            id="textToCopy2" value="bc1qwmhmg8kjtyp9zxa97zfeyd0j8ud7upkq9mvze3">
                                        <p class="text-center text-white font-bold border border-gray-800 rounded-lg p-3 mt-2 cursor-pointer hover:bg-gray-800 
                                            hover:text-blue-500"
                                            id="copyButton2">Tap to copy address</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-[#161C2A] rounded-xl mb-2">
                                <h2 id="accordion-collapse-heading-3">
                                    <button type="button"
                                        class="flex items-center space-x-2 w-full p-5 font-medium rtl:text-right text-gray-500
                                            rounded-t-xl focus:ring-gray-800"
                                        data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                                        aria-controls="accordion-collapse-body-3">
                                        <img width="30" height="10" class="rounded-full"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR2teRvse5HKyzu4d2iEuiwp7I7ABmj2H6jKQ&s"
                                            alt="">
                                        <span class="font-bold text-lg">Dogecoin</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-3" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5">
                                        <p class="font-bold text-lg text-white">Address</p>
                                        <input
                                            class="text-sm text-gray-400 font-bold border border-gray-800 rounded-lg 
                                            p-3 mt-2 w-full"
                                            id="textToCopy3" value="bc1qwmhmg8kjtyp9zxa97zfeyd0j8ud7upkq9mvze3">
                                        <p class="text-center text-white font-bold border border-gray-800 rounded-lg p-3 mt-2 cursor-pointer hover:bg-gray-800 
                                            hover:text-blue-500"
                                            id="copyButton3">Tap to copy address</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-[#161C2A] rounded-xl mb-2">
                                <h2 id="accordion-collapse-heading-4">
                                    <button type="button"
                                        class="flex items-center space-x-2 w-full p-5 font-medium rtl:text-right text-gray-500
                                            rounded-t-xl focus:ring-gray-800"
                                        data-accordion-target="#accordion-collapse-body-4" aria-expanded="false"
                                        aria-controls="accordion-collapse-body-4">
                                        <img width="30" height="10" class="rounded-full"
                                            src="data:image/jpeg;base64,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"
                                            alt="">
                                        <span class="font-bold text-lg">Bitcoin Cash</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-4" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-4">
                                    <div class="p-5">
                                        <p class="font-bold text-lg text-white">Address</p>
                                        <input
                                            class="text-sm text-gray-400 font-bold border border-gray-800 rounded-lg 
                                            p-3 mt-2 w-full"
                                            id="textToCopy4" value="">
                                        <p class="text-center text-white font-bold border border-gray-800 rounded-lg p-3 mt-2 cursor-pointer hover:bg-gray-800 
                                            hover:text-blue-500"
                                            id="copyButton4">Tap to copy address</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- mode of payment --}}
            <div class="col-span-2">
                <div class="bg-[#131824] rounded-lg pb-3">
                    <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Submit Payment</p>
                    <center>
                        <form wire:submit="save">
                            <div class="max-w-80 text-justify py-6">
                                <p class="text-gray-300 font-bold text-sm mb-6">
                                    To deposit, choose the payment method panel and make the payment to the displayed
                                    address.
                                    After payment has been made, come back to fill this form.
                                </p>
                                <div>
                                    <div>
                                        <label for="coinSelect" class="text-gray-400 font-bold block mb-2">Asset</label>
                                        <select wire:model="asset" id="coinSelect" required
                                            class="w-full bg-[#1F273A] p-4 text-white rounded-lg border-gray-800 focus:ring-gray-800 focus:border-gray-800"
                                            onchange="showCoinImage()">
                                            <option value="">--Choose a coin--</option>
                                            <option value="BTC">BTC</option>
                                            <option value="ETH">ETH</option>
                                            <option value="DOGE">DOGE</option>
                                            <option value="BCH">BCH</option>
                                        </select>
    
                                        <div class="relative mt-6">
                                            <label for="coinSelect"
                                                class="text-gray-400 font-bold block mb-2">Amount</label>
                                            <input wire:model="amount" type="number"
                                                class="w-full align-middle block p-4 font-bold bg-[#131824] text-white rounded-lg border-gray-700 focus:ring-gray-800 focus:border-gray-800"
                                                id="coinInput" placeholder="1000">
                                                <div >
                                                    <img id="coinImage" width="30" height="10"
                                                        class="rounded-full absolute bottom-4 right-2" src=""
                                                        alt="Coin Image" style="display: none;"> 

                                                </div>
                                            @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror 
                                        </div>
    
                                        <div class="my-10">
                                            <label for="coinSelect" class="text-gray-400 font-bold block mb-2">Payment
                                                Proof</label>
                                            <input accept="image/png, image/jpeg, image/jpg" wire:model="payment_slip" type="file"
                                                class="w-full align-middle block p-4 font-bold bg-[#131824] text-white rounded-lg border-gray-700 focus:ring-gray-800 focus:border-gray-800"
                                                id="coinInput" placeholder="1000">
                                            @error('payment_slip') <span class="text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <button x-data="{ amount: @entangle('amount'), payment_slip: @entangle('payment_slip')}"
                                                :class="{'bg-gray-700 cursor-not-allowed text-white': !amount || !payment_slip, 'bg-blue-500 text-white': amount && payment_slip}"
                                                :disabled="!amount || !payment_slip"
                                            class="bg-blue-500 text-white font-bold w-full rounded-lg py-3">Deposit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </center>

                </div>
            </div>
        </div>
    </div>

    {{-- deposit history --}}
    <div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left bg-[#131824]">
                <caption
                    class="p-5 text-lg font-semibold text-left bg-[#19202F] text-gray-400">
                    Deposits
                </caption>
                <thead class="text-sm text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Ref
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Method
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Status</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deposits as $deposit)
                        <tr class="text-gray-400">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">
                                {{ $deposit->ref }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $deposit->method }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $deposit->amount }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $deposit->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($deposit->status == 0)
                                    <button 
                                        class="font-bold bg-blue-300 text-blue-600 py-3 px-6 rounded-lg">Pending</button>
                                @else
                                    <button 
                                        class="font-bold bg-green-300 text-green-600 py-3 px-6 rounded-lg">Approved</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <td class="text-center py-12 font-bold text-gray-400 text-md"  colspan="5">You have not made any subscriptions.</td>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('livewire:init', () => {
       Livewire.on('save-deposit', (event) => {
        var delay = alertify.get('notifier','delay');
        alertify.set('notifier','position', 'top-right');

        alertify.set('notifier','delay', 2);
        alertify.success(event.text);
       });
    });
</script>
    
@endsection

</div>
