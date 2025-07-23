<?php

use App\Models\Deposit;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.admin')] class extends Component {

    public function with(): array
    {

        return [
            'deposits' => Deposit::where('image_slip', '!=', NULL)->with('user')->latest()->paginate()
        ];
    }
}; ?>

<div>
    <div>
        <p class="text-text-[#0891b2] dark:text-white font-semibold text-2xl my-8">Deposits</p>
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
                @forelse ($deposits as $item)
                <div>
                    @include('livewire.inc.delete-modal')
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $item->user->fname. ' ' .$item->user->lname }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->method }}
                        </th>
                        <td class="px-6 py-4">
                            ${{ number_format($item->amount) }}
                        </td>
                        <td class="px-6 py-4">
                            {{--  {{ $item->status }}  --}}
                            @if ($item->status == 1)
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Active</span>
                            @elseif($item->status == 0)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.deposit.edit', $item->id) }}" wire:navigate class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">View</a>
                            {{--  <a href="#" data-modal-target="popup-modal" data-modal-toggle="popup-modal"  wire:click="delete({{ $item->id }})" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>  --}}
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td colspan="5" class="text-center">
                           <p class="my-5 font-semibold text-xl text-gray-800">No Records Found</p>
                            <p class="mb-5 font-medium text-gray-500 text-md">Create a new Plan </p>
                        </td>
                    <tr>
                </div>
                @endforelse
            </tbody>
        </table>
       <div class="p-5">
        {{ $deposits->links() }}
       </div>
    </div>
</div>

</div>
