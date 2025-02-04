<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-gray-800 border-b pb-3">All Quotations</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700 border border-gray-300 rounded-lg shadow">
                <thead class="bg-gray-200 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Quote Ref</th>
                        <th class="px-4 py-3 text-left">Booking Ref</th>
                        <th class="px-4 py-3 text-left">Market</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Tour Date</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y bg-white">
                    @foreach ($quotations as $quotation)
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-4 py-3 font-semibold text-blue-600">{{ $quotation->quote_reference }}</td>
                            <td class="px-4 py-3 font-semibold text-green-600">{{ $quotation->booking_reference }}</td>
                            <td class="px-4 py-3">{{ $quotation->market->name }}</td>
                            <td class="px-4 py-3">{{ $quotation->customer->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $quotation->start_date }} - {{ $quotation->end_date }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('quotations.show', $quotation->id) }}" 
                                    class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add New Quotation Button -->
        <div class="flex justify-end mt-6">
            <a href="{{ route('quotations.step_one') }}" 
                class="bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition">
                + Add New Quotation
            </a>
        </div>
    </div>
</x-app-layout>
