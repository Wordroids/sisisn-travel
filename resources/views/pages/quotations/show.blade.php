<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
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
                        class="text-gray-800">{{ $quotation->markup_per_person }} ( USD )</span></p>
                <p><strong class="text-gray-600">Driver Name:</strong> <span
                        class="text-gray-800">{{ $quotation->driver->name ?? 'N/A' }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <strong class="text-gray-600">Driver Per Day Charge:</strong> <span
                        class="text-gray-800">{{ $quotation->driver->per_day_charge ?? 'N/A' }} ( LKR )</span>
                </p>
                <p><strong class="text-gray-600">Guide Name:</strong> <span
                        class="text-gray-800">{{ $quotation->guide->name ?? 'N/A' }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <strong class="text-gray-600">Guide Per Day Charge:</strong> <span
                        class="text-gray-800">{{ $quotation->guide->per_day_charge ?? 'N/A' }} ( LKR )</span>
                </p>


            </div>
        </div>

        <!-- Quotation Members Details -->
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Quotation Members Details</h3>
            @if($quotation->members && $quotation->members->count() > 0)
                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Phone</th>
                                <th class="px-4 py-3 text-left">WhatsApp</th>
                                <th class="px-4 py-3 text-left">Country</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($quotation->members as $index => $member)
                                <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $member->name }}</td>
                                    <td class="px-4 py-3">{{ $member->email ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $member->phone ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $member->whatsapp ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $member->country ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="mt-4 text-gray-500">No members have been added to this quotation yet.</p>
            @endif
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
                            <th class="px-4 py-3 text-center">Vehicle Payout Rate ( USD )</th>
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
                                    <th class="px-4 py-2 text-center">Total Cost ( USD )</th>
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

                    <!-- Driver & Guide Accommodation -->
                    <div class="overflow-x-auto">
                        <h4 class="font-semibold text-gray-800 py-4">{{ $accommodation->hotel->name }} - Driver & Guide
                            Accommodation</h4>
                        <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">Driver/Guide</th>
                                    <th class="px-4 py-2 text-center">Per Night Cost</th>
                                    <th class="px-4 py-2 text-center">Nights</th>
                                    <th class="px-4 py-2 text-center">Provided By Hotel</th>
                                    <th class="px-4 py-2 text-center">Total Cost ( LKR )</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($accommodation->additionalRooms as $detail)
                                    <tr class="hover:bg-gray-100 transition">
                                        <td class="px-4 py-2">{{ ucfirst($detail->room_type) }}</td>
                                        <td class="px-4 py-2 text-center">
                                            {{ number_format($detail->per_night_cost, 2) }}</td>
                                        <td class="px-4 py-2 text-center">{{ $detail->nights }}</td>
                                        <td class="px-4 py-2 text-center">
                                            {{ $detail->provided_by_hotel ? 'Yes' : 'No' }}</td>
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

        <!-- Add this section after the Site Seeing Details and before Quote Simulation -->
        <div class="grid grid-cols-2 gap-6 bg-white p-6 rounded-lg shadow-sm mt-6 items-start">
            <!-- Driver's Accommodation & Fees -->
            <div class="overflow-x-auto">
                <h4 class="font-semibold text-gray-800 mb-3">DRIVER'S ACCOMMODATION</h4>
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2 text-center">No of Days</th>
                            <th class="px-4 py-2 text-center">Per Day Rate (Rs.)</th>
                            <th class="px-4 py-2 text-center">Total (Rs.)</th>
                            <th class="px-4 py-2 text-center">Total (US$)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="px-4 py-2">Driver</td>
                            <td class="px-4 py-2 text-center">{{ $quotation->duration }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->driver->per_day_charge ?? 0, 2) }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->duration * ($quotation->driver->per_day_charge ?? 0), 2) }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format(($quotation->duration * ($quotation->driver->per_day_charge ?? 0)) / $quotation->conversion_rate, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">Accommodation</td>
                            <td class="px-4 py-2 text-center">
                                {{ $quotation->accommodations->flatMap->additionalRooms->where('room_type', 'driver')->sum('nights') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->accommodations->flatMap->additionalRooms->where('room_type', 'driver')->avg('per_night_cost'), 2) }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->accommodations->flatMap->additionalRooms->where('room_type', 'driver')->sum('total_cost'), 2) }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->accommodations->flatMap->additionalRooms->where('room_type', 'driver')->sum('total_cost') / $quotation->conversion_rate, 2) }}
                            </td>
                        </tr>
                        <tr class="bg-gray-100 font-bold">
                            <td class="px-4 py-2">Total</td>
                            <td colspan="2"></td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format(
                                    $quotation->duration * ($quotation->driver->per_day_charge ?? 0) +
                                        $quotation->accommodations->flatMap->additionalRooms->where('room_type', 'driver')->sum('total_cost'),
                                    2,
                                ) }}
                            </td>
                            <td class="px-4 py-2 text-center text-green-600">
                                {{ number_format(
                                    ($quotation->duration * ($quotation->driver->per_day_charge ?? 0) +
                                        $quotation->accommodations->flatMap->additionalRooms->where('room_type', 'driver')->sum('total_cost')) /
                                        $quotation->conversion_rate,
                                    2,
                                ) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Guide's Accommodation & Fees -->
            <div class="overflow-x-auto">
                <h4 class="font-semibold text-gray-800 mb-3">PROFESSIONAL GUIDE FEE</h4>
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2 text-center">No of Days</th>
                            <th class="px-4 py-2 text-center">Per Day Rate (Rs.)</th>
                            <th class="px-4 py-2 text-center">Total (Rs.)</th>
                            <th class="px-4 py-2 text-center">Total (US$)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="px-4 py-2">Guide Fee</td>
                            <td class="px-4 py-2 text-center">{{ $quotation->duration }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->guide->per_day_charge ?? 0, 2) }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->duration * ($quotation->guide->per_day_charge ?? 0), 2) }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format(($quotation->duration * ($quotation->guide->per_day_charge ?? 0)) / $quotation->conversion_rate, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">Guide Accommodation</td>
                            <td class="px-4 py-2 text-center">
                                {{ $quotation->accommodations->flatMap->additionalRooms->where('room_type', 'guide')->sum('nights') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->accommodations->flatMap->additionalRooms->where('room_type', 'guide')->avg('per_night_cost'), 2) }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->accommodations->flatMap->additionalRooms->where('room_type', 'guide')->sum('total_cost'), 2) }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($quotation->accommodations->flatMap->additionalRooms->where('room_type', 'guide')->sum('total_cost') / $quotation->conversion_rate, 2) }}
                            </td>
                        </tr>
                        <tr class="bg-gray-100 font-bold">
                            <td class="px-4 py-2">Total</td>
                            <td colspan="2"></td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format(
                                    $quotation->duration * ($quotation->guide->per_day_charge ?? 0) +
                                        $quotation->accommodations->flatMap->additionalRooms->where('room_type', 'guide')->sum('total_cost'),
                                    2,
                                ) }}
                            </td>
                            <td class="px-4 py-2 text-center text-green-600">
                                {{ number_format(
                                    ($quotation->duration * ($quotation->guide->per_day_charge ?? 0) +
                                        $quotation->accommodations->flatMap->additionalRooms->where('room_type', 'guide')->sum('total_cost')) /
                                        $quotation->conversion_rate,
                                    2,
                                ) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                                <td class="px-4 py-3 text-center font-semibold text-red-500">
                                    {{ $travelPlan->mileage }}
                                </td>

                            </tr>
                            <tr class="bg-gray-100">
                                <td colspan="3" class="px-4 py-3 text-right font-semibold">Total Mileage:</td>
                                <td class="px-4 py-3 text-center font-bold text-red-600">
                                    {{ $quotation->travelPlans->sum('mileage') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Site Seeing Details -->
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
            <!-- Sites Section -->
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Site Seeing Details</h3>
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow mb-6">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Site Name</th>
                            <th class="px-4 py-3 text-center">Unit Price ( USD )</th>
                            <th class="px-4 py-3 text-center">Quantity</th>
                            <th class="px-4 py-3 text-center">Price Per Adult ( USD )</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($quotation->siteSeeings->where('type', 'site') as $site)
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
                                    No sites available
                                </td>
                            </tr>
                        @endforelse
                        @if ($quotation->siteSeeings->where('type', 'site')->count() > 0)
                            <tr class="bg-gray-100">
                                <td colspan="3" class="px-4 py-3 text-right font-semibold">Total Sites:</td>
                                <td class="px-4 py-3 text-center font-bold text-green-600">
                                    {{ number_format($quotation->siteSeeings->where('type', 'site')->sum('price_per_adult'), 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Site Extras Section -->
                <h4 class="text-lg font-semibold text-gray-700 border-b pb-2 mt-6">Site Extras</h4>
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow mt-4">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Extra Name</th>
                            <th class="px-4 py-3 text-center">Unit Price ( USD )</th>
                            <th class="px-4 py-3 text-center">Quantity</th>
                            <th class="px-4 py-3 text-center">Price Per Adult ( USD )</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($quotation->siteSeeings->where('type', 'extra') as $extra)
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-4 py-3">{{ $extra->name }}</td>
                                <td class="px-4 py-3 text-center">{{ number_format($extra->unit_price, 2) }}</td>
                                <td class="px-4 py-3 text-center">{{ $extra->quantity }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600">
                                    {{ number_format($extra->price_per_adult, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                                    No site extras available
                                </td>
                            </tr>
                        @endforelse
                        @if ($quotation->siteSeeings->where('type', 'extra')->count() > 0)
                            <tr class="bg-gray-100">
                                <td colspan="3" class="px-4 py-3 text-right font-semibold">Total Extras:</td>
                                <td class="px-4 py-3 text-center font-bold text-green-600">
                                    {{ number_format($quotation->siteSeeings->where('type', 'extra')->sum('price_per_adult'), 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Combined Total -->
                @if ($quotation->siteSeeings->count() > 0)
                    <div class="mt-4 text-right">
                        <span class="text-lg font-bold">Grand Total: </span>
                        <span class="text-lg font-bold text-green-600">
                            {{ number_format($quotation->siteSeeings->sum('price_per_adult'), 2) }} USD
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quotation Extras -->
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Quotation Extras</h3>
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Description</th>
                            <th class="px-4 py-3 text-center">Unit Price (USD)</th>
                            <th class="px-4 py-3 text-center">Quantity Per Pax</th>
                            <th class="px-4 py-3 text-center">Total Price (USD)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($quotation->extras as $extra)
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-4 py-3">{{ $extra->date->format('Y-m-d') }}</td>
                                <td class="px-4 py-3">{{ $extra->description }}</td>
                                <td class="px-4 py-3 text-center">{{ number_format($extra->unit_price, 2) }}</td>
                                <td class="px-4 py-3 text-center">{{ $extra->quantity_per_pax }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600">
                                    {{ number_format($extra->total_price, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                                    No extras available
                                </td>
                            </tr>
                        @endforelse
                        @if ($quotation->extras->count() > 0)
                            <tr class="bg-gray-100">
                                <td colspan="4" class="px-4 py-3 text-right font-semibold">Total:</td>
                                <td class="px-4 py-3 text-center font-bold text-green-600">
                                    {{ number_format($quotation->extras->sum('total_price'), 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add this before the Quote Simulation section -->
        @if ($quotation->jeepCharges->count() > 0)
            <!-- Jeep Charges -->
            <!-- Jeep Charges -->
            <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Jeep Charges</h3>

                <!-- Global Jeep Charges -->
                @if ($quotation->jeepCharges->where('travel_plan_id', null)->count() > 0)
                    <div class="mt-4">
                        <h4 class="font-medium text-gray-800 mb-2">Global Jeep Charges</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                                <thead class="bg-gray-200 text-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Pax Range</th>
                                        <th class="px-4 py-3 text-center">Unit Price (USD)</th>
                                        <th class="px-4 py-3 text-center">Quantity</th>
                                        <th class="px-4 py-3 text-center">Total Price (USD)</th>
                                        <th class="px-4 py-3 text-center">Per Person (USD)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach ($quotation->jeepCharges->where('travel_plan_id', null) as $charge)
                                        <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                            <td class="px-4 py-3">{{ $charge->pax_range }}</td>
                                            <td class="px-4 py-3 text-center">
                                                {{ number_format($charge->unit_price, 2) }}</td>
                                            <td class="px-4 py-3 text-center">{{ $charge->quantity }}</td>
                                            <td class="px-4 py-3 text-center">
                                                {{ number_format($charge->total_price, 2) }}</td>
                                            <td class="px-4 py-3 text-center font-semibold text-green-600">
                                                {{ number_format($charge->per_person, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Route-specific Jeep Charges -->
                @if ($quotation->jeepCharges->where('travel_plan_id', '!=', null)->count() > 0)
                    <div class="mt-6">
                        <h4 class="font-medium text-gray-800 mb-2">Route-specific Jeep Charges</h4>

                        @foreach ($quotation->travelPlans as $travelPlan)
                            @php
                                $routeJeepCharges = $quotation->jeepCharges->where('travel_plan_id', $travelPlan->id);
                            @endphp

                            @if ($routeJeepCharges->count() > 0)
                                <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                                    <h5 class="font-medium text-gray-700 mb-2">Route: {{ $travelPlan->route->name }}
                                        <span class="text-sm text-gray-500">({{ $travelPlan->start_date }} to
                                            {{ $travelPlan->end_date }})</span>
                                    </h5>

                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                                            <thead class="bg-gray-200 text-gray-700">
                                                <tr>
                                                    <th class="px-4 py-2 text-left">Pax Range</th>
                                                    <th class="px-4 py-2 text-center">Unit Price (USD)</th>
                                                    <th class="px-4 py-2 text-center">Quantity</th>
                                                    <th class="px-4 py-2 text-center">Total Price (USD)</th>
                                                    <th class="px-4 py-2 text-center">Per Person (USD)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y">
                                                @foreach ($routeJeepCharges as $charge)
                                                    <tr class="hover:bg-gray-100 transition">
                                                        <td class="px-4 py-2">{{ $charge->pax_range }}</td>
                                                        <td class="px-4 py-2 text-center">
                                                            {{ number_format($charge->unit_price, 2) }}</td>
                                                        <td class="px-4 py-2 text-center">{{ $charge->quantity }}</td>
                                                        <td class="px-4 py-2 text-center">
                                                            {{ number_format($charge->total_price, 2) }}</td>
                                                        <td class="px-4 py-2 text-center font-semibold text-green-600">
                                                            {{ number_format($charge->per_person, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($quotation->jeepCharges->count() === 0)
                    <div class="mt-4 text-center text-gray-500 py-4">
                        No jeep charges have been added to this quotation.
                    </div>
                @endif
            </div>
        @endif

        <!-- Quote Simulation -->
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Quote Simulation - Per Person / Double
                Sharing
                Basis</h3>
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700 border rounded-lg shadow">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Pax Range</th>
                            <th class="px-4 py-3 text-center">Accommodation 1/2 DBL</th>
                            <th class="px-4 py-3 text-center">Transport</th>
                            <th class="px-4 py-3 text-center">Chauffuer / Cleaner</th>
                            <th class="px-4 py-3 text-center">Guide</th>
                            <th class="px-4 py-3 text-center">Sites</th>
                            <th class="px-4 py-3 text-center">Jeep Charges</th>
                            <th class="px-4 py-3 text-center">Extras</th>
                            <th class="px-4 py-3 text-center">Total (US$)</th>
                            <th class="px-4 py-3 text-center">Total Ex. VAT (US$)</th>
                            <th class="px-4 py-3 text-center">Mark Up (US$)</th>
                            <th class="px-4 py-3 text-center">Nett</th>
                            <th class="px-4 py-3 text-center">Round Up</th>
                        </tr>
                    </thead>
                    @php
                        // Pre-calculate common values
                        $conversionRate = $quotation->conversion_rate;
                        $duration = $quotation->duration;

                        // Accommodation calculations
                        $doubleAccommodationTotal = $quotation->accommodations->sum(function ($acc) {
                            return $acc->roomDetails->where('room_type', 'double')->sum('total_cost');
                        });

                        // Driver calculations
                        $driverDailyCharge = $quotation->driver->per_day_charge ?? 0;
                        $driverAccommodation = $quotation->accommodations->flatMap->additionalRooms
                            ->where('room_type', 'driver')
                            ->sum('total_cost');

                        // Guide calculations
                        $guideDailyCharge = $quotation->guide->per_day_charge ?? 0;
                        $guideAccommodation = $quotation->accommodations->flatMap->additionalRooms
                            ->where('room_type', 'guide')
                            ->sum('total_cost');

                        // Transport calculations
                        $totalMileage = $quotation->travelPlans->sum('mileage');

                        // Site seeing calculations
                        $sitesTotal = $quotation->siteSeeings->sum('price_per_adult');

                        //Extras calculations
                        $extrasTotal = $quotation->extras->sum('total_price');

                        // Build simulation rows
                        /*$simulationRows = [];
                        foreach ($quotation->paxSlabs as $paxSlab) {
                            $minPax = $paxSlab->paxSlab->min_pax;

                            // Get jeep charge for current pax range
                            $jeepCharge = $quotation->jeepCharges->where('pax_range', $paxSlab->paxSlab->name)->first();

                            $row = [
                                'pax_range' => $paxSlab->paxSlab->name,
                                'accommodation' => number_format($doubleAccommodationTotal / 2, 2),
                                'transport' => number_format(
                                    ($paxSlab->vehicle_payout_rate * $totalMileage)
/ $minPax / $conversionRate,
                                    2,
                                ),
                                'chauffeur' => number_format(
                                    ($duration * $driverDailyCharge + $driverAccommodation) / $conversionRate / $minPax,
                                    2,
                                ),
                                'guide' => number_format(
                                    ($duration * $guideDailyCharge + $guideAccommodation) / $conversionRate / $minPax,
                                    2,
                                ),
                                'sites' => number_format($sitesTotal, 2),
                                'jeep_charges' => $jeepCharge ? number_format($jeepCharge->per_person, 2) : '-',
                                'extras' => number_format($extrasTotal / $minPax, 2),
                            ];

                            // Calculate financials
                            $total =
                                $doubleAccommodationTotal / 2 +
                                ($paxSlab->vehicle_payout_rate * $totalMileage) / $minPax / $conversionRate +
                                ($duration * $driverDailyCharge + $driverAccommodation) / $conversionRate / $minPax +
                                ($duration * $guideDailyCharge + $guideAccommodation) / $conversionRate / $minPax +
                                $extrasTotal / $minPax +
                                $sitesTotal +
                                ($jeepCharge ? $jeepCharge->per_person : 0);

                            $totalExVat = $total / 1.18;
                            $markup = $quotation->markup_per_person;
                            $nett = ($totalExVat + $markup) * 1.18;

                            $row['total'] = number_format($total, 2);
                            $row['total_ex_vat'] = number_format($totalExVat, 2);
                            $row['markup'] = number_format($markup, 2);
                            $row['nett'] = number_format($nett, 2);
                            $row['roundup'] = number_format(ceil($nett), 2);

                            $simulationRows[] = $row;
                        }*/
                        // Build simulation rows
                        $simulationRows = [];
                        foreach ($quotation->paxSlabs as $paxSlab) {
                            $minPax = $paxSlab->paxSlab->min_pax;
                            $paxRange = $paxSlab->paxSlab->name;

                            // Get global jeep charge for current pax range
                            $globalJeepCharge = $quotation->jeepCharges
                                ->where('travel_plan_id', null)
                                ->where('pax_range', $paxRange)
                                ->first();

                            // Get route-specific jeep charges for current pax range
                            $routeJeepCharges = $quotation->jeepCharges
                                ->where('travel_plan_id', '!=', null)
                                ->where('pax_range', $paxRange);

                            // Calculate total jeep charges (global + route-specific)
                            $totalJeepCharges =
                                ($globalJeepCharge ? $globalJeepCharge->per_person : 0) +
                                $routeJeepCharges->sum('per_person');

                            $row = [
                                'pax_range' => $paxRange,
                                'accommodation' => number_format($doubleAccommodationTotal / 2, 2),
                                'transport' => number_format(
                                    ($paxSlab->vehicle_payout_rate * $totalMileage) / $minPax / $conversionRate,
                                    2,
                                ),
                                'chauffeur' => number_format(
                                    ($duration * $driverDailyCharge + $driverAccommodation) / $conversionRate / $minPax,
                                    2,
                                ),
                                'guide' => number_format(
                                    ($duration * $guideDailyCharge + $guideAccommodation) / $conversionRate / $minPax,
                                    2,
                                ),
                                'sites' => number_format($sitesTotal, 2),
                                'jeep_charges' => $totalJeepCharges > 0 ? number_format($totalJeepCharges, 2) : '-',
                                'extras' => number_format($extrasTotal / $minPax, 2),
                            ];

                            // Calculate financials
                            $total =
                                $doubleAccommodationTotal / 2 +
                                ($paxSlab->vehicle_payout_rate * $totalMileage) / $minPax / $conversionRate +
                                ($duration * $driverDailyCharge + $driverAccommodation) / $conversionRate / $minPax +
                                ($duration * $guideDailyCharge + $guideAccommodation) / $conversionRate / $minPax +
                                $extrasTotal / $minPax +
                                $sitesTotal +
                                $totalJeepCharges;

                            $totalExVat = $total / 1.18;
                            $markup = $quotation->markup_per_person;
                            $nett = ($totalExVat + $markup) * 1.18;

                            $row['total'] = number_format($total, 2);
                            $row['total_ex_vat'] = number_format($totalExVat, 2);
                            $row['markup'] = number_format($markup, 2);
                            $row['nett'] = number_format($nett, 2);
                            $row['roundup'] = number_format(ceil($nett), 2);

                            $simulationRows[] = $row;
                        }
                    @endphp
                    <tbody class="divide-y">
                        @foreach ($simulationRows as $row)
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-4 py-3">{{ $row['pax_range'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $row['accommodation'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $row['transport'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $row['chauffeur'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $row['guide'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $row['sites'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $row['jeep_charges'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $row['extras'] }}</td>
                                <td class="px-4 py-3 text-center font-semibold">{{ $row['total'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $row['total_ex_vat'] }}</td>
                                <td class="px-4 py-3 text-center text-blue-600">{{ $row['markup'] }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600">{{ $row['nett'] }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-red-600">{{ $row['roundup'] }}</td>
                            </tr>
                        @endforeach
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
