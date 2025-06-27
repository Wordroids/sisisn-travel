<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ isset($mealVoucher->id) ? 'Edit' : 'Create' }} Meal Voucher
                        </h2>
                        <a href="{{ route('meal_vouchers.index', $mainRef) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Back to Meal Vouchers
                        </a>
                    </div>

                    @if (isset($subTours) && $subTours->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-800 mb-3">Available Tours</h3>
                            <div class="overflow-x-auto bg-gray-50 rounded-lg border">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tour No</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Guest Name</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tour Dates</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Pax</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($subTours as $subTour)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $subTour->booking_reference }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $subTour->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if ($subTour->start_date)
                                                        {{ $subTour->start_date->format('d M Y') }} -
                                                        {{ $subTour->end_date ? $subTour->end_date->format('d M Y') : 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $subTour->paxSlab ? $subTour->paxSlab->name : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <button type="button"
                                                        onclick="addTourToSelection('{{ $subTour->booking_reference }}', '{{ $subTour->name }}')"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        Add
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if (isset($mealVoucher->id))
    <form action="{{ route('meal_vouchers.update', ['main_ref' => $mainRef, 'id' => $mealVoucher->id]) }}"
        method="POST" class="space-y-6">
        @method('PUT')
@else
    <form action="{{ route('meal_vouchers.store', $mainRef) }}" method="POST"
        class="space-y-6">
@endif
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Basic Voucher Info -->
                        <div>
                            <label for="voucher_date" class="block text-sm font-medium text-gray-700">Voucher
                                Date</label>
                            <input type="date" name="voucher_date" id="voucher_date"
                                value="{{ old('voucher_date', isset($mealVoucher->voucher_date) ? $mealVoucher->voucher_date->format('Y-m-d') : date('Y-m-d')) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="hotel_id" class="block text-sm font-medium text-gray-700">Hotel</label>
                            <select name="hotel_id" id="hotel_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                onchange="updateHotelName()">
                                <option value="">Select Hotel</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" data-name="{{ $hotel->name }}"
                                        {{ old('hotel_id', $mealVoucher->hotel_id ?? '') == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }} - {{ $hotel->location }} ({{ $hotel->star_rating }}★)
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="hotel_name" id="hotel_name"
                                value="{{ old('hotel_name', $mealVoucher->hotel_name ?? '') }}">
                        </div>

                        <div>
                            <label for="meal_plan" class="block text-sm font-medium text-gray-700">Meal Plan</label>
                            <select name="meal_plan" id="meal_plan"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="BREAKFAST"
                                    {{ old('meal_plan', $mealVoucher->meal_plan ?? '') == 'BREAKFAST' ? 'selected' : '' }}>
                                    BREAKFAST</option>
                                <option value="LUNCH"
                                    {{ old('meal_plan', $mealVoucher->meal_plan ?? '') == 'LUNCH' ? 'selected' : '' }}>
                                    LUNCH</option>
                                <option value="DINNER"
                                    {{ old('meal_plan', $mealVoucher->meal_plan ?? '') == 'DINNER' ? 'selected' : '' }}>
                                    DINNER</option>
                            </select>
                        </div>

                        <div>
                            <label for="market" class="block text-sm font-medium text-gray-700">Market</label>
                            <select name="market" id="market"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Market</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->name }}"
                                        {{ old('market', $mealVoucher->market ?? '') == $market->name ? 'selected' : '' }}>
                                        {{ $market->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700">Contact
                                Person</label>
                            <input type="text" name="contact_person" id="contact_person"
                                value="{{ old('contact_person', $mealVoucher->contact_person ?? '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Selected Tours Table -->
                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-medium text-gray-800">Selected Tours</h3>
                        </div>
                        <div class="overflow-x-auto bg-gray-50 rounded-lg border">
                            <table class="min-w-full divide-y divide-gray-200" id="selectedToursTable">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tour No</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Guest Name</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            colspan="2">Guide Details</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="selectedToursBody">
                                    <tr id="noToursRow">
                                        <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500">No
                                            tours selected yet</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Store the tour data as JSON -->
                    <input type="hidden" name="selected_tours_data" id="selected_tours_data"
                        value="{{ old('selected_tours_data', $mealVoucher->selected_tours_data ?? '') }}">

                    <!-- Special Notes, Billing Instructions, etc. -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div>
                            <label for="special_notes" class="block text-sm font-medium text-gray-700">Special
                                Notes</label>
                            <textarea name="special_notes" id="special_notes" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('special_notes', $mealVoucher->special_notes ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="billing_instructions" class="block text-sm font-medium text-gray-700">Billing
                                Instructions</label>
                            <textarea name="billing_instructions" id="billing_instructions" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('billing_instructions', $mealVoucher->billing_instructions ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('remarks', $mealVoucher->remarks ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="reservation_note" class="block text-sm font-medium text-gray-700">Reservation
                                Note</label>
                            <textarea name="reservation_note" id="reservation_note" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('reservation_note', $mealVoucher->reservation_note ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ isset($mealVoucher->id) ? 'Update' : 'Create' }} Meal Voucher
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Object to track selected tours and their meal dates
    const selectedTours = {};
    let rowCounter = 0;
    let mealDateCounter = 0;

    // Initialize from existing data if available
    document.addEventListener('DOMContentLoaded', function() {
        // Make sure the hotel name is updated when the page loads
        updateHotelName();
        
        const existingData = document.getElementById('selected_tours_data').value;
        if (existingData && existingData.trim() !== '') {
            try {
                const parsedData = JSON.parse(existingData);
                Object.assign(selectedTours, parsedData);

                // Find the highest mealDateCounter
                Object.keys(selectedTours).forEach(tourNo => {
                    if (selectedTours[tourNo].mealDates) {
                        selectedTours[tourNo].mealDates.forEach(date => {
                            const id = parseInt(date.id.split('_')[2] || 0);
                            mealDateCounter = Math.max(mealDateCounter, id + 1);
                        });
                    }
                });

                rowCounter = Object.keys(selectedTours).length;
                updateSelectedToursTable();
            } catch (e) {
                console.error("Error parsing existing tour data", e);
            }
        }
    });

    function updateHotelName() {
        const selectElement = document.getElementById('hotel_id');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        
        if (selectedOption && selectedOption.value) {
            document.getElementById('hotel_name').value = selectedOption.dataset.name;
        } else {
            document.getElementById('hotel_name').value = '';
        }
    }

    function addTourToSelection(tourNo, guestName) {
        // Always add the tour, even if it exists (this allows multiple entries for the same tour)
        // Check if this tour already exists
        if (!selectedTours[tourNo]) {
            selectedTours[tourNo] = {
                tourNo: tourNo,
                guestName: guestName,
                guideDetails: '',
                remarks: '',
                mealDates: []
            };

            // Add first meal date entry by default
            addMealDateToTour(tourNo);
            
            updateSelectedToursTable();

            // Highlight the newly added row
            setTimeout(() => {
                const tourRow = document.getElementById('tour_' + tourNo);
                if (tourRow) {
                    tourRow.classList.add('bg-yellow-50');
                    setTimeout(() => {
                        tourRow.classList.remove('bg-yellow-50');
                    }, 2000);
                }
            }, 100);
            
            // Log success
            console.log('Tour added successfully:', tourNo);
        } else {
            console.log('Tour already exists, adding new meal date:', tourNo);
            addMealDateToTour(tourNo);
        }
    }

    function addMealDateToTour(tourNo) {
        if (selectedTours[tourNo]) {
            const mealDateId = 'meal_date_' + mealDateCounter++;

            // Use today's date as default
            const today = new Date().toISOString().split('T')[0];

            // Get default no of packs
            const defaultPacks = document.getElementById('no_of_packs')?.value || '1';

            selectedTours[tourNo].mealDates.push({
                id: mealDateId,
                date: today,
                noOfPacks: defaultPacks
            });

            updateSelectedToursTable();

            // Highlight the newly added meal date row
            setTimeout(() => {
                const dateRow = document.getElementById(mealDateId);
                if (dateRow) {
                    dateRow.classList.add('bg-yellow-50');
                    setTimeout(() => {
                        dateRow.classList.remove('bg-yellow-50');
                    }, 2000);
                }
            }, 100);
            
            // Log success
            console.log('Meal date added successfully:', mealDateId);
        }
    }

    function removeTour(tourNo) {
        if (selectedTours[tourNo]) {
            delete selectedTours[tourNo];
            updateSelectedToursTable();
        }
    }

    function removeMealDate(tourNo, mealDateId) {
        if (selectedTours[tourNo] && selectedTours[tourNo].mealDates) {
            selectedTours[tourNo].mealDates = selectedTours[tourNo].mealDates.filter(date => date.id !== mealDateId);

            // If there are no more meal dates, remove the tour
            if (selectedTours[tourNo].mealDates.length === 0) {
                delete selectedTours[tourNo];
            }

            updateSelectedToursTable();
        }
    }

    function updateTourField(tourNo, field, value) {
        if (selectedTours[tourNo]) {
            selectedTours[tourNo][field] = value;
            document.getElementById('selected_tours_data').value = JSON.stringify(selectedTours);
            console.log(`Updated tour ${tourNo}, field ${field}:`, value);
        }
    }

    function updateMealDateField(tourNo, mealDateId, field, value) {
        if (selectedTours[tourNo] && selectedTours[tourNo].mealDates) {
            const mealDate = selectedTours[tourNo].mealDates.find(date => date.id === mealDateId);
            if (mealDate) {
                mealDate[field] = value;
                document.getElementById('selected_tours_data').value = JSON.stringify(selectedTours);
                console.log(`Updated meal date ${mealDateId}, field ${field}:`, value);
            }
        }
    }

    function updateSelectedToursTable() {
        const tableBody = document.getElementById('selectedToursBody');
        if (!tableBody) {
            console.error('Table body not found');
            return;
        }

        // Clear existing rows
        tableBody.innerHTML = '';

        // Show/hide the "no tours" row based on whether we have selected tours
        const tourNos = Object.keys(selectedTours);
        if (tourNos.length === 0) {
            tableBody.innerHTML =
                `<tr id="noToursRow"><td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500">No tours selected yet</td></tr>`;
            return;
        }

        // Add rows for each selected tour
        tourNos.forEach(tourNo => {
            const tour = selectedTours[tourNo];

            // Create the main tour row
            const tourRow = document.createElement('tr');
            tourRow.id = 'tour_' + tourNo;
            tourRow.className = 'border-t-2 border-gray-200 bg-gray-50';

            tourRow.innerHTML = `
            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                ${tour.tourNo}
                <input type="hidden" name="tours[${tourNo}][tour_no]" value="${tour.tourNo}">
            </td>
            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                ${tour.guestName}
                <input type="hidden" name="tours[${tourNo}][guest_name]" value="${tour.guestName}">
            </td>
            <td colspan="2" class="px-4 py-3 text-sm text-gray-900">
                <div class="flex items-center mb-2">
                    <span class="mr-2 w-16">Guide:</span>
                    <input type="text" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        name="tours[${tourNo}][guide_details]" 
                        value="${tour.guideDetails || ''}" 
                        placeholder="Enter guide details"
                        onchange="updateTourField('${tourNo}', 'guideDetails', this.value)">
                </div>
                
            </td>
            <td class="px-4 py-3 text-center">
                <div class="flex justify-center">
                    <button type="button" onclick="addMealDateToTour('${tourNo}')" class="p-1 text-blue-600 hover:text-blue-900 mr-2" title="Add Date">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <button type="button" onclick="removeTour('${tourNo}')" class="p-1 text-red-600 hover:text-red-900" title="Remove Tour">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </td>
        `;

            tableBody.appendChild(tourRow);

            // Add rows for each meal date
            if (tour.mealDates && tour.mealDates.length > 0) {
                tour.mealDates.forEach(mealDate => {
                    const dateRow = document.createElement('tr');
                    dateRow.id = mealDate.id;
                    dateRow.className = 'border-gray-100';

                    dateRow.innerHTML = `
                    <td class="pl-8 py-2 text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-3 w-3 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </td>
                    <td class="py-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="mr-2">Date:</span>
                            <input type="date" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                name="tours[${tourNo}][meal_dates][${mealDate.id}][date]" 
                                value="${mealDate.date}" 
                                onchange="updateMealDateField('${tourNo}', '${mealDate.id}', 'date', this.value)">
                        </div>
                    </td>
                    <td class="py-2 text-sm text-gray-500" colspan="2">
                        <div class="flex items-center">
                            <span class="mr-2">Packs:</span>
                            <input type="text" class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                name="tours[${tourNo}][meal_dates][${mealDate.id}][no_of_packs]" 
                                value="${mealDate.noOfPacks}" 
                                onchange="updateMealDateField('${tourNo}', '${mealDate.id}', 'noOfPacks', this.value)">
                        </div>
                    </td>
                    <td class="py-2 text-center">
                        <button type="button" onclick="removeMealDate('${tourNo}', '${mealDate.id}')" 
                            class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" 
                            title="Remove Date">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </td>
                `;

                    tableBody.appendChild(dateRow);
                });
            }
        });

        // Update the hidden field with JSON data
        document.getElementById('selected_tours_data').value = JSON.stringify(selectedTours);
        console.log('Updated table. Current tour data:', selectedTours);
    }
</script>
</x-app-layout>
