<?php

use App\Models\Deposit;
use Livewire\Volt\Component;
use App\Models\Subscription;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    #[validate]
    public $amount = '';
    // public $errorMessage = '';
    public $current_balance = '';

    public function rules(){
        return[
            'amount' => ['numeric']
        ];
    }

        public function updatingAmount($value){
       

        $user_id = Auth::id();

        $credit = Deposit::where('user_id', $user_id)->where('status', 1)->pluck('amount')->sum();
        // $debit = Deposit::where('user_id', $user_id)->where('status', 0)->pluck('amount')->sum();

        $total_balance = $credit;

        if (!empty($this->amount)) {
            $this->current_balance = $total_balance;
        }else{
            $this->current_balance = '';
        }
               
        
    }

    public function save(){
        $validated = $this->validate();

        $user_id = Auth::id();

        $credit = Deposit::where('user_id', $user_id)->where('status', 1)->pluck('amount')->sum();
        // $debit = Deposit::where('user_id', $user_id)->where('status', 0)->pluck('amount')->sum();

        $total_balance = $credit;

        if ($this->amount !='') {
            $this->current_balance = $total_balance;
        }else{
            $this->current_balance = '';
        }

        if ($total_balance < $this->amount) {
            return session()->flash('errorMessage', 'Amount value cannot exceed current balance.');
        }

        if($validated['amount'] < 100){
            return session()->flash('errorMessage', 'The maximum for this plan is 100');
        }
        elseif($validated['amount'] > 19500){
            return session()->flash('errorMessage', 'The maximum for this plan is 19500');
        }

        $ref = bin2hex(random_bytes(6));

        $validated['ref'] = $ref;

        Auth::user()->subscriptions()->create($validated);
        $this->dispatch('save-subscription', text: 'Subscriped Successfully'); 
        $this->reset('amount');
    }

    public function with(): array
    {
        $subscriptions = Subscription::where('user_id', Auth::id())->get();
        return [
            'subscriptions' => $subscriptions,
        ];
    }

}; ?>

<div>
    <div class="p-4">
    <div class="mb-24">
        <p class="text-white font-bold text-xl mb-10">Subscribe</p>
        <p class="text-gray-400 font-bold text-md mb-10">Plans</p>

        <div class="md:grid md:grid-cols-3 md:gap-2 md:mb-0 mb-4">
            <div class="bg-[#131824] rounded-lg max-w-[22rem]">
                <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-5">Starter</p>
                <div class="p-5">
                    <p class="text-gray-400 font-bold text-md">Minimum</p>
                    <p class="text-white text-3xl font-bold">$10,000</p>
                    <div class="mt-8">
                        <p class="text-white font-bold">Details</p>
                        <div class="flex space-x-3 font-bold p-1">
                            <div class="border border-gray-800 rounded-lg px-4 py-2">
                                <p class="text-blue-600">Duration</p>
                                <p class="text-white">3 DAYS</p>
                            </div>
                            <div class="border border-gray-800 rounded-lg px-4 py-2">
                                <p class="text-blue-600">ROI</p>
                                <p class="text-white">200%</p>
                            </div>
                            <div class="border border-gray-800 rounded-lg px-4 py-2">
                                <p class="text-blue-600">MAXIMUM</p>
                                <p class="text-white">{{ number_format(19500, 2) }}</p>
                            </div>
                            
                        </div>
                        <form wire:submit="save" class="mt-8">
                            <div class="mb-12">
                                <label for="coinSelect" class="text-gray-400 font-bold block mb-2">Amount</label>
                                <input required  type="text" wire:model.live="amount" min="100" max="19500"
                                    class="w-full align-middle block p-3 font-bold bg-[#131824] text-white rounded-lg border-gray-700 focus:ring-gray-800 focus:border-gray-800"
                                    id="coinInput" placeholder="1000">
                                    @if($amount != '')
                                        <p class="text-white font-bold text-sm mt-1 mb-3">Current USD balance - {{ $current_balance }} USD</p>
                                    @endif
                                
                                @if (session('errorMessage'))
                                    <div class="text-red-500 font-bold text-sm mt-1">{{ session('errorMessage') }}</div>
                                @endif
                                @error('amount') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            

                            <button x-data="{ amount: @entangle('amount')}"
                                    :class="{'bg-gray-700 cursor-not-allowed text-white': !amount, 'bg-blue-500 text-white': amount }"
                                    :disabled="!amount"
                                class="bg-blue-500 block text-white font-bold w-full rounded-lg py-3">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- subscription history --}}
    <div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left bg-[#131824]">
                <caption
                    class="p-5 text-lg font-semibold text-left bg-[#19202F] text-gray-400">
                    Subscriptions
                </caption>
                <thead class="text-sm text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Ref
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
                    @forelse ($subscriptions as $sub)
                        <tr class="text-gray-400">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">
                                {{ $sub->ref }}
                            </th>
                            <td class="px-6 py-4">
                                {{ number_format($sub->amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $sub->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($sub->status == 0)
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
        Livewire.on('save-subscription', (event) => {
            var delay = alertify.get('notifier','delay');
            alertify.set('notifier','position', 'top-right');

            alertify.set('notifier','delay', 2);
            alertify.success(event.text);
        });
        });
    </script>  
@endsection


</div>
