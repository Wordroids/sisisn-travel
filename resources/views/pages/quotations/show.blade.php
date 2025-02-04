<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Quotation Details</h2>

        <div class="bg-gray-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold">Basic Information</h3>
            <p><strong>Quote Reference:</strong> {{ $quotation->quote_reference }}</p>
            <p><strong>Booking Reference:</strong> {{ $quotation->booking_reference }}</p>
            <p><strong>Market:</strong> {{ $quotation->market->name }}</p>
            <p><strong>Customer:</strong> {{ $quotation->customer->name ?? 'N/A' }}</p>
            <p><strong>Tour Date:</strong> {{ $quotation->start_date }} to {{ $quotation->end_date }} ({{ $quotation->duration }} days)</p>
            <p><strong>Currency:</strong> {{ $quotation->currency }} (Rate: {{ $quotation->conversion_rate }})</p>
            <p><strong>Markup Per Person:</strong> {{ $quotation->markup_per_person }}</p>
        </div>

        <div class="bg-gray-100 p-4 rounded-lg mt-4">
            <h3 class="text-lg font-semibold">Pax Slab Details</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Pax Slab</th>
                        <th class="border px-4 py-2">Exact Pax</th>
                        <th class="border px-4 py-2">Vehicle Type</th>
                        <th class="border px-4 py-2">Vehicle Payout Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotation->paxSlabs as $paxSlab)
                        <tr class="border hover:bg-gray-100">
                            <td class="border px-4 py-2">{{ $paxSlab->paxSlab->name }}</td>
                            <td class="border px-4 py-2">{{ $paxSlab->exact_pax }}</td>
                            <td class="border px-4 py-2">{{ $paxSlab->vehicleType->name }}</td>
                            <td class="border px-4 py-2">{{ $paxSlab->vehicle_payout_rate }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-gray-100 p-4 rounded-lg mt-4">
            <h3 class="text-lg font-semibold">Accommodation Details</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Hotel</th>
                        <th class="border px-4 py-2">Date Range</th>
                        <th class="border px-4 py-2">Meal Plan</th>
                        <th class="border px-4 py-2">Room Type</th>
                        <th class="border px-4 py-2">Total Nights</th>
                        <th class="border px-4 py-2">Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotation->accommodations as $accommodation)
                        <tr class="border hover:bg-gray-100">
                            <td class="border px-4 py-2">{{ $accommodation->hotel->name }}</td>
                            <td class="border px-4 py-2">{{ $accommodation->start_date }} - {{ $accommodation->end_date }}</td>
                            <td class="border px-4 py-2">{{ $accommodation->mealPlan->name }}</td>
                            <td class="border px-4 py-2">{{ $accommodation->roomType->name }}</td>
                            <td class="border px-4 py-2">{{ $accommodation->nights }}</td>
                            <td class="border px-4 py-2">{{ $accommodation->total_cost }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-gray-100 p-4 rounded-lg mt-4">
            <h3 class="text-lg font-semibold">Travel Plan</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Route</th>
                        <th class="border px-4 py-2">Date Range</th>
                        <th class="border px-4 py-2">Vehicle Type</th>
                        <th class="border px-4 py-2">Mileage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotation->travelPlans as $travelPlan)
                        <tr class="border hover:bg-gray-100">
                            <td class="border px-4 py-2">{{ $travelPlan->route->name }}</td>
                            <td class="border px-4 py-2">{{ $travelPlan->start_date }} - {{ $travelPlan->end_date }}</td>
                            <td class="border px-4 py-2">{{ $travelPlan->vehicleType->name }}</td>
                            <td class="border px-4 py-2">{{ $travelPlan->mileage }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right mt-6">
            <a href="{{ route('quotations.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back to List</a>
        </div>
    </div>
</x-app-layout>
