<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

new class extends Component {
    use WithFileUploads;

    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';
    public $fname= '';
    public $lname= '';
    public $email= '';
    public $country= ''; 
    public $profile_pic;
    public $current_image;


    public function mount(){
        $user = Auth::user();

        $this->fname = $user->fname;
        $this->lname = $user->lname;
        $this->email = $user->email;
        $this->country = $user->country;
        $this->current_image = $user->profile_pic;
    }


    public function rules()
    {
        $user = Auth::user();   

        return[
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'profile_pic' => ['nullable', 'image'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ];
    }

        public function update_profile_pic()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'profile_pic' => ['required', 'image'],
        ]);

        if ($this->current_image) {
            // Delete the old image
            Storage::delete('public/' . $this->current_image);
        }

        // Store the new image
        $this->current_image = $this->profile_pic->store('profile', 'public');
        $validated['profile_pic'] = $this->current_image;

        // if($this->profile_pic){
        //     $validated['profile_pic']->store('profile', 'public');
        // }

        $user->update($validated);
        $this->reset('profile_pic');
        $this->dispatch('profile-photo', text: 'Photo Updated Successfully');
        

     
    }

    public function update_profile(){
        $user = Auth::user();
        $validated = $this->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);
       
        // $user->fill($validated);

        $user->update($this->only(['fname', 'lname', 'country', 'email']));
        $this->dispatch('profile-update', text: 'Profile Updated Successfully'); 
        // $this->reset('fname', 'lname', 'country', 'email'); 
    }

    public function update_password()
    {
        try {
            $validated = $this->validate();
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');
            $this->dispatch('profile-update', text: 'Profile Updated Successfully'); 
    
            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);
    
        $this->reset('current_password', 'password', 'password_confirmation');
    
        $this->dispatch('password-update', text: 'Password Updated Successfully'); 
    }
}; ?>

