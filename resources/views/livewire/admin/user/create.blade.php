<?php

use App\Models\User;
use App\Models\Deposit;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Withdrawal;

new #[Layout('components.admin')] class extends Component {

    public function with(): array
    {
        $totalUsers = User::where('isAdmin', 0)->count();
        $totalwithdrawals = Withdrawal::count();
        $totalDeposits = Deposit::where('status', 1)
                                ->pluck('amount')
                                ->sum();

        return [
            'totalUsers' => $totalUsers,
            'totalwithdrawals' => $totalwithdrawals,
            'totalDeposits' => $totalDeposits,
        ];
    }

}; ?>

<div>
    
</div>