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

        return[
            'type' => ['max:255'],
            'document' => ['nullable', 'image'],
        ];
    }


   public function save()
   {
        $validated = $this->validate();

        if($this->document){
            $image =  $validated['document']->store('verification', 'public');
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
            'verified' => $verified
        ];
    }


}; ?>

<div>
    <div class="p-4">
    <p class="text-white font-bold text-xl mb-10 p-2">Verify Account</p>
    <div class="md:grid md:grid-cols-3 md:gap-4 md:mb-0 mb-4">
            <div class="col-span-1">
                <div class="bg-[#131824] rounded-lg">
                    <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Status</p>
                    @if(!empty($verified))
                        <p class="p-3 text-green-500 font-bold text-justify">
                            Your account is Verified.
                        </p>
                    @else
                        <p class="p-3 text-red-500 font-bold text-justify">
                            Your account is not verified. To verify your account, please fill out the form to request verification.
                        </p>
                    @endif
                </div>
            </div>

            <div class="col-span-2 md:mt-0 mt-8">
                <div class="bg-[#131824] rounded-lg">
                    <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Submit Verification</p>
                    <center>
                        <div class="max-w-sm pt-3 pb-6 p-3">
                            <p class="text-white font-bold text-justify mb-5">To request an account verification, kindly provide your 
                                information with a valid means of Identification attached 
                                as an image document.
                            </p>
                            <form wire:submit="save">
                                <div>
                                    <label class="mb-2 text-gray-400 font-bold flex justify-start">Type</label>
                                    <select wire:model="type" required class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                        <option value="">--Select Any--</option>
                                        <option value="State-issued identification card">State-issued identification card</option>
                                        <option value="Birth certificate">Birth certificate</option>
                                        <option value="Social security card">Social security card</option>
                                        <option value="Passport">Passport</option>
                                        <option value="State-issued driver's license">State-issued driver's license</option>
                                    </select>
                                    @error('type') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="mb-2 mt-8 text-gray-400 font-bold flex justify-start" for="">Document</label>
                                    <input wire:model="document" accept="image/png, image/jpeg, image/jpg" type="file" class="block w-full mb-4 rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                                    @error('document') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                                @if($verified)
                                    <p class="p-3 text-green-500 font-bold text-justify">
                                        Your account is Verified.
                                    </p>
                                @else
                                    <button x-data="{ document: @entangle('document')}"
                                            :class="{'bg-gray-700 cursor-not-allowed text-white': !document, 'bg-blue-500 text-white': document }"
                                            :disabled="!document"
                                        class="bg-blue-500 block text-white font-bold w-full  rounded-lg py-3 mt-8">Request Verification</button>
                                @endif
                            </form>
                        </div>
                    </center>
                    
                </div>
            </div>
    </div>
    {{-- Verification history --}}

    <div class="mt-12">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left bg-[#131824]">
                <caption
                    class="p-5 text-lg font-semibold text-left bg-[#19202F] text-gray-400">
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
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">
                                {{ $ver->ref }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $ver->type }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $ver->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($ver->status == 0)
                                    <button 
                                        class="font-bold bg-blue-300 text-blue-600 py-3 px-6 rounded-lg">Pending</button>
                                @else
                                    <button 
                                        class="font-bold bg-green-300 text-green-600 py-3 px-6 rounded-lg">Approved</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <td class="text-center py-12 font-bold text-gray-400 text-md"  colspan="5">You have not made any Verifications.</td>
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
        var delay = alertify.get('notifier','delay');
        alertify.set('notifier','position', 'top-right');

        alertify.set('notifier','delay', 2);
        alertify.success(event.text);
       });
    });
</script>
    
@endsection

</div>