<div>
    <div class="md:p-4">
    <p class="text-white font-bold text-xl mb-10 p-2">Profile</p>
    <div class="md:grid md:grid-cols-3 md:gap-4 md:mb-0 mb-4">
        <div class="col-span-1">
            <div class="bg-[#131824] rounded-lg">
                <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">About</p>
                <div class="flex flex-col md:flex-row md:space-x-4 py-2 px-4 items-center">
                    <div>
                        @if (Auth::user()->profile_pic)
                            <div class="relative w-12 h-12 md:w-16 md:h-16 ">
                                <img 
                                    width="64" height="64"
                                    class="rounded-full object-cover w-12 h-12 md:w-16 md:h-16  border-4 border-blue-500 shadow-lg"
                                    src="{{ asset('storage/' . $current_image) }}"
                                    alt="Profile Photo"
                                >
                                <span class="absolute bottom-0 right-0 block w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                            </div>
                        @else
                            <div>
                                <img width="50" height="50"class="rounded-full block" src="data:image/png;base64,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" alt="">
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-white font-bold text-xl">{{ Auth::user()->fname. ' ' .Auth::user()->lname  }}</p>
                        <p class="text-gray-400 font-bold text-md">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-[#131824] rounded-lg my-8">
                <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Account</p>
                <div class="space-y-1 px-5 py-3">
                    <p class="text-blue-600 text-lg font-bold">Account Type</p>
                    <p class="text-white font-bold text-md">Starter</p>
                </div>
            </div>
            <div class="bg-[#131824] rounded-lg my-8">
                <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Actions</p>
                <div class="px-5 py-3">
                    <div class="mt-2">
                       <div
                            {{-- This main Alpine component handles the upload progress events --}}
                            x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false; progress = 0"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                        >
                            <form wire:submit="update_profile_pic">
                                <label for="profile_pic_input" class="mb-2 text-gray-400 inline-block font-bold">Upload Profile Photo</label>
                                <input id="profile_pic_input" accept="image/png, image/jpeg, image/jpg" wire:model="profile_pic" required type="file" class="block w-full mb-1 rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800" placeholder="upload photo">

                                <div x-show="isUploading" class="w-full bg-gray-700 rounded-full h-2.5 mt-3">
                                    <div class="bg-blue-500 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                                </div>
                                @error('profile_pic') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror

                                <button type="submit"
                                    :disabled="! @entangle('profile_pic')"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="!bg-blue-400 cursor-wait"
                                    :class="{ 'bg-gray-700 cursor-not-allowed': ! @entangle('profile_pic'), 'bg-blue-500 hover:bg-blue-600': @entangle('profile_pic') }"
                                    class="flex items-center justify-center text-white font-bold w-full rounded-lg py-3 mt-4 transition ease-in-out">
                                    
                                    <svg wire:loading wire:target="update_profile_pic" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                            
                                    <span wire:loading.remove wire:target="update_profile_pic">Upload</span>
                                    <span wire:loading wire:target="update_profile_pic">Uploading...</span>
                                    </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- seetings --}}
        <div class="col-span-2">
            <div class="bg-[#131824] rounded-lg">
                <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Profile</p>
                <form wire:submit="update_profile" class="grid grid-cols-2 gap-4 p-3 pb-10">
                    <div class="mt-2 col-span-2">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Email</label>
                        <input wire:model="email" placeholder="{{ auth::user()->email }}" type="text" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                        @error('email') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 col-span-1">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">First Name</label>
                        <input wire:model="fname" placeholder="{{ auth::user()->fname }}" type="text" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                        @error('fname') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 col-span-1">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Last Name</label>
                        <input wire:model="lname" placeholder="{{ auth::user()->lname }}" type="text" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                        @error('lname') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 col-span-2">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Country</label>
                        <input wire:model="country" placeholder="{{ auth::user()->country }}" type="text" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                        @error('country') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <button class="bg-blue-500 text-white w-full text-center font-bold text-lg p-2 rounded-lg mt-8">Save</button>
                </form>
            </div>

            <div class="bg-[#131824] rounded-lg mt-8">
                <p class="text-gray-400 font-bold text-md bg-[#19202F] rounded-t-lg p-3">Settings</p>
                <form wire:submit="update_password" class="grid grid-cols-2 gap-4 p-3 pb-10">
                    <div class="mt-2 col-span-2">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Current Password</label>
                        <input wire:model="current_password"  type="text" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                        @error('current_password') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 col-span-1">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">New password</label>
                        <input wire:model="password" type="text" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                        @error('password') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 col-span-1">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Confirm New Password</label>
                        @error('password_confirmation') <span class="text-red-500 font-bold text-sm mt-1">{{ $message }}</span> @enderror
                        <input wire:model="password_confirmation" type="text" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800">
                    </div>
                    
                    <button x-data="{ current_password: @entangle('current_password'),  password: @entangle('password'),  password_confirmation: @entangle('password_confirmation')}"
                            :class="{'bg-gray-700 cursor-not-allowed text-white': !current_password || !password || !password_confirmation, 'bg-blue-500 text-white': current_password && password && password_confirmation }"
                            :disabled="!current_password || !password || !password_confirmation"
                            class="bg-blue-500 block text-white font-bold w-full rounded-lg py-3">Save</button>
                </form>
            </div>

        </div>
    </div>
</div>
@section('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
        Livewire.on('password-update', (event) => {
            var delay = alertify.get('notifier','delay');
            alertify.set('notifier','position', 'top-right');

            alertify.set('notifier','delay', 2);
            alertify.success(event.text);
        });
        });
    </script>  

<script>
    document.addEventListener('livewire:init', () => {
    Livewire.on('profile-update', (event) => {
        var delay = alertify.get('notifier','delay');
        alertify.set('notifier','position', 'top-right');

        alertify.set('notifier','delay', 2);
        alertify.success(event.text);
    });
    });
</script> 
<script>
    document.addEventListener('livewire:init', () => {
    Livewire.on('profile-photo', (event) => {
        var delay = alertify.get('notifier','delay');
        alertify.set('notifier','position', 'top-right');

        alertify.set('notifier','delay', 2);
        alertify.success(event.text);
    });
    });
</script>  
@endsection

</div>
