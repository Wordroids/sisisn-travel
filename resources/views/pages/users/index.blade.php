<x-app-layout>
    <section class="py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div
                        class="flex flex-col py-3 space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 md:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">All Users:</span>
                                <span>{{ $users->count() }}</span>
                            </h5>
                        </div>
                    </div>

                    <!-- Add New User Button -->
                    <div
                        class="flex flex-col items-stretch justify-between py-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                        <a href="{{ route('users.create') }}"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add new user
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">User</th>
                                <th scope="col" class="px-4 py-3">Email</th>

                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap">Last Login</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b hover:bg-gray-100">
                                    <!-- User Details -->
                                    <th scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                                alt="{{ $user->name }}" class="w-8 h-8 mr-3 rounded-full">
                                            {{ $user->name }}
                                        </div>
                                    </th>
                                    <td class="px-4 py-2">{{ $user->email }}</td>

                                    <!-- User Role
                                <td class="px-4 py-2">
                                    <div class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7z" />
                                        </svg>
                                        {{ ucfirst($user->role) }}
                                    </div>
                                </td>-->

                                    <!-- Status -->
                                    <td class="px-4 py-2">
                                        <div class="flex items-center">
                                            <div
                                                class="w-3 h-3 mr-2 {{ $user->status === 'active' ? 'bg-green-500' : 'bg-red-500' }} border rounded-full">
                                            </div>
                                            {{ ucfirst($user->status) }}
                                        </div>
                                    </td>

                                    <!-- Last Login -->
                                    <td class="px-4 py-2">
                                        {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'Never' }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('users.show', $user) }}"
                                            class="text-blue-600 hover:underline mr-2">View</a>
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="text-yellow-600 hover:underline mr-2">Edit</a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
