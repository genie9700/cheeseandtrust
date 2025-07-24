<?php

use Livewire\Volt\Component;
use App\Models\Verification;
use Livewire\Attributes\Layout;

new #[Layout('components.admin')] class extends Component {

    public function with(): array
    {
        $verifications = Verification::with('user')->paginate(10);

        return [
            'verifications' => $verifications,
        ];
    }
}; ?>

<div>
    //
</div>
