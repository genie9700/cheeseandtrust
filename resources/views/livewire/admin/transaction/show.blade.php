<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;

new #[Layout('components.admin')] class extends Component {
    #[Locked]
    public User $user;

    #[Rule('required | integer')]
    public $amount = '';

    public $bonus_amount = '';

    #[Rule('required | string')]
    public $transaction_type = '';

    #[Rule('required | string')]
    public $message = '';


    public function mount(User $user)
    {
        $this->user = $user;

    }

    public function profit()
    {
        $validated = $this->validate();
        $user = User::findOrFail($this->user->id);

        $credit = Transaction::where('user_id', $this->user->id)
                            ->where('transaction_type', 'Credit')
                            ->pluck('amount')
                            ->sum();

        $debit = Transaction::where('user_id', $this->user->id)
                            ->where('transaction_type', 'Debit')
                            ->pluck('amount')
                            ->sum();

        $totalBalance = $credit - $debit;

        $this->reset('amount','message');

        if ($validated['transaction_type'] == 'Credit') {

           $user->transactions()->create([
            'amount' => $validated['amount'],
            'transaction_type' => $validated['transaction_type'],
            'message' => $validated['message'],
           ]);

           session()->flash('status', 'Plan successfully Credited.');
            $this->reset('amount','message');
        }
        else{
            if ($validated['amount'] > $totalBalance ) {
                return session()->flash('low-status', 'Insufficient Funds.');

            }
                $user->transactions()->create([
                    'amount' => $validated['amount'],
                    'transaction_type' => $validated['transaction_type'],
                    'message' => $validated['message'],
                ]);
                session()->flash('status', 'Plan successfully Debited.');
                 $this->reset('amount','message');


        }
    }

    public function bonus()
    {
        $validate = $this->validate([
            'bonus_amount' => 'required|integer',
        ]);


        $user = User::findOrFail($this->user->id);

        $user->transactions()->create([
            'amount' => $validate['bonus_amount'],
            'transaction_type' => 'Bonus',
            'message' => 'Bonus Credited',
           ]);
           session()->flash('bonus-status', 'Bonus successfully Credited.');
            $this->reset('bonus_amount');
    }

    public function with(): array
    {
        $credit = Transaction::where('user_id', $this->user->id)
                            ->where('transaction_type', 'Credit')
                            ->pluck('amount')
                            ->sum();

        $debit = Transaction::where('user_id', $this->user->id)
                            ->where('transaction_type', 'Debit')
                            ->pluck('amount')
                            ->sum();

        $totalBalance = $credit - $debit;

       $bonus = Transaction::where('user_id', $this->user->id)
                            ->where('transaction_type', 'Bonus')
                            ->pluck('amount')
                            ->sum();
        return [
            'totalBalance' => $totalBalance,
            'bonus' => $bonus,
        ];
    }
}; ?>

