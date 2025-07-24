<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Deposit;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use WithFileUploads;

    public $asset = '';
    public $amount = '';
    public $payment_slip;
    public $methods;

    public function rules()
    {
        return [
            'asset' => 'required|string',
            'amount' => 'required|integer',
            'payment_slip' => 'image|required|max:2024',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->payment_slip) {
            $image = $validated['payment_slip']->store('deposit', 'public');
        }

        $ref = bin2hex(random_bytes(6));

        // dd($ref);

        $user = Auth::user();
        // dd($user);
        $user->deposits()->create([
            'ref' => $ref,
            'method' => $validated['asset'],
            'amount' => $validated['amount'],
            'status' => 0,
            'payment_slip' => $image,
        ]);

        $this->reset();
        $this->dispatch('save-deposit', text: 'Deposited Successfully');
    }

    public function mount()
    {
        $this->methods = Wallet::where('is_active', true)->get();
    }

    public function with(): array
    {
        $deposits = Deposit::where('user_id', Auth::id())->get();

        return [
            'deposits' => $deposits,
        ];
    }
}; ?>

<div>
    <div class="md:p-4">
        {{-- deposit --}}
        <div class="mb-24">
            <p class="text-white font-bold text-xl mb-10">Deposit</p>

            <div class="md:grid md:grid-cols-3 md:gap-4">
                {{-- payment method --}}
                <div class="mb-6 md:mb-0">
                    <div class="bg-[#131824] rounded-lg pb-3">
                        <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Choose Method</p>
                        <div class="p-2">
                            <div id="accordion-collapse" data-accordion="collapse"
                                data-active-classes="bg-[#161C2A] text-white">

                                {{-- Loop through each payment method from the database --}}
                                @forelse($methods as $method)
                                    <div class="bg-[#161C2A] rounded-xl mb-2">
                                        <h2 id="accordion-collapse-heading-{{ $loop->iteration }}">
                                            <button type="button"
                                                class="flex items-center space-x-2 w-full p-5 font-medium rtl:text-right text-gray-500 rounded-t-xl focus:ring-gray-800"
                                                data-accordion-target="#accordion-collapse-body-{{ $loop->iteration }}"
                                                aria-expanded="false"
                                                aria-controls="accordion-collapse-body-{{ $loop->iteration }}">

                                                <img width="30" height="30" class="rounded-full"
                                                    src="{{ $method->icon_url }}" alt="{{ $method->name }} icon">
                                                <span class="font-bold text-lg">{{ $method->name }}</span>
                                            </button>
                                        </h2>
                                        <div id="accordion-collapse-body-{{ $loop->iteration }}" class="hidden"
                                            aria-labelledby="accordion-collapse-heading-{{ $loop->iteration }}">

                                            <!-- START: Alpine.js component for copy functionality -->
                                            <div class="p-5" x-data="{
                                                copyText: 'Tap to copy address',
                                                copyToClipboard() {
                                                    const input = this.$refs.addressInput;
                                                    input.select();
                                                    input.setSelectionRange(0, 99999); // For mobile devices
                                            
                                                    try {
                                                        document.execCommand('copy');
                                                        this.copyText = 'Address Copied!';
                                                    } catch (err) {
                                                        console.error('Copy failed', err);
                                                        this.copyText = 'Copy Failed!';
                                                    }
                                            
                                                    setTimeout(() => {
                                                        this.copyText = 'Tap to copy address';
                                                    }, 2000);
                                                }
                                            }">
                                                <p class="font-bold text-lg text-white">Address</p>
                                                <input x-ref="addressInput"
                                                    class="text-sm text-gray-400 font-bold border border-gray-800 rounded-lg p-3 mt-2 w-full bg-[#131824]"
                                                    value="{{ $method->wallet_address }}" readonly>
                                                <p @click="copyToClipboard()"
                                                    class="text-center text-white font-bold border border-gray-800 rounded-lg p-3 mt-2 cursor-pointer hover:bg-gray-800 hover:text-blue-500"
                                                    x-text="copyText">
                                                </p>
                                            </div>
                                            <!-- END: Alpine.js component -->

                                        </div>
                                    </div>
                                @empty
                                    <p class="p-4 text-gray-400">No payment methods are available at this time.</p>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>

                {{-- mode of payment --}}
                <div class="col-span-2">
                    <div class="bg-[#131824] rounded-lg pb-3">
                        <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Submit Payment</p>
                        <center>
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false; progress = 0"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <form wire:submit="save" class="p-4">
                                    <div class="max-w-80 text-justify py-6">
                                        <p class="text-gray-300 font-bold text-sm mb-6">
                                            To deposit, choose the payment method panel and make the payment to the
                                            displayed
                                            address.
                                            After payment has been made, come back to fill this form.
                                        </p>
                                        <div>
                                            <div>
                                                <label for="coinSelect"
                                                    class="text-gray-400 font-bold block mb-2">Asset</label>
                                                <select wire:model="asset" id="coinSelect" required
                                                    class="w-full bg-[#1F273A] p-4 text-white rounded-lg border-gray-800 focus:ring-gray-800 focus:border-gray-800"
                                                    onchange="showCoinImage()">
                                                    <option value="">--Choose a coin--</option>
                                                    <option value="BTC">BTC</option>
                                                    <option value="ETH">ETH</option>
                                                    <option value="DOGE">DOGE</option>
                                                    <option value="BCH">BCH</option>
                                                </select>

                                                <div class="relative mt-6">
                                                    <label for="coinSelect"
                                                        class="text-gray-400 font-bold block mb-2">Amount</label>
                                                    <input wire:model="amount" type="number"
                                                        class="w-full align-middle block p-4 font-bold bg-[#131824] text-white rounded-lg border-gray-700 focus:ring-gray-800 focus:border-gray-800"
                                                        id="coinInput" placeholder="1000">
                                                    <div>
                                                        <img id="coinImage" width="30" height="10"
                                                            class="rounded-full absolute bottom-4 right-2"
                                                            src="" alt="Coin Image" style="display: none;">

                                                    </div>
                                                    @error('amount')
                                                        <span class="text-red-500">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="my-10">
                                                    <label for="proofInput"
                                                        class="text-gray-400 font-bold block mb-2">Payment
                                                        Proof</label>
                                                    <input accept="image/png, image/jpeg, image/jpg"
                                                        wire:model="payment_slip" type="file" required
                                                        class="w-full align-middle block p-4 font-bold bg-[#131824] text-white rounded-lg border-gray-700 focus:ring-gray-800 focus:border-gray-800"
                                                        id="proofInput">

                                                    <div x-show="isUploading"
                                                        class="w-full bg-gray-700 rounded-full h-2.5 mt-3">
                                                        <div class="bg-blue-500 h-2.5 rounded-full"
                                                            :style="`width: ${progress}%`"></div>
                                                    </div>
                                                    @error('payment_slip')
                                                        <span class="text-red-500 mt-1 block">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <button type="submit" {{-- The button is now disabled if any of the three required fields are missing --}}
                                                    :disabled="!@entangle('asset') || !@entangle('amount') || !@entangle('payment_slip')"
                                                    wire:loading.attr="disabled"
                                                    wire:loading.class="!bg-blue-400 cursor-wait"
                                                    :class="{
                                                        'bg-gray-700 cursor-not-allowed': !@entangle('asset') || !
                                                            @entangle('amount') || !
                                                            @entangle('payment_slip'),
                                                        'bg-blue-500 hover:bg-blue-600': @entangle('asset') &&
                                                            @entangle('amount') && @entangle('payment_slip')
                                                    }"
                                                    class="flex items-center justify-center text-white font-bold w-full rounded-lg py-3 transition ease-in-out">

                                                    {{-- Make sure the wire:target matches your form's submit action ('save') --}}
                                                    <svg wire:loading wire:target="save"
                                                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>

                                                    <span wire:loading.remove wire:target="save">Deposit</span>
                                                    <span wire:loading wire:target="save">Processing...</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </center>

                    </div>
                </div>
            </div>
        </div>

        {{-- deposit history --}}
        <div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left bg-[#131824]">
                    <caption class="p-5 text-lg font-semibold text-left bg-[#19202F] text-gray-400">
                        Deposits
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
                        @forelse ($deposits as $deposit)
                            <tr class="text-gray-400">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">
                                    {{ $deposit->ref }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $deposit->method }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $deposit->amount }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $deposit->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if ($deposit->status == 0)
                                        <button
                                            class="font-bold bg-blue-300 text-blue-600 py-3 px-6 rounded-lg">Pending</button>
                                    @else
                                        <button
                                            class="font-bold bg-green-300 text-green-600 py-3 px-6 rounded-lg">Approved</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <td class="text-center py-12 font-bold text-gray-400 text-md" colspan="5">You have not
                                made any subscriptions.</td>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('save-deposit', (event) => {
                    var delay = alertify.get('notifier', 'delay');
                    alertify.set('notifier', 'position', 'top-right');

                    alertify.set('notifier', 'delay', 2);
                    alertify.success(event.text);
                });
            });
        </script>
    @endsection

</div>
