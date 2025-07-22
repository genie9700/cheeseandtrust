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

   {{-- <div class="my-6 md:grid md:grid-cols-3 md:gap-4">

       <div class="shadow-lg border border-gray-300 hover:border-gray-400  p-3 mb-4 md:mb-0">
           <p class="mb-4 text-lg font-medium text-gray-700">
               @if ($package)
                   ${{ number_format($package->amount) }}</p>
               @else
                   <span class="text-md font-normal">${{ 0 }}</span>
               @endif
           <p class="font-bold text-xl text-gray-800">Capital</p>

       </div>
       <div class="shadow-lg border border-gray-300 hover:border-gray-400  p-3 mb-4 md:mb-0">
           <p class="mb-4 text-lg font-medium text-gray-700">
               @if ($package)
                   {{ $package->plan }}</p>
              @else
                   <span class="text-md font-normal">No Active Plan</span>
               @endif
           <p class="font-bold text-xl text-gray-800">Plan</p>
       </div>
       <div class="shadow-lg border border-gray-300 hover:border-gray-400  p-3 mb-4 md:mb-0">
           <p class="mb-4 text-lg font-medium text-gray-700">---</p>
           <p class="font-bold text-xl text-gray-800">R.O.I</p>
       </div>
   </div> --}}

   {{--  ///////////////////////////////// PLANS //////////////////  --}}
   <h3 class="my-8 text-xl font-semibold text-gray-800">Plans</h3>

   {{-- <div class="mb-6 shadow border border-gray-300 rounded p-5">
       <div class="relative overflow-x-auto  sm:rounded-lg">
           <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                   <tr>
                       <th scope="col" class="px-6 py-3">
                           Plan
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Amount
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Payment mode
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
                   @forelse ($historyPackage as $package)
                       @include('livewire.inc.edit-modal')
                       <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                           <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                               {{ $package->plan }}
                           </th>
                           <td class="px-6 py-4">
                              ${{ number_format($package->amount) }}
                           </td>
                           <td class="px-6 py-4">
                               {{ $package->payment_mode }}
                           </td>
                           <td class="px-6 py-4">
                               @if ($package->status=='Pending')
                                   <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Pending</span>
                               @elseif($package->status=='')
                                   <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-300">Inactive</span>
                               @else
                                   <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Active</span>
                               @endif
                           </td>
                           <td class="px-6 py-4 text-right">
                               <a href="#" wire:click="editPackage({{ $package->id }})" data-modal-target="editModal" data-modal-toggle="editModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">Edit</a>
                           </td>
                       </tr>
                   @empty
                   <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                       <td colspan="5" class="text-center">
                          <p class="my-5 font-semibold text-xl text-gray-800">No Records Found</p>
                           <p class="mb-5 font-medium text-gray-500 text-md">Create a new Plan </p>
                       </td>
                   <tr>
                   @endforelse
               </tbody>
           </table>
       </div>
   </div> --}}

   {{--  ////////////////////////profile ///////////////////////  --}}
   <div class="shadow rounded p-8">
       <form  wire:submit="update">
           <div class="md:grid md:grid-cols-2 gap-4">
               <div class="mb-6">
                   <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First name</label>
                   <input type="text" wire:model='fname' id="fullname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Full Name" >
                   <div>
                       @error('fname') <span class="text-red-500">{{ $message }}</span> @enderror
                   </div>
               </div>

               <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                <input type="text" wire:model='lname' id="fullname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Full Name" >
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