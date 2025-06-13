<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                Edit Hotel Voucher - {{ $hotel->name }}
            </h2>
            <a href="{{ route('group_quotations.hotel_vouchers', $quotation->id) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                Back to Hotels
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h4 class="text-base font-semibold text-center mt-4">HOTEL RESERVATION VOUCHER AMENDMENT 2</h4>
            </div>

            <form
                action="{{ route('hotel_voucher.store_amendment2', ['quotation' => $quotation->id, 'hotel' => $hotel->id]) }}"
                method="POST">
                @csrf
                <div class="px-4 py-5 sm:p-6">
                    <!-- Tour Information -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-3">Tour Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tour No</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $quotation->template->booking_reference }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tour Name</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $quotation->name }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Market</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $quotation->market ? $quotation->market->name : 'N/A' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Booking Name</label>
                                <input type="text" name="booking_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ $quotation->name }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Voucher Date</label>
                                <input type="date" name="voucher_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column - Hotel and Stay Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">Hotel Information</h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hotel Name</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $hotel->name }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="hotel_address" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $hotel->location ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Arrival Date</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        @php
                                            // Get earliest arrival date from all related accommodations
                                            $earliestDate = $relatedAccommodations->min('start_date');
                                            $arrivalDate = $earliestDate ? $earliestDate : $accommodation->start_date;

                                            // Calculate total nights
                                            $latestDate = $relatedAccommodations->max('end_date');
                                            $departureDate = $latestDate ? $latestDate : $accommodation->end_date;
                                            $totalNights = $arrivalDate->diffInDays($departureDate);
                                        @endphp
                                        {{ $arrivalDate->format('d/m/Y') }}
                                        <input type="hidden" name="arrival_date"
                                            value="{{ $arrivalDate->format('Y-m-d') }}">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Departure Date</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $departureDate->format('d/m/Y') }}
                                        <input type="hidden" name="departure_date"
                                            value="{{ $departureDate->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Nights</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $totalNights }}
                                        <input type="hidden" name="total_nights" value="{{ $totalNights }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Room Category</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $roomCategory }}
                                    </div>
                                    <input type="hidden" name="room_category" value="{{ $roomCategory }}">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Meal Plan</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $mealPlan }}
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Room Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">Room Information</h4>

                            <!-- Room counts -->
                            <div class="grid grid-cols-5 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Single</label>
                                    <input type="number" name="room_counts[single]" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center"
                                        value="{{ $roomCounts['single'] ?? 0 }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Double</label>
                                    <input type="number" name="room_counts[double]" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center"
                                        value="{{ $roomCounts['double'] ?? 0 }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Twin</label>
                                    <input type="number" name="room_counts[twin]" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center"
                                        value="{{ $roomCounts['twin'] ?? 0 }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Triple</label>
                                    <input type="number" name="room_counts[triple]" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center"
                                        value="{{ $roomCounts['triple'] ?? 0 }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Guide</label>
                                    <input type="number" name="room_counts[guide]" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center"
                                        value="{{ $roomCounts['guide'] ?? 0 }}">
                                </div>
                            </div>

                            <!-- Meal plan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Selected Meal Plan</label>
                                <select name="meal_plan"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="BB" {{ $mealPlan == 'BB' ? 'selected' : '' }}>Bed & Breakfast
                                        (BB)</option>
                                    <option value="HB" {{ $mealPlan == 'HB' ? 'selected' : '' }}>Half Board (HB)
                                    </option>
                                    <option value="FB" {{ $mealPlan == 'FB' ? 'selected' : '' }}>Full Board (FB)
                                    </option>
                                    <option value="AI" {{ $mealPlan == 'AI' ? 'selected' : '' }}>All Inclusive
                                        (AI)</option>
                                    <option value="RO" {{ $mealPlan == 'RO' ? 'selected' : '' }}>Room Only (RO)
                                    </option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. of Adults</label>
                                    <input type="number" name="adults"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        value="{{ $adults }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. of Children</label>
                                    <input type="number" name="children"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        value="{{ $children ?? 0 }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Daily Room Information Section -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h4 class="text-md font-medium text-gray-700 mb-4">Daily Room Details</h4>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            SGL</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            DBL</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            TWIN</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            TPL</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No of Pax</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Meal Plan</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Guide Room/Basis</th>
                                        <th class="px-3 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="dailyRoomTable">
                                    @if (isset($dailyRooms) && count($dailyRooms) > 0)
                                        @foreach ($dailyRooms as $index => $room)
                                            <tr>
                                                <td class="px-3 py-2">
                                                    <input type="date"
                                                        name="daily_rooms[{{ $index }}][date]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $room['date'] ?? '' }}">
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="number" min="0"
                                                        name="daily_rooms[{{ $index }}][single]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $room['single'] ?? 0 }}">
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="number" min="0"
                                                        name="daily_rooms[{{ $index }}][double]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $room['double'] ?? 0 }}">
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="number" min="0"
                                                        name="daily_rooms[{{ $index }}][twin]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $room['twin'] ?? 0 }}">
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="number" min="0"
                                                        name="daily_rooms[{{ $index }}][triple]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $room['triple'] ?? 0 }}">
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="number" min="0"
                                                        name="daily_rooms[{{ $index }}][pax]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $room['pax'] ?? 0 }}">
                                                </td>
                                                <td class="px-3 py-2">
                                                    <select name="daily_rooms[{{ $index }}][meal_plan]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                                        <option value="BB"
                                                            {{ isset($room['meal_plan']) && $room['meal_plan'] == 'BB' ? 'selected' : '' }}>
                                                            BB</option>
                                                        <option value="HB"
                                                            {{ isset($room['meal_plan']) && $room['meal_plan'] == 'HB' ? 'selected' : '' }}>
                                                            HB</option>
                                                        <option value="FB"
                                                            {{ isset($room['meal_plan']) && $room['meal_plan'] == 'FB' ? 'selected' : '' }}>
                                                            FB</option>
                                                        <option value="AI"
                                                            {{ isset($room['meal_plan']) && $room['meal_plan'] == 'AI' ? 'selected' : '' }}>
                                                            AI</option>
                                                        <option value="RO"
                                                            {{ isset($room['meal_plan']) && $room['meal_plan'] == 'RO' ? 'selected' : '' }}>
                                                            RO</option>
                                                    </select>
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="text"
                                                        name="daily_rooms[{{ $index }}][guide_room]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $room['guide_room'] ?? '' }}">
                                                </td>
                                                <td class="px-3 py-2 text-right">
                                                    <button type="button" class="text-red-600 hover:text-red-800"
                                                        onclick="removeDailyRoomRow(this)">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-3 py-2">
                                                <input type="date" name="daily_rooms[0][date]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" min="0" name="daily_rooms[0][single]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                    value="0">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" min="0" name="daily_rooms[0][double]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                    value="0">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" min="0" name="daily_rooms[0][twin]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                    value="0">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" min="0" name="daily_rooms[0][triple]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                    value="0">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" min="0" name="daily_rooms[0][pax]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                    value="0">
                                            </td>
                                            <td class="px-3 py-2">
                                                <select name="daily_rooms[0][meal_plan]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                                    <option value="BB">BB</option>
                                                    <option value="HB" selected>HB</option>
                                                    <option value="FB">FB</option>
                                                    <option value="AI">AI</option>
                                                    <option value="RO">RO</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" name="daily_rooms[0][guide_room]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                            </td>
                                            <td class="px-3 py-2 text-right">
                                                <button type="button" class="text-red-600 hover:text-red-800"
                                                    onclick="removeDailyRoomRow(this)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <button type="button" id="addDailyRoomRow"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Daily Room
                            </button>
                        </div>
                    </div>

                    <!-- Rooming List Section -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-md font-medium text-gray-700">ROOMING LIST</h4>

                            @if (isset($availableMembers) && count($availableMembers) > 0)
                                <div class="flex items-center">
                                    <select id="memberSelect"
                                        class="mr-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Select Group Member</option>
                                        @foreach ($availableMembers as $member)
                                            <option value="{{ $member->id }}"
                                                data-name="{{ $member->name ?? 'Member #' . $member->id }}"
                                                data-arrival="{{ $accommodation->start_date->format('Y-m-d') }}"
                                                data-departure="{{ $accommodation->end_date->format('Y-m-d') }}"
                                                data-remarks="{{ $member->member_group == 'honeymoon' ? 'HONEYMOONERS' : '' }}">
                                                {{ $member->name ?? 'Member #' . $member->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="addSelectedMember"
                                        class="inline-flex items-center px-3 py-2 border border-green-700 text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add to List
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Guest Name</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Arrival Date</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Departure Date</th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Remarks</th>
                                        <th class="px-3 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="roomingListTable">
                                    @if (isset($roomingList) && count($roomingList) > 0)
                                        @foreach ($roomingList as $index => $guest)
                                            <tr>
                                                <td
                                                    class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $index + 1 }}</td>
                                                <td class="px-3 py-2">
                                                    <textarea name="rooming_list[{{ $index }}][guest_name]" rows="2"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">{{ $guest['guest_name'] ?? '' }}</textarea>
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="date"
                                                        name="rooming_list[{{ $index }}][arrival_date]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $guest['arrival_date'] ?? '' }}">
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="date"
                                                        name="rooming_list[{{ $index }}][departure_date]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $guest['departure_date'] ?? '' }}">
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="text"
                                                        name="rooming_list[{{ $index }}][remarks]"
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                                        value="{{ $guest['remarks'] ?? '' }}">
                                                </td>
                                                <td class="px-3 py-2 text-right">
                                                    <button type="button" class="text-red-600 hover:text-red-800"
                                                        onclick="removeRoomingRow(this)">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">1
                                            </td>
                                            <td class="px-3 py-2">
                                                <textarea name="rooming_list[0][guest_name]" rows="2"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"></textarea>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="date" name="rooming_list[0][arrival_date]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="date" name="rooming_list[0][departure_date]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" name="rooming_list[0][remarks]"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                            </td>
                                            <td class="px-3 py-2 text-right">
                                                <button type="button" class="text-red-600 hover:text-red-800"
                                                    onclick="removeRoomingRow(this)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <button type="button" id="addGuestRow"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Guest
                            </button>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="mt-8 space-y-4 border-t border-gray-200 pt-6">
                        <h4 class="text-md font-medium text-gray-700">Additional Information</h4>

                        <div>
                            <label for="special_notes" class="block text-sm font-medium text-gray-700">Special
                                Notes</label>
                            <textarea id="special_notes" name="special_notes" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $specialNotes ?? '-' }}</textarea>
                        </div>

                        <div>
                            <label for="billing_instructions" class="block text-sm font-medium text-gray-700">Billing
                                Instructions</label>
                            <textarea id="billing_instructions" name="billing_instructions" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $billingInstructions ?? 'Extras to be collected from client directly.' }}</textarea>
                        </div>

                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea id="remarks" name="remarks" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $remarks ??
                                    'HB SGL USD 85, HB DBL USD 90, HB TPL USD 130 (Reservation Code – ST2025)
                                GUIDE – (1ST NIGHT – FB / 2ND & 3RD NIGHT – HB) USD 55' }}</textarea>
                        </div>

                        <div>
                            <label for="reservation_note" class="block text-sm font-medium text-gray-700">Reservation
                                Note</label>
                            <textarea id="reservation_note" name="reservation_note" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $reservationNote ??
                                    'Please reserve and confirm the above arrangements. Client will arrive for the given meal against the day.
                                Please return duplicate duly singed as confirmation, and triplicate along with your bill.' }}</textarea>
                        </div>

                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700">Contact
                                Person</label>
                            <input type="text" id="contact_person" name="contact_person"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ $contactPerson ?? 'Nethini Guruge - 0777343748' }}">
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Generate Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission handling
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                // Prevent double submission
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = 'Generating...';
            });

            // Add Guest Row
            const addGuestRow = document.getElementById('addGuestRow');
            addGuestRow.addEventListener('click', function() {
                const tableBody = document.getElementById('roomingListTable');
                const rowCount = tableBody.rows.length;
                const row = tableBody.insertRow();

                const newIndex = rowCount;

                row.innerHTML = `
                    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">${rowCount + 1}</td>
                    <td class="px-3 py-2">
                        <textarea name="rooming_list[${newIndex}][guest_name]" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"></textarea>
                    </td>
                    <td class="px-3 py-2">
                        <input type="date" name="rooming_list[${newIndex}][arrival_date]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    </td>
                    <td class="px-3 py-2">
                        <input type="date" name="rooming_list[${newIndex}][departure_date]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    </td>
                    <td class="px-3 py-2">
                        <input type="text" name="rooming_list[${newIndex}][remarks]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    </td>
                    <td class="px-3 py-2 text-right">
                        <button type="button" class="text-red-600 hover:text-red-800" onclick="removeRoomingRow(this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </td>
                `;
            });

            // Add Daily Room Row
            const addDailyRoomRow = document.getElementById('addDailyRoomRow');
            addDailyRoomRow.addEventListener('click', function() {
                const tableBody = document.getElementById('dailyRoomTable');
                const rowCount = tableBody.rows.length;
                const row = tableBody.insertRow();

                const newIndex = rowCount;

                row.innerHTML = `
                    <td class="px-3 py-2">
                        <input type="date" name="daily_rooms[${newIndex}][date]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    </td>
                    <td class="px-3 py-2">
                        <input type="number" min="0" name="daily_rooms[${newIndex}][single]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="0">
                    </td>
                    <td class="px-3 py-2">
                        <input type="number" min="0" name="daily_rooms[${newIndex}][double]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="0">
                    </td>
                    <td class="px-3 py-2">
                        <input type="number" min="0" name="daily_rooms[${newIndex}][twin]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="0">
                    </td>
                    <td class="px-3 py-2">
                        <input type="number" min="0" name="daily_rooms[${newIndex}][triple]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="0">
                    </td>
                    <td class="px-3 py-2">
                        <input type="number" min="0" name="daily_rooms[${newIndex}][pax]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="0">
                    </td>
                    <td class="px-3 py-2">
                        <select name="daily_rooms[${newIndex}][meal_plan]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                            <option value="BB">BB</option>
                            <option value="HB" selected>HB</option>
                            <option value="FB">FB</option>
                            <option value="AI">AI</option>
                            <option value="RO">RO</option>
                        </select>
                    </td>
                    <td class="px-3 py-2">
                        <input type="text" name="daily_rooms[${newIndex}][guide_room]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    </td>
                    <td class="px-3 py-2 text-right">
                        <button type="button" class="text-red-600 hover:text-red-800" onclick="removeDailyRoomRow(this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </td>
                `;
            });

            // Member selection functionality for Rooming List
            const addSelectedMemberBtn = document.getElementById('addSelectedMember');
            if (addSelectedMemberBtn) {
                addSelectedMemberBtn.addEventListener('click', function() {
                    const memberSelect = document.getElementById('memberSelect');
                    const selectedOption = memberSelect.options[memberSelect.selectedIndex];

                    if (memberSelect.value) {
                        const tableBody = document.getElementById('roomingListTable');
                        const rowCount = tableBody.rows.length;
                        const row = tableBody.insertRow();
                        const newIndex = rowCount;

                        // Get the selected member data
                        const memberName = selectedOption.dataset.name;
                        const arrivalDate = selectedOption.dataset.arrival;
                        const departureDate = selectedOption.dataset.departure;
                        const remarks = selectedOption.dataset.remarks;

                        row.innerHTML = `
                            <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">${rowCount + 1}</td>
                            <td class="px-3 py-2">
                                <textarea name="rooming_list[${newIndex}][guest_name]" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">${memberName}</textarea>
                            </td>
                            <td class="px-3 py-2">
                                <input type="date" name="rooming_list[${newIndex}][arrival_date]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="${arrivalDate}">
                            </td>
                            <td class="px-3 py-2">
                                <input type="date" name="rooming_list[${newIndex}][departure_date]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="${departureDate}">
                            </td>
                            <td class="px-3 py-2">
                                <input type="text" name="rooming_list[${newIndex}][remarks]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="${remarks}">
                            </td>
                            <td class="px-3 py-2 text-right">
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="removeRoomingRow(this)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </td>
                        `;

                        // Reset the select
                        memberSelect.selectedIndex = 0;
                    }
                });
            }
        });

        // Remove rooming list row
        function removeRoomingRow(button) {
            const row = button.closest('tr');
            row.remove();

            // Renumber the rows
            const rows = document.getElementById('roomingListTable').rows;
            for (let i = 0; i < rows.length; i++) {
                rows[i].cells[0].textContent = (i + 1);
            }
        }

        // Remove daily room row
        function removeDailyRoomRow(button) {
            const row = button.closest('tr');
            row.remove();
        }
    </script>
</x-app-layout>
