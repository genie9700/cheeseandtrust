<?php

use App\Models\Deposit;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;


new #[Layout('components.admin')] class extends Component {

    public $depositId;

    public function mount($deposit)
    {
        $this->depositId = $deposit;
        // $dep = Deposit::with('user')->where('id', $this->deposit)->first();

        // dd($dep);

    }

    public function approve($id)
    {
        $approved = Deposit::findOrFail($id);

        $approved->status = 1;

        $approved->update();

        $this->redirect('/admin/deposits/'.$approved->id.'/edit');

    }

    public function pending($id)
    {
        $pending = Deposit::findOrFail($id);

        $pending->status = 0;

        $pending->update();

        $this->redirect('/admin/deposits/'.$pending->id.'/edit');


    }

    public function saveme(){
        dd('saved');
    }

    public function with(): array
    {

        return [
            'deposit' => Deposit::with('user')->where('id', $this->depositId)->first(),
            // 'deposits' => Deposit::where('image_slip', '!=', NULL)->with('user')->latest()->paginate()
        ];

        
    }
}; ?>

<div>
    <div>
        <p class="text-text-[#0891b2] dark:text-white font-semibold text-2xl my-8">{{  $deposit->user->fname. ' ' .$deposit->user->lname }} Deposit</p>
    @if (session('status'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium"> {{ session('status') }}</span>
        </div>
    @endif
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Full Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Method
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <div>
                    @include('livewire.inc.delete-modal')
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $deposit->user->fname. ' ' .$deposit->user->lname }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $deposit->method }}
                        </th>
                        <td class="px-6 py-4">
                            ${{ number_format($deposit->amount) }}
                        </td>
                        <td class="px-6 py-4">
                            {{--  {{ $deposit->status }}  --}}
                            @if ($deposit->status == 1)
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Active</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if ($deposit->status == 1)
                                <button type="button" wire:click="pending({{ $deposit->id }})"  class="font-medium text-red-600 dark:text-red-500 hover:underline mr-2">Pending</button>
                            @else
                                <button type="button" wire:click="approve({{ $deposit->id }})"  class="font-medium text-green-600 dark:text-green-500 hover:underline mr-2">Active</button>
                            @endif
                        </td>
                    </tr>
                </div>
            </tbody>
        </table>
    </div>
    <div class="mt-8">
        <p class="font-bold text-xl text-gray-800">Payment Slip</p>
        <div class="mt-3 shadow flex justify-center">
            <img width="500" src="{{ asset('storage/'.$deposit->payment_slip) }}" alt="">
        </div>
    </div>
</div>

</div>
