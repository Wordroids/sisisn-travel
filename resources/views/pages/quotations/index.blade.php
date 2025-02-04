<x-app-layout>
    <section class="bg-gray-50 py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div class="flex flex-col py-3 space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 md:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">All Quotations:</span>
                                <span>{{ $quotations->count() }}</span>
                            </h5>
                        </div>
                    </div>

                    <!-- Add New Quotation Button -->
                    <div class="flex flex-col items-stretch justify-between py-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                        <a href="{{ route('quotations.step_one') }}" 
                           class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add New Quotation
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Quote Ref</th>
                                <th scope="col" class="px-4 py-3">Booking Ref</th>
                                <th scope="col" class="px-4 py-3">Market</th>
                                <th scope="col" class="px-4 py-3">Customer</th>
                                <th scope="col" class="px-4 py-3">Tour Date</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap">Status</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotations as $quotation)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-2 font-medium text-gray-900">{{ $quotation->quote_reference }}</td>
                                <td class="px-4 py-2 text-green-600 font-semibold">{{ $quotation->booking_reference }}</td>
                                <td class="px-4 py-2">{{ $quotation->market->name }}</td>
                                <td class="px-4 py-2">{{ $quotation->customer->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $quotation->start_date }} - {{ $quotation->end_date }}</td>
                                
                                <!-- Status Badge -->
                                <td class="px-4 py-2">
                                    <div class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-lg 
                                    {{ $quotation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($quotation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       'bg-red-100 text-red-800') }}">
                                        <span class="w-2 h-2 mr-1 rounded-full 
                                        {{ $quotation->status === 'pending' ? 'bg-yellow-500' : 
                                           ($quotation->status === 'confirmed' ? 'bg-green-500' : 'bg-red-500') }}">
                                        </span>
                                        {{ ucfirst($quotation->status) }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('quotations.show', $quotation->id) }}" class="text-blue-600 hover:underline mr-2">View</a>
                                    <a href="" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                    <form action="" method="POST" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $quotations->links() }}
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
