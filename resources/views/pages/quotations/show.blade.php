<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-gray-800 border-b pb-3">Quotation Details</h2>

        <!-- Basic Information -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Basic Information</h3>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <p><strong class="text-gray-600">Quote Reference:</strong> <span
                        class="text-blue-600 font-semibold">{{ $quotation->quote_reference }}</span></p>
                <p><strong class="text-gray-600">Booking Reference:</strong> <span
                        class="text-green-600 font-semibold">{{ $quotation->booking_reference }}</span></p>
                <p><strong class="text-gray-600">Market:</strong> {{ $quotation->market->name }}</p>
                <p><strong class="text-gray-600">Customer:</strong> {{ $quotation->customer->name ?? 'N/A' }}</p>
                <p><strong class="text-gray-600">Tour Date:</strong> {{ $quotation->start_date }} to
                    {{ $quotation->end_date }} ({{ $quotation->duration }} days)</p>
                <p><strong class="text-gray-600">Currency:</strong> {{ $quotation->currency }} (Rate: <span
                        class="text-red-500 font-semibold">{{ $quotation->conversion_rate }}</span>)</p>
                <p><strong class="text-gray-600">Markup Per Person:</strong> <span
                        class="text-gray-800">{{ $quotation->markup_per_person }}</span></p>
                <p><strong class="text-gray-600">Driver Name:</strong> <span
                        class="text-gray-800">{{ $quotation->driver->name ?? 'N/A' }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <strong class="text-gray-600">Driver Per Day Charge:</strong> <span
                        class="text-gray-800">{{ $quotation->driver->per_day_charge ?? 'N/A' }}</span>
                </p>
                <p><strong class="text-gray-600">Guide Name:</strong> <span
                        class="text-gray-800">{{ $quotation->guide->name ?? 'N/A' }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <strong class="text-gray-600">Guide Per Day Charge:</strong> <span
                        class="text-gray-800">{{ $quotation->guide->per_day_charge ?? 'N/A' }}</span>
                </p>


            </div>
        </div>

        <!-- Pax Slab Details -->
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Pax Slab Details</h3>
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Pax Slab</th>
                            <th class="px-4 py-3 text-center">Exact Pax</th>
                            <th class="px-4 py-3 text-center">Vehicle Type</th>
                            <th class="px-4 py-3 text-center">Vehicle Payout Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($quotation->paxSlabs as $paxSlab)
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-4 py-3">{{ $paxSlab->paxSlab->name }}</td>
                                <td class="px-4 py-3 text-center">{{ $paxSlab->exact_pax }}</td>
                                <td class="px-4 py-3 text-center">{{ $paxSlab->vehicleType->name }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-blue-600">
                                    {{ $paxSlab->vehicle_payout_rate }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Accommodation Details -->
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Accommodation Details</h3>
            @foreach ($quotation->accommodations as $accommodation)
                <div class="bg-gray-50 p-4 rounded-lg mt-4">
                    <!-- Hotel Info -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-800">{{ $accommodation->hotel->name }}</h4>
                        <div class="grid grid-cols-4 gap-4 text-sm mt-2">
                            <p><span class="text-gray-600">Date:</span> {{ $accommodation->start_date }} -
                                {{ $accommodation->end_date }}</p>
                            <p><span class="text-gray-600">Nights:</span> {{ $accommodation->nights }}</p>
                            <p><span class="text-gray-600">Meal Plan:</span> {{ $accommodation->mealPlan->name }}</p>
                            <p><span class="text-gray-600">Room Category:</span>
                                {{ $accommodation->roomCategory->name }}</p>

                        </div>
                    </div>

                    <!-- Room Details Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">Room Type</th>
                                    <th class="px-4 py-2 text-center">Per Night Cost</th>
                                    <th class="px-4 py-2 text-center">Nights</th>
                                    <th class="px-4 py-2 text-center">Total Cost</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($accommodation->roomDetails as $detail)
                                    <tr class="hover:bg-gray-100 transition">
                                        <td class="px-4 py-2">{{ ucfirst($detail->room_type) }}</td>
                                        <td class="px-4 py-2 text-center">
                                            {{ number_format($detail->per_night_cost, 2) }}</td>
                                        <td class="px-4 py-2 text-center">{{ $detail->nights }}</td>
                                        <td class="px-4 py-2 text-center font-semibold text-green-600">
                                            {{ number_format($detail->total_cost, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Travel Plan -->
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Travel Plan</h3>
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Route</th>
                            <th class="px-4 py-3 text-center">Date Range</th>
                            <th class="px-4 py-3 text-center">Vehicle Type</th>
                            <th class="px-4 py-3 text-center">Mileage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($quotation->travelPlans as $travelPlan)
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-4 py-3">{{ $travelPlan->route->name }}</td>
                                <td class="px-4 py-3 text-center">{{ $travelPlan->start_date }} -
                                    {{ $travelPlan->end_date }}</td>
                                <td class="px-4 py-3 text-center">{{ $travelPlan->vehicleType->name }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-red-500">{{ $travelPlan->mileage }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Site Seeing Details -->
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Site Seeing Details</h3>
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Site Name</th>
                            <th class="px-4 py-3 text-center">Unit Price</th>
                            <th class="px-4 py-3 text-center">Quantity</th>
                            <th class="px-4 py-3 text-center">Price Per Adult</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($quotation->siteSeeings as $site)
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-4 py-3">{{ $site->name }}</td>
                                <td class="px-4 py-3 text-center">{{ number_format($site->unit_price, 2) }}</td>
                                <td class="px-4 py-3 text-center">{{ $site->quantity }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600">
                                    {{ number_format($site->price_per_adult, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                                    No site seeing details available
                                </td>
                            </tr>
                        @endforelse
                        @if ($quotation->siteSeeings->count() > 0)
                            <tr class="bg-gray-100">
                                <td colspan="3" class="px-4 py-3 text-right font-semibold">Total:</td>
                                <td class="px-4 py-3 text-center font-bold text-green-600">
                                    {{ number_format($quotation->siteSeeings->sum('price_per_adult'), 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between mt-6">
            <a href="{{ route('quotations.index') }}"
                class="bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600">⬅ Back to List</a>
            <button class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700">Download PDF</button>
        </div>
    </div>
</x-app-layout>
