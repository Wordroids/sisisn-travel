<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">All Quotations</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Quote Ref</th>
                    <th class="border px-4 py-2">Booking Ref</th>
                    <th class="border px-4 py-2">Market</th>
                    <th class="border px-4 py-2">Customer</th>
                    <th class="border px-4 py-2">Tour Date</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotations as $quotation)
                    <tr class="border hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $quotation->quote_reference }}</td>
                        <td class="border px-4 py-2">{{ $quotation->booking_reference }}</td>
                        <td class="border px-4 py-2">{{ $quotation->market->name }}</td>
                        <td class="border px-4 py-2">{{ $quotation->customer->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $quotation->start_date }} to {{ $quotation->end_date }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('quotations.show', $quotation->id) }}" class="text-blue-600">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
