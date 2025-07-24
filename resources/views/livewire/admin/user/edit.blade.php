<?php

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Withdrawal;

new #[Layout('components.admin')] class extends Component {

    #[Locked]
    public $id;

    public $fname = '';

    public $lname = '';

    public $email = '';

    public $phone = '';

    public function mount(User $user)
    {
        $this->id = $user->id;
        $this->fname = $user->fname;
        $this->lname = $user->lname;
        $this->email = $user->email;
        $this->phone = $user->phone;
       
    }

    public function update()
    {
        $validated = $this->validate([
            'fname' => 'required | string',
            'lname' => 'required | string',
            'email' => 'required | unique:users,email,'.$this->id,
            'phone' => 'nullable',
           
        ]);

        $user = User::findOrFail($this->id)->update($validated);

        session()->flash('status', 'User successfully updated.');

        $this->redirect('/admin/user');
    }


}; ?>

<div>
    <div>
    @if (session('status'))
       <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
           <span class="font-medium"> {{ session('status') }}</span>
       </div>
   @endif

   @if (session('addPackage'))
           <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
               <span class="font-medium"> {{ session('addPackage') }}</span>
           </div>
   @endif

   @if (session('updatePackage'))
       <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
           <span class="font-medium"> {{ session('updatePackage') }}</span>
       </div>
   @endif


    <p class="text-text-[#0891b2] dark:text-white font-semibold text-2xl my-8">Edit {{ $fname.' '. $lname }}</p>
 

   {{--  ////////////////////////profile ///////////////////////  --}}
   <div class="shadow rounded p-8 dark:bg-gray-900">
       <form  wire:submit="update">
           <div class="md:grid md:grid-cols-2 gap-4">
               <div class="mb-6">
                   <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First name</label>
                   <input type="text" wire:model='fname' id="fname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Full Name" >
                   <div>
                       @error('fname') <span class="text-red-500">{{ $message }}</span> @enderror
                   </div>
               </div>

               <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                <input type="text" wire:model='lname' id="lname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Full Name" >
                <div>
                    @error('lname') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

               <div class="mb-6">
                   <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                   <input type="email" wire:model='email' id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Email" >
                   <div>
                       @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                   </div>
               </div>
               
               <div class="mb-6">
                   <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                   <input type="text" wire:model='phone' id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="phone" >
                   <div>
                       @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                   </div>
               </div>

               
             
               <div class="col-span-2">
                   <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update
                       {{--  <div wire:loading="update">
                          ...
                       </div>  --}}
                   </button>
               </div>
           </div>
       </form>
   </div>

   
</div>

</div>