<div>
    <div>
        <p class="text-text-[#0891b2] dark:text-white font-semibold text-2xl my-8">{{ $user->fname.' '.$user->lname }} Transactions</p>
    <div class="my-6 md:grid md:grid-cols-2 md:gap-4">
        <div class="shadow-lg rounded-lg border border-gray-300 hover:border-gray-400  p-3 mb-4 md:mb-0 dark:bg-gray-900">
            <div class="flex justify-between mx-2">
                <div>
                    <p class="mb-4 text-xl font-medium text-gray-800 dark:text-white">${{ number_format($totalBalance) }}</p>
                    <p class="font-bold text-lg text-gray-700 dark:text-gray-400">R.O.I</p>
                </div>
                <div class="my-auto">
                    <svg class="w-6 h-6 text-[#0891B2] dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 20">
                        <path
                            d="M18.972.863a.913.913 0 0 0-.041-.207.956.956 0 0 0-.107-.19 1.01 1.01 0 0 0-.065-.116c-.008-.01-.02-.013-.028-.022a1.008 1.008 0 0 0-.174-.137 1.085 1.085 0 0 0-.141-.095 1.051 1.051 0 0 0-.171-.047.985.985 0 0 0-.207-.041C18.025.007 18.014 0 18 0h-3.207a1 1 0 1 0 0 2h.5l-4.552 3.9-3.5-.874a1 1 0 0 0-.867.189l-5 4a1 1 0 0 0 1.25 1.562L7.238 7.09l3.52.88a1 1 0 0 0 .892-.211L17 3.173v1.034a1 1 0 0 0 2 0V1a.9.9 0 0 0-.028-.137ZM13.5 9a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11Zm.24 4.591a3.112 3.112 0 0 1 1.935 1.374 2.036 2.036 0 0 1 .234 1.584 2.255 2.255 0 0 1-1.374 1.469.982.982 0 0 1-1.953.09 2.943 2.943 0 0 1-1.475-.92 1 1 0 0 1 1.536-1.283.953.953 0 0 0 .507.29.778.778 0 0 0 .831-.18 1.108 1.108 0 0 0-.714-.481 3.105 3.105 0 0 1-1.934-1.374 2.042 2.042 0 0 1-.233-1.584 2.264 2.264 0 0 1 1.45-1.493v-.03a1 1 0 0 1 2 0c.517.159.98.457 1.337.862a1.002 1.002 0 1 1-1.524 1.3.962.962 0 0 0-.507-.286.775.775 0 0 0-.829.18 1.113 1.113 0 0 0 .713.482ZM6 20a1 1 0 0 1-1-1v-6a1 1 0 1 1 2 0v6a1 1 0 0 1-1 1Zm-4 0a1 1 0 0 1-1-1v-4a1 1 0 1 1 2 0v4a1 1 0 0 1-1 1Z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="shadow-lg rounded-lg border border-gray-300 hover:border-gray-400  p-3 mb-4 md:mb-0 dark:bg-gray-900">
            <div class="flex justify-between mx-2">
                <div>
                    <p class="mb-4 text-xl font-medium text-gray-800 dark:text-white">${{ number_format($bonus) }}</p>
                    <p class="font-bold text-lg text-gray-700 dark:text-gray-400">Bonus</p>
                </div>
                <div class="my-auto">
                    <svg class="w-6 h-6 text-[#0891B2] dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 19v-9m3-4H5.5a2.5 2.5 0 1 1 0-5C7 1 8.375 2.25 9.375 3.5M12 19v-9m-9 0h14v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-8ZM2 6h16a1 1 0 0 1 1 1v3H1V7a1 1 0 0 1 1-1Zm12.155-5c-3 0-5.5 5-5.5 5h5.5a2.5 2.5 0 0 0 0-5Z" />
                    </svg>
                </div>
            </div>
        </div>

    </div>


    {{--  ////////////////////////// Transaction form /////////////////////  --}}

    <div>
        <h2 class="mt-8 font-bold text-gray-800 text-2xl text-center dark:text-white">Transactions</h2>
        <div class="mt-12 md:grid md:grid-cols-2 gap-4">
            <div class="shadow-lg rounded-lg p-5 mb-8 md:mb-0 dark:bg-gray-900">
                <p class="mb-6 font-semibold text-gray-800 text-center text-xl dark:text-gray-300">Daily Profit</p>
                @if (session('status'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert">
                        <span class="font-medium"> {{ session('status') }}</span>
                    </div>
                @endif
                @if (session('low-status'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <span class="font-medium"> {{ session('low-status') }}</span>
                    </div>
                @endif
                <form wire:submit="profit" class="">
                    <div class="mb-6">
                        <label for="amount"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                        <input wire:model="amount" type="number" id="amount"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="amount" required>
                        <div>
                            @error('amount')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="transation_type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transation Type</label>
                        <select wire:model="transaction_type" id="transation_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option value=""> --select any-- </option>
                            <option value="Credit">Credit</option>
                            <option value="Debit">Debit</option>
                        </select>
                        <div>
                            @error('transaction_type')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="message"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaction
                            message</label>
                        <textarea wire:model="message" id="message" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required placeholder="Write your message here..."></textarea>
                        <div>
                            @error('message')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                        Profit</button>
                </form>
            </div>

            <div class="shadow-lg rounded-lg dark:bg-gray-900 p-5">
                <p class="mb-6 font-semibold text-gray-800 text-center text-xl dark:text-gray-300">Bonus</p>
                @if (session('bonus-status'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert">
                        <span class="font-medium"> {{ session('bonus-status') }}</span>
                    </div>
                @endif
                <form wire:submit="bonus" class="">
                    <div class="mb-6">
                        <label for="amount"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                        <input type="number" wire:model="bonus_amount" id="amount"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="amount" required>
                    </div>
                    <div class="mb-6">
                        <label for="transation_type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transation Type</label>
                        <input type="text" disabled
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Bonus">
                    </div>
                    <button type="submit"
                        class="text-white  bg-[#0891B2] hover:bg-[#3d8597] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                        Bonus</button>
                </form>
            </div>
        </div>
    </div>


</div>

</div>
