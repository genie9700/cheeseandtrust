<?php

use App\Models\Withdrawal;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $crypto_amount = '';
    public $bank_amount = '';
    public $paypal_amount = '';
    public $type = '';
    public $asset = '';
    public $address = '';
    public $bank_name = '';
    public $account_name = '';
    public $account_number = '';
    public $paypal_address = '';

    public function rules()
    {
        // $user = Auth::user();

        return[
            'crypto_amount' => ['required', 'integer'],
            'bank_amount' => ['required', 'integer'],
            'paypal_amount' => ['required', 'integer'],
            'type' => ['required'],
            'asset' => ['required'],
            'address' => ['required', 'string', 'max:255'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'integer', 'max:255'],
            'paypal_address' => ['required', 'string', 'max:255']
        ];
    }


    public function crypto()
    {
        $validated = $this->validate([
            'asset' => ['required'],
            'crypto_amount' => ['required', 'integer'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $type = 'Crypto';
        $validated['type'] = $type;

        $ref = bin2hex(random_bytes(6));

        $validated['ref'] = $ref;

        Auth::user()->withdrawals()->create([
            'type' => $validated['type'],
            'asset' => $validated['asset'],
            'amount' => $validated['crypto_amount'],
            'address' => $validated['address'],
            'ref' => $validated['ref'],
        ]);
        $this->reset();
        $this->dispatch('save-crypto', text: 'Withdrawal submitted'); 
    }

    public function bank()
    {
        $validated = $this->validate([
            'bank_amount' => ['required', 'integer'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
        ]);

        $type = 'Bank';
        $validated['type'] = $type;

        $ref = bin2hex(random_bytes(6));

        $validated['ref'] = $ref;

         Auth::user()->withdrawals()->create([
            'type' => $validated['type'],
            'bank_name' => $validated['bank_name'],
            'amount' => $validated['bank_amount'],
            'account_name' => $validated['account_name'],
            'account_number' => $validated['account_number'],
            'ref' => $validated['ref'],
        ]);
        $this->reset();
        $this->dispatch('save-bank', text: 'Withdrawal submitted'); 
    }

    public function paypal()
    {
        $validated = $this->validate([
            'paypal_amount' => ['required', 'integer'],
            'paypal_address' => ['required', 'string', 'max:255'],
        ]);

        $type = 'Paypal';
        $validated['type'] = $type;

        $ref = bin2hex(random_bytes(6));

        $validated['ref'] = $ref;

        Auth::user()->withdrawals()->create([
            'type' => $validated['type'],
            'paypal_address' => $validated['paypal_address'],
            'amount' => $validated['paypal_amount'],
            'ref' => $validated['ref'],
        ]);
        $this->reset();
        $this->dispatch('save-paypal', text: 'Withdrawal submitted'); 
    }

    public function with(): array
    {
        $withdrawals = Withdrawal::where('user_id', Auth::id())->get();

        return [
            'withdrawals' => $withdrawals,
        ];
    }
}; ?>

<div>
    <div class="p-4">
    <p class="text-white font-bold text-xl mb-10 p-2">Withdrawal</p>
    <div class="col-span-2 md:mt-0 mt-8">
        <div class="bg-[#131824] rounded-lg">
            <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Withdraw</p>
            <p class="text-white font-bold  text-center mb-5">
                To make a withdrawal, select your balance,
                amount and verify the address you wish for
                payment to be made into.
            </p>
                <div class="grid md:grid-cols-3 gap-3 pt-3 pb-6 p-3">
                    

                    <form wire:submit="crypto">
                        <div class="p-5 ">
                            <p class="text-white font-bold text-lg mb-5">Crypto</p>
                            <div id="crypto-fields">
                                <div class="mb-2">
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Asset</label>
                                    <select wire:model="asset" required
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800"
                                        name="" id="">
                                        <option value="">--select any--</option>
                                        <option value="BTC">BTC</option>
                                        <option value="ETH">ETH</option>
                                        <option value="DOGE">DOGE</option>
                                        <option value="BCH">BCH</option>
                                        <option value="MATIC">MATIC</option>
                                        <option value="USDT">USDT</option>
                                        <option value="LTC">LTC</option>
                                        <option value="AVAX">AVAX</option>
                                        <option value="SOL">SOL</option>
                                    </select>

                                </div>
                                <div class="mb-2">
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Amount</label>
                                    <input wire:model="crypto_amount" type="text"
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                    @error('crypto_amount') <span class="text-red-500 font-bold text-sm mt-1">{{ $message
                                        }}</span> @enderror
                                </div>
                                <div>
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Address</label>
                                    <input wire:model="address" type="text"
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                    @error('address') <span class="text-red-500 font-bold text-sm mt-1">{{ $message
                                        }}</span> @enderror
                                </div>

                                <button
                                    class="bg-blue-500 block text-white font-bold w-full  rounded-lg py-3 mt-8">Withdraw</button>
                            </div>
                        </div>
                    </form>

                    <form wire:submit="bank">
                        <div class="p-5">
                            <p class="text-white font-bold text-lg mb-5">Bank Transfer</p>
                            <div id="crypto-fields">
                                <div class="mb-2">
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Amount</label>
                                    <input wire:model="bank_amount" type="text"
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                    @error('bank_amount') <span class="text-red-500 font-bold text-sm mt-1">{{ $message
                                        }}</span> @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Bank Name</label>
                                    <input type="text" wire:model="bank_name" placeholder="chase bank"
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                        @error('bank_name') <span class="text-red-500 font-bold text-sm mt-1">{{ $message
                                        }}</span> @enderror
                                    </div>
                                <div class="mb-2">
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Account Name</label>
                                    <input type="text" wire:model="account_name" placeholder="john doe"
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                        @error('account_name') <span class="text-red-500 font-bold text-sm mt-1">{{ $message
                                        }}</span> @enderror
                                    </div>
                                <div class="mb-2">
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Account Number</label>
                                    <input type="text" wire:model="paypal_address" placeholder="23457690"
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                        @error('account_number') <span class="text-red-500 font-bold text-sm mt-1">{{ $message
                                        }}</span> @enderror
                                    </div>
                                <p class="text-gray-400 mt-4 border border-gray-800 rounded-lg p-2 text-xs">Your Account
                                    Manager may request further information.</p>

                                <button
                                    class="bg-blue-500 block text-white font-bold w-full  rounded-lg py-3 mt-8">Withdraw</button>
                            </div>
                        </div>
                    </form>

                    <form wire:submit="paypal">
                        <div class="p-5">
                            <p class="text-white font-bold text-lg mb-5">Paypal</p>
                            <div id="crypto-fields">
                                <div class="mb-2">
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Amount</label>
                                    <input wire:model="paypal_amount" type="text"
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                    @error('paypal_amount') <span class="text-red-500 font-bold text-sm mt-1">{{ $message
                                        }}</span> @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Paypal Address</label>
                                    <input type="text" wire:model="account_number" placeholder="johndoe@gmail.com"
                                        class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                        @error('paypal_address') <span class="text-red-500 font-bold text-sm mt-1">{{ $message
                                        }}</span> @enderror
                                    </div>
                    
                                <button
                                    class="bg-blue-500 block text-white font-bold w-full  rounded-lg py-3 mt-8">Withdraw</button>
                            </div>
                        </div>
                    </form>



                </div>
           

        </div>
    </div>
    {{-- withdraw history --}}
    <div class="mt-20">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left bg-[#131824]">
                <caption
                    class="p-5 text-lg font-semibold text-left bg-[#19202F] text-gray-400">
                    Withdrawals
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
                    @forelse ($withdrawals as $withdraw)
                        <tr class="text-gray-400">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">
                                {{ $withdraw->ref }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $withdraw->type }}
                            </td>
                            <td class="px-6 py-4">
                                $ {{ $withdraw->amount }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $withdraw->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($withdraw->status == 0)
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
       Livewire.on('save-crypto', (event) => {
        var delay = alertify.get('notifier','delay');
        alertify.set('notifier','position', 'top-right');

        alertify.set('notifier','delay', 2);
        alertify.success(event.text);
       });
    });
</script>
<script>
    document.addEventListener('livewire:init', () => {
       Livewire.on('save-bank', (event) => {
        var delay = alertify.get('notifier','delay');
        alertify.set('notifier','position', 'top-right');

        alertify.set('notifier','delay', 2);
        alertify.success(event.text);
       });
    });
</script>
<script>
    document.addEventListener('livewire:init', () => {
       Livewire.on('save-paypal', (event) => {
        var delay = alertify.get('notifier','delay');
        alertify.set('notifier','position', 'top-right');

        alertify.set('notifier','delay', 2);
        alertify.success(event.text);
       });
    });
</script>
    
@endsection

</div>
