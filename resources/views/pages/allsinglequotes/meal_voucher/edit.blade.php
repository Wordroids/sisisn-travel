<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                <!-- Error -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="text-red-600 font-semibold mb-2">Please fix the following errors:</div>
                            <ul class="list-disc pl-5 text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ isset($mealVoucher->id) ? 'Edit' : 'Create' }} Individual Meal Voucher
                        </h2>
                        <a href="{{ route('individual_meal_vouchers.index', $quotation->id) }}"
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

                    @if (isset($mealVoucher->id))
                        <form
                            action="{{ route('individual_meal_vouchers.update', ['quotation' => $quotation->id, 'id' => $mealVoucher->id]) }}"
                            method="POST" class="space-y-6">
                            @method('PUT')
                    @else
                        <form action="{{ route('individual_meal_vouchers.store', $quotation->id) }}" method="POST"
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

                    <!-- Meal Dates -->
                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-medium text-gray-800">Meal Dates</h3>
                            <button type="button" onclick="addMealDate()" 
                                class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Date
                            </button>
                        </div>
                        <div class="overflow-x-auto bg-gray-50 rounded-lg border">
                            <table class="min-w-full divide-y divide-gray-200" id="mealDatesTable">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. of Pax</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Breakfast</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Lunch</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Dinner</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="mealDatesBody">
                                    <tr id="noMealDatesRow">
                                        <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No
                                            meal dates added yet</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Store the meal dates data as JSON -->
                    <input type="hidden" name="meal_dates" id="meal_dates"
                        value="{{ old('meal_dates', $mealVoucher->meal_dates ?? '[]') }}">

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
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('billing_instructions', $mealVoucher->billing_instructions ?? 'Extras to be collected from the client directly.') }}</textarea>
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
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('reservation_note', $mealVoucher->reservation_note ?? 'Please reserve and confirm the above arrangements. Clients will arrive for the given meal against the day. Please return duplicate duly singed as confirmation, and triplicate along with your bill.') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ isset($mealVoucher->id) ? 'Update' : 'Create' }} Meal Voucher
                        </button>
                    </div>
                    </form>
                    <div class="flex justify-end mt-4 gap-4">
                        @if (isset($mealVoucher->id))
                            <a href="{{ route('individual_meal_vouchers.pdf', ['quotation' => $quotation->id, 'id' => $mealVoucher->id]) }}"
                                target="_blank"
                                class="inline-flex items-center px-4 py-2 border border-green-600 rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download PDF
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Object to track meal dates
        let mealDates = [];
        let mealDateCounter = 0;

        // Initialize from existing data if available
        document.addEventListener('DOMContentLoaded', function() {
            // Make sure the hotel name is updated when the page loads
            updateHotelName();

            const existingData = document.getElementById('meal_dates').value;
            if (existingData && existingData.trim() !== '' && existingData !== '[]') {
                try {
                    mealDates = JSON.parse(existingData);
                    
                    // Find the highest mealDateCounter
                    mealDates.forEach(date => {
                        const id = parseInt(date.id.split('_')[2] || 0);
                        mealDateCounter = Math.max(mealDateCounter, id + 1);
                    });
                    
                    updateMealDatesTable();
                } catch (e) {
                    console.error("Error parsing existing meal dates data", e);
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

        function addMealDate() {
            const mealDateId = 'meal_date_' + mealDateCounter++;

            // Use today's date as default
            const today = new Date().toISOString().split('T')[0];

            // Default pax count
            const defaultPax = {{ $paxCount ?? 1 }};

            mealDates.push({
                id: mealDateId,
                date: today,
                pax: defaultPax,
                breakfast: false,
                lunch: false,
                dinner: false
            });

            updateMealDatesTable();

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
        }

        function removeMealDate(mealDateId) {
            mealDates = mealDates.filter(date => date.id !== mealDateId);
            updateMealDatesTable();
        }

        function updateMealDateField(mealDateId, field, value) {
    const mealDate = mealDates.find(date => date.id === mealDateId);
    if (mealDate) {
        if (field === 'breakfast' || field === 'lunch' || field === 'dinner') {
            // For checkboxes, we need to use the boolean value directly
            mealDate[field] = value;
        } else {
            mealDate[field] = value;
        }
        document.getElementById('meal_dates').value = JSON.stringify(mealDates);
    }
}

        function updateMealDatesTable() {
    const tableBody = document.getElementById('mealDatesBody');
    if (!tableBody) {
        console.error('Table body not found');
        return;
    }

    // Clear existing rows
    tableBody.innerHTML = '';

    // Show/hide the "no meal dates" row based on whether we have meal dates
    if (mealDates.length === 0) {
        tableBody.innerHTML =
            `<tr id="noMealDatesRow"><td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">No meal dates added yet</td></tr>`;
        return;
    }

    // Add rows for each meal date
    mealDates.forEach(mealDate => {
        const dateRow = document.createElement('tr');
        dateRow.id = mealDate.id;
        dateRow.className = 'hover:bg-gray-50';

        dateRow.innerHTML = `
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                <input type="date" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="${mealDate.date}" 
                    onchange="updateMealDateField('${mealDate.id}', 'date', this.value)">
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                <input type="number" min="1" class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="${mealDate.pax}" 
                    onchange="updateMealDateField('${mealDate.id}', 'pax', this.value)">
            </td>
            <td class="px-4 py-3 text-center">
                <input type="checkbox" class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                    ${mealDate.breakfast ? 'checked' : ''}
                    onclick="updateMealDateField('${mealDate.id}', 'breakfast', this.checked)">
            </td>
            <td class="px-4 py-3 text-center">
                <input type="checkbox" class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                    ${mealDate.lunch ? 'checked' : ''}
                    onclick="updateMealDateField('${mealDate.id}', 'lunch', this.checked)">
            </td>
            <td class="px-4 py-3 text-center">
                <input type="checkbox" class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                    ${mealDate.dinner ? 'checked' : ''}
                    onclick="updateMealDateField('${mealDate.id}', 'dinner', this.checked)">
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" onclick="removeMealDate('${mealDate.id}')" 
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

    // Update the hidden field with JSON data
    document.getElementById('meal_dates').value = JSON.stringify(mealDates);
}
    </script>

</x-app-layout>