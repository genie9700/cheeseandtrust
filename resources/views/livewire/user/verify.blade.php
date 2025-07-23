<?php

use Livewire\Volt\Component;
use App\Models\Verification;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use WithFileUploads;

    public $type;
    public $document;

    public function rules()
    {
        // $user = Auth::user();

        return [
            'type' => ['max:255'],
            'document' => ['nullable', 'image'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->document) {
            $image = $validated['document']->store('verification', 'public');
        }

        $ref = bin2hex(random_bytes(6));

        // dd($ref);

        $user = Auth::user();
        // dd($user);
        $user->verifications()->create([
            'ref' => $ref,
            'type' => $validated['type'],
            'status' => 0,
            'document' => $image,
        ]);

        $this->reset();
        $this->dispatch('save-verify', text: 'Verification submitted');
    }

    public function with(): array
    {
        $verifications = Verification::where('user_id', Auth::id())->get();
        $verified = Verification::where('user_id', Auth::id())->where('status', 1)->first();

        // dd($verified);
        return [
            'verifications' => $verifications,
            'verified' => $verified,
        ];
    }
}; ?>

<div>
    <div class="md:p-4">
        <p class="text-white font-bold text-xl mb-10 p-2">Verify Account</p>
        <div class="md:grid md:grid-cols-3 md:gap-4 md:mb-0 mb-4">
            <div class="col-span-1">
                <div class="bg-[#131824] rounded-lg">
                    <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Status</p>
                    @if (!empty($verified))
                        <p class="p-3 text-green-500 font-bold text-justify">
                            Your account is Verified.
                        </p>
                    @else
                        <p class="p-3 text-red-500 font-bold text-justify">
                            Your account is not verified. To verify your account, please fill out the form to request
                            verification.
                        </p>
                    @endif
                </div>
            </div>

            <div class="col-span-2 md:mt-0 mt-8">
                <div class="bg-[#131824] rounded-lg">
                    <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Submit Verification</p>
                    <center>
                        <div class="max-w-sm pt-3 pb-6 p-3">
                            <p class="text-white font-bold text-justify mb-5">To request an account verification, kindly
                                provide your
                                information with a valid means of Identification attached
                                as an image document.
                            </p>
                            <div {{-- This main Alpine component will handle the upload progress events --}} x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false; progress = 0"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <form wire:submit="save">
                                    <div>
                                        <label class="mb-2 text-gray-400 font-bold flex justify-start">Type</label>
                                        <select wire:model="type" required
                                            class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                            <option value="">--Select Any--</option>
                                            <option value="State-issued identification card">State-issued identification
                                                card</option>
                                            <option value="Birth certificate">Birth certificate</option>
                                            <option value="Social security card">Social security card</option>
                                            <option value="Passport">Passport</option>
                                            <option value="State-issued driver's license">State-issued driver's license
                                            </option>
                                        </select>
                                        @error('type')
                                            <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mt-6">
                                        <label class="mb-2 text-gray-400 font-bold flex justify-start"
                                            for="">Document</label>
                                        <input wire:model="document" accept="image/png, image/jpeg, image/jpg"
                                            type="file"
                                            class="block w-full mb-1 rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">

                                        <div x-show="isUploading" class="w-full bg-gray-700 rounded-full h-2.5 mt-3">
                                            <div class="bg-blue-500 h-2.5 rounded-full" :style="`width: ${progress}%`">
                                            </div>
                                        </div>
                                        @error('document')
                                            <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if ($verified)
                                        <p
                                            class="p-3 mt-8 text-green-500 font-bold text-justify rounded-lg bg-green-500/10">
                                            Your account is Verified.
                                        </p>
                                    @else
                                        {{-- The button is only shown if the user is not verified --}}
                                        <button type="submit" {{-- Button is now disabled if either the type or document is missing --}}
                                            :disabled="!@entangle('type') || !@entangle('document')"
                                            wire:loading.attr="disabled" wire:loading.class="!bg-blue-400 cursor-wait"
                                            :class="{ 'bg-gray-700 cursor-not-allowed': !@entangle('type') || !
                                                    @entangle('document'), 'bg-blue-500 hover:bg-blue-600': @entangle('type') &&
                                                    @entangle('document') }"
                                            class="flex items-center justify-center text-white font-bold w-full rounded-lg py-3 mt-8 transition ease-in-out">

                                            <svg wire:loading wire:target="save"
                                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>

                                            <span wire:loading.remove wire:target="save">Request Verification</span>
                                            <span wire:loading wire:target="save">Submitting...</span>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </center>

                </div>
            </div>
        </div>
        {{-- Verification history --}}

        <div class="mt-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left bg-[#131824]">
                    <caption class="p-5 text-lg font-semibold text-left bg-[#19202F] text-gray-400">
                        Verifications
                    </caption>
                    <thead class="text-sm text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Ref
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Type
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
                        @forelse ($verifications as $ver)
                            <tr class="text-gray-400">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">
                                    {{ $ver->ref }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $ver->type }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $ver->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if ($ver->status == 0)
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
                                made any Verifications.</td>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    @section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('save-verify', (event) => {
                    var delay = alertify.get('notifier', 'delay');
                    alertify.set('notifier', 'position', 'top-right');

                    alertify.set('notifier', 'delay', 2);
                    alertify.success(event.text);
                });
            });
        </script>
    @endsection

</div>
