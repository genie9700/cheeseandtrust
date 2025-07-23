<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Volt\Component;

new #[Layout('components.admin')] class extends Component {
    use WithPagination;

    public $id;

    public function delete($id)
    {
        $this->id = $id;
    }

    public function destroy()
    {
        $user = User::findOrFail($this->id)->delete();

        session()->flash('status', 'User successfully Deleted.');

        $this->redirect('/admin/user', navigate: true);

        // $this->dispatch('regeneratedCodes');
    }

    public function with(): array
    {
        $users = User::where('is_admin', 0)->latest()->paginate(10);

        return [
            'users' => $users,
        ];
    }
}; ?>

<div>
    <div>
        <p class="text-text-[#0891b2] dark:text-white font-semibold text-2xl my-8">Users</p>
        <div>
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium"> {{ session('status') }}</span>
                </div>
            @endif
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Phone
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Country
                            </th>
                            <th scope="col" class="px-6 py-3">
                                created
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $item)
                            @include('livewire.inc.delete-modal')

                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->fname . ' ' . $item->lname }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $item->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->phone }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->country }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->created_at }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.user.edit', $item->id) }}" wire:navigate
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">Edit</a>
                                    <a href="{{ route('admin.transaction.show', $item->id) }}" wire:navigate
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline mr-2">Transactions</a>
                                    <a href="#" wire:click="delete({{ $item->id }})"
                                        data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td colspan="5" class="text-center">
                                    <p class="my-5 font-semibold text-xl text-gray-800">No Records Found</p>
                                    <p class="mb-5 font-medium text-gray-500 text-md">Create a new user </p>
                                </td>
                            <tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
