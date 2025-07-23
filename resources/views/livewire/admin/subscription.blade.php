<?php

use Livewire\Volt\Component;
use App\Models\Subscription;
use Livewire\Attributes\Layout;

new #[Layout('components.admin')] class extends Component {

    public function with(): array
    {
        $subscriptions = Subscription::with('user')->paginate(10);

        return [
            'subscriptions' => $subscriptions,
        ];
    }
}; ?>

<div>
    <p class="text-text-[#0891b2] dark:text-white font-semibold text-2xl my-8">subscriptions</p>

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
                        ref
                    </th>
                    <th scope="col" class="px-6 py-3">
                        user
                    </th>
                    <th scope="col" class="px-6 py-3">
                        amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        status</span>
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($subscriptions as $item)
                @include('livewire.inc.delete-modal')

                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $item->ref }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->user->fname. ' ' .$item->user->lname }}
                        </th>
                        <td class="px-6 py-4">
                            ${{ number_format($item->amount) }}
                        </td>

                        <td class="px-6 py-4">
                            @if ($item->status == 0)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pending</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Success</span>
                            @endif
                        </td>

                    </tr>
                @empty
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td colspan="11" class="text-center">
                       <p class="my-5 font-semibold text-xl text-gray-800">No Records Found</p>
                        <p class="mb-5 font-medium text-gray-500 text-md">Create a New Transaction </p>
                    </td>
                <tr>
                @endforelse
            </tbody>
        </table>
       <div class="p-5">
        {{ $subscriptions->links() }}
       </div>
    </div>
</div>
</div>
