<?php

use Livewire\Volt\Component;
use App\Models\Withdrawal;
use Livewire\Attributes\Layout;

new #[Layout('components.admin')] class extends Component {

    public function with(): array
    {
        $withdrawals = Withdrawal::with('user')->paginate(10);

        return [
            'withdrawals' => $withdrawals,
        ];
    }
}; ?>

<div>
    <div>
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
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Account  Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Asset
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Address
                    </th>
                    <th scope="col" class="px-6 py-3">
                        bank name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Account name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Account number
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Paypal Address
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($withdrawals as $item)
                @include('livewire.inc.delete-modal')

                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->user->fname. ' ' .$item->user->lname }}
                        </th>
                        <td class="px-6 py-4">
                            ${{ number_format($item->amount) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->type }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->asset }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->address }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->bank_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->account_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->account_number }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->paypal_address }}
                        </td>
                        <td>

                        </td>
                        <td class="px-6 py-4">
                            @if ($item->status == 0)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pending</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Success</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            {{--  <a href="{{ route('user.edit', $item->id) }}" wire:navigate class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">Edit</a>  --}}
                            {{--  <a href="{{ route('transaction.show', $item->id) }}" wire:navigate class="font-medium text-green-600 dark:text-green-500 hover:underline mr-2">Transactions</a>
                            <a href="#" wire:click="delete({{ $item->id }})" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>  --}}
                        </td>
                    </tr>
                @empty
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td colspan="10" class="text-center">
                       <p class="my-5 font-semibold text-xl text-gray-800">No Records Found</p>
                        <p class="mb-5 font-medium text-gray-500 text-md">Create a New Transaction </p>
                    </td>
                <tr>
                @endforelse
            </tbody>
        </table>
       <div class="p-5">
        {{ $withdrawals->links() }}
       </div>
    </div>
</div>
</div>
