<x-app-layout>
    <section class="py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div
                        class="flex flex-col py-3 space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 md:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">All Customers:</span>
                                <span>{{ $customers->count() }}</span>
                            </h5>
                        </div>
                    </div>

                    <!-- Add New Customer Button -->
                    <div
                        class="flex flex-col items-stretch justify-between py-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                        <a href="{{ route('customers.create') }}"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add new customer
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Phone</th>
                                <th class="px-4 py-3">WhatsApp</th>
                                <th class="px-4 py-3">Country</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $customer->name }}</td>
                                    <td class="px-4 py-2">{{ $customer->email }}</td>
                                    <td class="px-4 py-2">{{ $customer->phone }}</td>
                                    <td class="px-4 py-2">{{ $customer->whatsapp }}</td>
                                    <td class="px-4 py-2">{{ $customer->country }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('customers.show', $customer) }}"
                                            class="text-blue-600 hover:underline mr-2">View</a>
                                        <a href="{{ route('customers.edit', $customer) }}"
                                            class="text-yellow-600 hover:underline mr-2">Edit</a>
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST"
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
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
