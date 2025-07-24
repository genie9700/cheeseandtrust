<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Volt\Component;

new #[Layout('components.admin')] class extends Component {
    use WithPagination;

    public $id;

    // Properties for the create/edit modal
    public $showCreateModal = false;
    public $fname = '';
    public $lname = '';
    public $email = '';
    public $phone = '';
    public $country = '';
    public $password = '';

    // Method to open and prepare the create modal
    public function create()
    {
        $this->resetCreateForm();
        $this->showCreateModal = true;
    }

    // Method to reset the form fields
    public function resetCreateForm()
    {
        $this->reset(['fname', 'lname', 'email', 'phone', 'country', 'password']);
        $this->resetErrorBag();
    }

    // Method to save the new user
    public function saveUser()
    {
        $this->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'country' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'fname' => $this->fname,
            'lname' => $this->lname,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('status', 'User successfully created.');
        $this->showCreateModal = false;
        $this->resetCreateForm();
        // The component will re-render automatically, showing the new user.
    }

    public function delete($id)
    {
        $this->id = $id;
    }

    public function destroy()
    {
        User::findOrFail($this->id)->delete();
        session()->flash('status', 'User successfully deleted.');
        $this->redirect('/admin/users', navigate: true);
    }

    public function with(): array
    {
        return [
            'users' => User::where('is_admin', 0)->latest()->paginate(10),
        ];
    }
}; ?>

<div>
    <div>
        <div class="flex items-center justify-between">
            <p class="text-text-[#0891b2] dark:text-white font-semibold text-2xl my-8">Users</p>
            <button wire:click="create" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition ease-in-out">
                + Create User
            </button>
        </div>
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
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Phone</th>
                            <th scope="col" class="px-6 py-3">Country</th>
                            <th scope="col" class="px-6 py-3">Created</th>
                            <th scope="col" class="px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $item)
                            @include('livewire.inc.delete-modal')
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->fname . ' ' . $item->lname }}
                                </th>
                                <td class="px-6 py-4">{{ $item->email }}</td>
                                <td class="px-6 py-4">{{ $item->phone }}</td>
                                <td class="px-6 py-4">{{ $item->country }}</td>
                                <td class="px-6 py-4">{{ $item->created_at->format('d M, Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.user.edit', $item->id) }}" wire:navigate class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">Edit</a>
                                    <a href="{{ route('admin.transaction.show', $item->id) }}" wire:navigate class="font-medium text-green-600 dark:text-green-500 hover:underline mr-2">Transactions</a>
                                    <a href="#" wire:click="delete({{ $item->id }})" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="6" class="py-12 text-center">
                                    <p class="font-semibold text-xl text-gray-700 dark:text-gray-200">No Users Found</p>
                                    <p class="mt-2 font-medium text-gray-500 dark:text-gray-400">Create a new user to get started.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div x-data="{ show: $wire.entangle('showCreateModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" @click="show = false">
                <div class="absolute inset-0 bg-black/70"></div>
            </div>
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="saveUser">
                    <div class="px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Create New User</h3>
                        <div class="mt-4 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="fname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                                    <input type="text" wire:model.defer="fname" id="fname" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                    @error('fname') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="lname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                                    <input type="text" wire:model.defer="lname" id="lname" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                    @error('lname') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" wire:model.defer="email" id="email" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                <input type="tel" wire:model.defer="phone" id="phone" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                                <input type="text" wire:model.defer="country" id="country" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                @error('country') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                <input type="password" wire:model.defer="password" id="password" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            <span wire:loading.remove wire:target="saveUser">Create User</span>
                            <span wire:loading wire:target="saveUser">Creating...</span>
                        </button>
                        <button type="button" @click="show = false" class="mt-3 inline-flex justify-center w-full rounded-md border border-gray-300 dark:border-gray-500 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
