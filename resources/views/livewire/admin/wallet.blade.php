<?php

use Livewire\Volt\Component;
use App\Models\Wallet;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

new #[Layout('components.admin')] class extends Component {
    use WithFileUploads;

    public $methods;

    // We'll use this to hold the model instance we are editing
    public ?Wallet $editing = null;

    // Separate properties for form binding
    public $name = '';
    public $wallet_address = '';
    public $is_active = true;
    public $newIcon;

    // Modal control
    public $showEditModal = false;

    // Mount the component and load the data
    public function mount(): void
    {
        $this->methods = Wallet::orderBy('name')->get();
    }

    // Reset the form fields
    protected function resetForm(): void
    {
        $this->editing = null;
        $this->name = '';
        $this->wallet_address = '';
        $this->is_active = true;
        $this->newIcon = null;
        $this->showEditModal = false;
        $this->resetErrorBag();
    }

    // Show the modal to create a new method
    public function create(): void
    {
        $this->resetForm();
        $this->showEditModal = true;
    }

    // Show the modal to edit an existing method
    public function edit(Wallet $method): void
    {
        $this->resetErrorBag();
        $this->editing = $method;
        $this->name = $method->name;
        $this->wallet_address = $method->wallet_address;
        $this->is_active = $method->is_active;
        $this->showEditModal = true;
    }

    // Save or update the payment method
    public function save(): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'wallet_address' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'newIcon' => 'nullable|image|max:1024', // 1MB Max
        ];

        // Add a rule to require an icon only when creating a new method
        if (!$this->editing) {
            $rules['newIcon'] = 'required|image|max:1024';
        }

        $this->validate($rules);

        // If we are editing, use the existing model. Otherwise, create a new one.
        $methodToSave = $this->editing ?? new Wallet();

        // Handle file upload
        if ($this->newIcon) {
            // Delete the old icon if it exists
            if ($methodToSave->icon_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $methodToSave->icon_url));
            }
            $path = $this->newIcon->store('payment-icons', 'public');
            $methodToSave->icon_url = Storage::url($path);
        }

        // Populate the model with data from our public properties
        $methodToSave->name = $this->name;
        $methodToSave->wallet_address = $this->wallet_address;
        $methodToSave->is_active = $this->is_active;
        $methodToSave->save();

        $this->mount(); // Refresh the list
        $this->resetForm();
    }

    // Delete a payment method
    public function delete(Wallet $method): void
    {
        // Delete the icon file from storage
        if ($method->icon_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $method->icon_url));
        }
        $method->delete();
        $this->mount(); // Refresh the list
    }
}; ?>


<div>
    <div class="">
        <!-- Header -->
        <div class="flex items-center justify-between my-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Payment Methods</h1>
            <div class="flex items-center space-x-4">
                <button wire:click="create" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition ease-in-out">
                    + Add New Method
                </button>
            </div>
        </div>

        <!-- Payment Methods Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Icon</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Wallet Address</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($methods as $method)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                <img src="{{ $method->icon_url }}" alt="{{ $method->name }}" class="w-8 h-8 rounded-full object-cover">
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $method->name }}
                            </th>
                            <td class="px-6 py-4">
                                <span class="block max-w-xs truncate">{{ $method->wallet_address }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($method->is_active)
                                    <span class="px-2.5 py-0.5 text-xs font-medium text-green-800 bg-green-100 dark:text-green-300 dark:bg-green-900 rounded">Active</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-medium text-red-800 bg-red-100 dark:text-red-300 dark:bg-red-900 rounded">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $method->id }})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                                <button wire:click="delete({{ $method->id }})" wire:confirm="Are you sure you want to delete this method?" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white dark:bg-gray-800">
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                No payment methods found. Click "Add New Method" to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Create/Edit Modal -->
        <div x-data="{ show: $wire.entangle('showEditModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" @click="show = false">
                    <div class="absolute inset-0 bg-black/70"></div>
                </div>

                <!-- Modal panel -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                {{ $editing ? 'Edit Payment Method' : 'Create Payment Method' }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <input type="text" wire:model.defer="name" id="name" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-3">
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Wallet Address -->
                                <div>
                                    <label for="wallet_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wallet Address</label>
                                    <input type="text" wire:model.defer="wallet_address" id="wallet_address" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-3">
                                    @error('wallet_address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Icon Upload -->
                                <div>
                                    <label for="newIcon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icon</label>
                                    <input type="file" wire:model="newIcon" id="newIcon" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-200 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-300 dark:hover:file:bg-gray-600">
                                    @error('newIcon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    <div wire:loading wire:target="newIcon" class="text-blue-500 dark:text-blue-400 text-xs mt-1">Uploading...</div>

                                    @if ($newIcon)
                                        <img src="{{ $newIcon->temporaryUrl() }}" class="mt-2 w-16 h-16 rounded-full object-cover">
                                    @elseif ($editing && $editing->icon_url)
                                        <img src="{{ $editing->icon_url }}" class="mt-2 w-16 h-16 rounded-full object-cover">
                                    @endif
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="is_active" class="flex items-center">
                                        <input type="checkbox" wire:model.defer="is_active" id="is_active" class="rounded bg-gray-200 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-blue-500 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <span wire:loading.remove wire:target="save">Save</span>
                                <span wire:loading wire:target="save">Saving...</span>
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
</div>

