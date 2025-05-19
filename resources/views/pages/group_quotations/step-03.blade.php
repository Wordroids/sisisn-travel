<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar -->
        <div class="mb-8">
            <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base">
                <li class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_01', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Basic <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </a>
                </li>
                <li class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_02', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </a>
                </li>
                <li class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Accommodation
                    </span>
                </li>
                <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                        <span class="me-2">4</span>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan</span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">5</span>
                    Site <span class="hidden sm:inline-flex sm:ms-2">|Extras</span>
                </li>
            </ol>
        </div>

        <p class="text-gray-700 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('group_quotations.store_step_03', $quotation->id) }}">
            @csrf
            @method('PUT')

            <!-- Dynamic Accommodation Section -->
            <div id="accommodation-section" class="space-y-6">
                <!-- Accommodation cards will be loaded/added here -->
            </div>

            <button type="button" id="add-hotel"
                class="mt-6 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Another Hotel
            </button>

            <div class="flex justify-between mt-10">
                <a href="{{ route('group_quotations.step_02', $quotation->id) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
                    Back to Pax Slab
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Save & Next
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hotelSelectOptions = `@foreach ($hotels as $hotel)<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>@endforeach`;
            const mealPlanOptions = `@foreach ($mealPlans as $mealPlan)<option value="{{ $mealPlan->id }}">{{ $mealPlan->name }}</option>@endforeach`;
            const roomCategoryOptions = `@foreach ($roomCategories as $roomCategory)<option value="{{ $roomCategory->id }}">{{ $roomCategory->name }}</option>@endforeach`;

            const quotationStartDate = "{{ $quotation->start_date ? $quotation->start_date->format('Y-m-d') : '' }}";
            const quotationEndDate = "{{ $quotation->end_date ? $quotation->end_date->format('Y-m-d') : '' }}";

            const existingAccommodations = @json($quotation->accommodations->load('roomDetails', 'additionalRooms'));

            existingAccommodations.forEach(accommodation => {
                addAccommodationCard(accommodation);
            });

            if (existingAccommodations.length === 0) {
                addAccommodationCard(); // Add one empty card if none exist
            }

            function addAccommodationCard(existingData = null) {
                let cardIndex = document.querySelectorAll('#accommodation-section > div.accommodation-card').length;

                let cardHtml = `
                <div class="bg-gray-50 rounded-lg p-6 relative accommodation-card border border-gray-200">
                    <button type="button" class="absolute top-4 right-4 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 remove-card">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Hotel #${cardIndex + 1}</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="accommodations[${cardIndex}][hotel_id]" class="block text-sm font-medium text-gray-700 mb-1">Hotel</label>
                                <select name="accommodations[${cardIndex}][hotel_id]" class="hotel-select block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="">Select Hotel</option>
                                    ${hotelSelectOptions}
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-in / Check-out</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="date" name="accommodations[${cardIndex}][start_date]" class="checkin-date block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <input type="date" name="accommodations[${cardIndex}][end_date]" class="checkout-date block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="accommodations[${cardIndex}][meal_plan_id]" class="block text-sm font-medium text-gray-700 mb-1">Meal Plan</label>
                                    <select name="accommodations[${cardIndex}][meal_plan_id]" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        <option value="">Select Meal Plan</option>
                                        ${mealPlanOptions}
                                    </select>
                                </div>
                                <div>
                                    <label for="accommodations[${cardIndex}][room_category_id]" class="block text-sm font-medium text-gray-700 mb-1">Room Category</label>
                                    <select name="accommodations[${cardIndex}][room_category_id]" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        <option value="">Select Room Category</option>
                                        ${roomCategoryOptions}
                                    </select>
                                </div>
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Total Nights</label>
                                <input type="number" name="accommodations[${cardIndex}][nights]" class="main-total-nights bg-gray-100 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" readonly>
                            </div>
                        </div>

                        <!-- Right Column - Room Details -->
                        <div class="space-y-4">
                            <h3 class="font-medium text-gray-900">Room Details</h3>
                            <div class="space-y-4">
                                ${createRoomTypeHtml('single', cardIndex, existingData)}
                                ${createRoomTypeHtml('double', cardIndex, existingData)}
                                ${createRoomTypeHtml('triple', cardIndex, existingData)}
                            </div>

                            <h4 class="text-md font-semibold text-gray-600 mt-4">Additional Rooms</h4>
                            <div class="space-y-4">
                                ${createAdditionalRoomHtml('guide', cardIndex, existingData)}
                                ${createAdditionalRoomHtml('driver', cardIndex, existingData)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
                document.querySelector("#accommodation-section").insertAdjacentHTML("beforeend", cardHtml);
                const newCard = Array.from(document.querySelectorAll('.accommodation-card')).pop();

                const hotelSelect = newCard.querySelector('.hotel-select');
                if (typeof TomSelect !== 'undefined') {
                   new TomSelect(hotelSelect,{ create: false, sortField: { field: "text", direction: "asc" } });
                }

                if (existingData) {
                    const hotelTomSelect = hotelSelect.tomselect;
                    if (hotelTomSelect) hotelTomSelect.setValue(existingData.hotel_id);
                    else hotelSelect.value = existingData.hotel_id;


                    newCard.querySelector(`input[name="accommodations[${cardIndex}][start_date]"]`).value = existingData.start_date ? existingData.start_date.substring(0,10) : '';
                    newCard.querySelector(`input[name="accommodations[${cardIndex}][end_date]"]`).value = existingData.end_date ? existingData.end_date.substring(0,10) : '';
                    newCard.querySelector(`select[name="accommodations[${cardIndex}][meal_plan_id]"]`).value = existingData.meal_plan_id;
                    newCard.querySelector(`select[name="accommodations[${cardIndex}][room_category_id]"]`).value = existingData.room_category_id;
                    newCard.querySelector(`input[name="accommodations[${cardIndex}][nights]"]`).value = existingData.nights;
                }
                initializeCardEvents(newCard);
            }

            function createRoomTypeHtml(type, cardIndex, accommodationData) {
                const capitalizedType = type.charAt(0).toUpperCase() + type.slice(1);
                const existingRoomData = accommodationData && accommodationData.room_details ?
                                 accommodationData.room_details.find(rd => rd.room_type && rd.room_type.toLowerCase() === type) : null;

                const perNightCost = existingRoomData ? parseFloat(existingRoomData.per_night_cost).toFixed(2) : '';
                const nights = existingRoomData ? existingRoomData.nights : (accommodationData ? accommodationData.nights : '');
                const totalCost = existingRoomData ? parseFloat(existingRoomData.total_cost).toFixed(2) : '';

                return `
                <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                    <span class="font-medium text-gray-700">${capitalizedType} Room</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Cost/Night</label>
                            <input type="number" step="0.01" name="accommodations[${cardIndex}][room_types][${type}][per_night_cost]" value="${perNightCost}" class="per-night-cost mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Nights</label>
                            <input type="number" name="accommodations[${cardIndex}][room_types][${type}][nights]" value="${nights}" class="total-nights bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Total Cost</label>
                            <input type="number" step="0.01" name="accommodations[${cardIndex}][room_types][${type}][total_cost]" value="${totalCost}" class="total-cost bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" readonly>
                        </div>
                    </div>
                </div>`;
            }

            function createAdditionalRoomHtml(type, cardIndex, accommodationData) {
                const capitalizedType = type.charAt(0).toUpperCase() + type.slice(1);
                 const existingRoomData = accommodationData && accommodationData.additional_rooms ?
                                 accommodationData.additional_rooms.find(ar => ar.room_type && ar.room_type.toLowerCase() === type) : null;

                const perNightCost = existingRoomData ? parseFloat(existingRoomData.per_night_cost).toFixed(2) : '';
                const nights = existingRoomData ? existingRoomData.nights : (accommodationData ? accommodationData.nights : '');
                const totalCost = existingRoomData ? parseFloat(existingRoomData.total_cost).toFixed(2) : '';
                const providedByHotel = existingRoomData ? existingRoomData.provided_by_hotel : false;

                return `
                <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-gray-700">${capitalizedType}'s Accommodation</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Cost/Night</label>
                            <input type="number" step="0.01" name="accommodations[${cardIndex}][additional_rooms][${type}][per_night_cost]" value="${perNightCost}" class="per-night-cost mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Nights</label>
                            <input type="number" name="accommodations[${cardIndex}][additional_rooms][${type}][nights]" value="${nights}" class="total-nights bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Total Cost</label>
                            <input type="number" step="0.01" name="accommodations[${cardIndex}][additional_rooms][${type}][total_cost]" value="${totalCost}" class="total-cost bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" readonly>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-4 items-center">
                        <label class="font-medium text-gray-700 text-sm">Provided by hotel?</label>
                        <div class="flex items-center">
                            <input type="radio" id="provided_by_hotel_${type}_${cardIndex}_yes" name="accommodations[${cardIndex}][additional_rooms][${type}][provided_by_hotel]" value="1" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" ${providedByHotel ? 'checked' : ''}>
                            <label for="provided_by_hotel_${type}_${cardIndex}_yes" class="ml-2 block text-sm text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="provided_by_hotel_${type}_${cardIndex}_no" name="accommodations[${cardIndex}][additional_rooms][${type}][provided_by_hotel]" value="0" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" ${!providedByHotel ? 'checked' : ''}>
                            <label for="provided_by_hotel_${type}_${cardIndex}_no" class="ml-2 block text-sm text-gray-900">No</label>
                        </div>
                    </div>
                </div>`;
            }

            document.getElementById("add-hotel").addEventListener("click", () => addAccommodationCard());

            document.querySelector("#accommodation-section").addEventListener("click", function(e) {
                if (e.target.closest('.remove-card')) {
                    const card = e.target.closest('.accommodation-card');
                    if (document.querySelectorAll('.accommodation-card').length > 1 || existingAccommodations.length === 0) { // Allow removing the last card if it was added manually and not from existing data
                         const hotelSelect = card.querySelector('.hotel-select');
                         if (hotelSelect && hotelSelect.tomselect) {
                            hotelSelect.tomselect.destroy();
                         }
                        card.remove();
                    } else {
                        alert('At least one hotel accommodation is required if loaded from existing data.');
                    }
                }
            });

            function validateAndCalculateDates(checkInInput, checkOutInput, card) {
                const checkInStr = checkInInput.value;
                const checkOutStr = checkOutInput.value;

                if (!checkInStr || !checkOutStr) {
                    updateNightsAndTotals(card, 0);
                    return;
                }

                const checkIn = new Date(checkInStr);
                const checkOut = new Date(checkOutStr);
                const quotationStart = quotationStartDate ? new Date(quotationStartDate) : null;
                const quotationEnd = quotationEndDate ? new Date(quotationEndDate) : null;

                let error = false;
                if (checkOut <= checkIn) {
                    alert("Check-out date must be after check-in date.");
                    checkOutInput.value = ""; // Clear invalid date
                    error = true;
                }
                if (quotationStart && checkIn < quotationStart) {
                    alert(`Check-in date cannot be earlier than quotation start date (${quotationStartDate}).`);
                    checkInInput.value = quotationStartDate; // Reset to min
                    error = true;
                }
                if (quotationEnd && checkOut > quotationEnd) {
                    alert(`Check-out date cannot be later than quotation end date (${quotationEndDate}).`);
                    checkOutInput.value = quotationEndDate; // Reset to max
                    error = true;
                }
                 if (error) {
                     updateNightsAndTotals(card, 0); // Recalculate nights as 0
                     return;
                }


                const nights = calculateNights(checkIn, checkOut);
                card.querySelector('.main-total-nights').value = nights > 0 ? nights : 0;
                updateNightsAndTotals(card, nights > 0 ? nights : 0);
            }

            function calculateNights(checkIn, checkOut) {
                if (!checkIn || !checkOut || checkIn >= checkOut) return 0;
                const diffTime = Math.abs(checkOut - checkIn);
                return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            }

            function updateNightsAndTotals(card, nights) {
                const nightInputs = card.querySelectorAll('.total-nights'); // Targets all room type night inputs
                nightInputs.forEach(input => {
                    input.value = nights;
                    calculateRoomCosts(input);
                });
            }

            function calculateRoomCosts(elementInsideRoomBlock) {
                // Common parent for per-night-cost, total-nights, total-cost is the div with class "grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2" or similar
                const roomBlock = elementInsideRoomBlock.closest('.grid.gap-3');
                if (!roomBlock) return;

                const perNightCostInput = roomBlock.querySelector('.per-night-cost');
                const nightsInput = roomBlock.querySelector('.total-nights');
                const totalCostInput = roomBlock.querySelector('.total-cost');

                if (!perNightCostInput || !nightsInput || !totalCostInput) return;

                const perNightCost = parseFloat(perNightCostInput.value) || 0;
                const nights = parseInt(nightsInput.value) || 0;

                if (perNightCost > 0 && nights > 0) {
                    totalCostInput.value = (perNightCost * nights).toFixed(2);
                } else {
                    totalCostInput.value = '0.00';
                }
            }

            function initializeCardEvents(card) {
                const checkInInput = card.querySelector('.checkin-date');
                const checkOutInput = card.querySelector('.checkout-date');

                // Set min/max for date inputs based on quotation dates
                if (quotationStartDate) {
                    checkInInput.min = quotationStartDate;
                    checkOutInput.min = quotationStartDate;
                }
                if (quotationEndDate) {
                    checkInInput.max = quotationEndDate;
                    checkOutInput.max = quotationEndDate;
                }

                checkInInput.addEventListener('change', () => {
                    if (checkInInput.value) {
                        // Ensure checkout.min is not before checkin.value
                        checkOutInput.min = checkInInput.value;
                        // If checkout is before new checkin, clear checkout or set to day after checkin
                        if (checkOutInput.value && new Date(checkOutInput.value) < new Date(checkInInput.value)) {
                            // const nextDay = new Date(checkInInput.value);
                            // nextDay.setDate(nextDay.getDate() + 1);
                            // if (quotationEndDate && nextDay > new Date(quotationEndDate)) {
                            //     checkOutInput.value = quotationEndDate;
                            // } else {
                            //    checkOutInput.value = nextDay.toISOString().split('T')[0];
                            // }
                            checkOutInput.value = ''; // Or prompt user
                        }
                    }
                    validateAndCalculateDates(checkInInput, checkOutInput, card);
                });

                checkOutInput.addEventListener('change', () => {
                    if (checkOutInput.value && checkInInput.value) {
                         // Ensure checkin.max is not after checkout.value
                        checkInInput.max = checkOutInput.value;
                    }
                    validateAndCalculateDates(checkInInput, checkOutInput, card);
                });

                const costInputs = card.querySelectorAll('.per-night-cost');
                costInputs.forEach(input => {
                    input.addEventListener('input', () => calculateRoomCosts(input));
                });

                // Initial calculation if dates are pre-filled (e.g. from existingData)
                if (checkInInput.value && checkOutInput.value) {
                    validateAndCalculateDates(checkInInput, checkOutInput, card);
                } else {
                     // If dates are not pre-filled, ensure nights and costs are 0 or empty
                    updateNightsAndTotals(card, 0);
                }
            }
        });
    </script>
</x-app-layout>