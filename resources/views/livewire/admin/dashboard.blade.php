<?php

use App\Models\User;
use App\Models\Deposit;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Withdrawal;

new #[Layout('components.admin')] class extends Component {
    public function with(): array
    {
        $totalUsers = User::where('is_admin', 0)->count();
        $totalwithdrawals = Withdrawal::count();
        $totalDeposits = Deposit::where('status', 1)->pluck('amount')->sum();

        return [
            'totalUsers' => $totalUsers,
            'totalwithdrawals' => $totalwithdrawals,
            'totalDeposits' => $totalDeposits,
        ];
    }
}; ?>

<div>
    <div class="">
        <p class="text-text-[#0891b2] dark:text-white font-semibold text-2xl my-8">Dashboard</p>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="shadow-lg rounded-lg border border-gray-300 hover:border-gray-400  p-4 mb-4 md:mb-0 dark:bg-gray-800">
                <div class="flex justify-between items-center">
                    <div class="">
                        <p class="mb-4 text-xl font-medium text-gray-600 dark:text-white">{{ $totalUsers }}</p>
                        <h2 class="font-bold text-lg text-gray-700 dark:text-white">Total USers</h2>
                    </div>
                    <div>
                        <svg class="w-8 h-8 text-[#0891B2]  dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 3a3 3 0 1 1-1.614 5.53M15 12a4 4 0 0 1 4 4v1h-3.348M10 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM5 11h3a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="shadow-lg rounded border border-gray-300 hover:border-gray-400  p-4 mb-4 md:mb-0">
                <div class="flex justify-between items-center">
                    <div class="">
                        <p class="mb-4 text-xl font-medium text-gray-600 dark:text-white">${{ number_format($totalDeposits) }}</p>
                        <h2 class="font-bold text-lg text-gray-700 dark:text-white">Total Deposits</h2>
                    </div>
                    <div>
                        <svg class="w-8 h-8 text-[#0891B2] dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 1h12M3 1v16M3 1H2m13 0v16m0-16h1m-1 16H3m12 0h2M3 17H1M6 4h1v1H6V4Zm5 0h1v1h-1V4ZM6 8h1v1H6V8Zm5 0h1v1h-1V8Zm-3 4h2a1 1 0 0 1 1 1v4H7v-4a1 1 0 0 1 1-1Z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="shadow-lg rounded border border-gray-300 hover:border-gray-400  p-4 mb-4 md:mb-0">
                <div class="flex justify-between items-center">
                    <div class="">
                        <p class="mb-4 text-xl font-medium text-gray-600 dark:text-white">--</p>
                        <h2 class="font-bold text-lg text-gray-700 dark:text-white">Total Withdrawals</h2>
                    </div>
                    <div>
                        <svg class="w-8 h-8 text-[#0891B2] dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
