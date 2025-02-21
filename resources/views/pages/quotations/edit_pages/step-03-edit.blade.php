<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_one', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Reference <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </a>
                </li>
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_two', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </a>
                </li>
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_three', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Accommodation
                    </a>
                </li>
                <!-- Step 4 -->
                <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_four', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">4</span>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan</span>
                    </a>
                </li>

                <!-- Step 5 -->
                <li class="flex items-center">
                    <a href="{{ route('quotations.edit_step_five', $quotation->id) }}" class="flex items-center">
                        <span class="me-2">5</span>
                        Sites <span class="hidden sm:inline-flex sm:ms-2">Details</span>
                    </a>
                </li>
            </ol>
        </div>

        <p class="text-gray-700 mt-16 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.update_step_three', $quotation->id) }}">
            @csrf
            @method('PUT')

            <!-- Dynamic Accommodation Section -->
            <div id="accommodation-section" class="space-y-6">
                <!-- Existing accommodations will be loaded here -->
            </div>

            <button type="button" id="add-hotel"
                class="mt-6 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Another Hotel
            </button>

            <div class="flex justify-between mt-6">
                <a href="{{ $navigation['back'] }}" class="bg-gray-500 text-white py-2 px-4 rounded-md">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md">
                    Update & Next
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hotelSelectOptions =
                `@foreach ($hotels as $hotel)<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>@endforeach`;
            const mealPlanOptions =
                `@foreach ($mealPlans as $mealPlan)<option value="{{ $mealPlan->id }}">{{ $mealPlan->name }}</option>@endforeach`;
            const roomCategoryOptions =
                `@foreach ($roomCategories as $roomCategory)<option value="{{ $roomCategory->id }}">{{ $roomCategory->name }}</option>@endforeach`;

            const quotationStartDate = "{{ $quotation->start_date }}";
            const quotationEndDate = "{{ $quotation->end_date }}";

            // Load existing accommodations
            const existingAccommodations = @json($quotation->accommodations->load('roomDetails'));

            // Loop through existing accommodations and create cards
            existingAccommodations.forEach(accommodation => {
                addAccommodationCard(accommodation);
            });

            // If no existing accommodations, add an empty card
            if (existingAccommodations.length === 0) {
                addAccommodationCard();
            }

            function addAccommodationCard(existingData = null) {
                let cardIndex = document.querySelectorAll('#accommodation-section > div').length;

                let cardHtml = `
                <div class="bg-gray-50 rounded-lg p-6 relative accommodation-card">
                    <button type="button" class="absolute top-4 right-4 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 remove-card">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hotel</label>
                            <select name="accommodations[${cardIndex}][hotel_id]" class="hotel-select block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Hotel</option>
                                ${hotelSelectOptions}
                            </select>
                        </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-in / Check-out</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="date" name="accommodations[${cardIndex}][start_date]" 
                                        value="${existingData ? existingData.start_date : ''}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm checkin-date" 
                                        min="${quotationStartDate}" 
                                        max="${quotationEndDate}"
                                        required>
                                    <input type="date" name="accommodations[${cardIndex}][end_date]" 
                                        value="${existingData ? existingData.end_date : ''}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm checkout-date" 
                                        min="${quotationStartDate}" 
                                        max="${quotationEndDate}"
                                        required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Meal Plan</label>
                                    <select name="accommodations[${cardIndex}][meal_plan_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">Select Plan</option>
                                        ${mealPlanOptions}
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Category</label>
                                    <select name="accommodations[${cardIndex}][room_category_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">Select Category</option>
                                        ${roomCategoryOptions}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Room Details -->
                        <div class="space-y-4">
                            <h3 class="font-medium text-gray-900">Room Details</h3>
                            
                            <!-- Room Types -->
                            <div class="space-y-4">
                                <!-- Single Room -->
                                ${createRoomTypeHtml('single', cardIndex, existingData)}
                                <!-- Double Room -->
                                ${createRoomTypeHtml('double', cardIndex, existingData)}
                                <!-- Triple Room -->
                                ${createRoomTypeHtml('triple', cardIndex, existingData)}

                                <!-- Driver's Room -->
                                ${createAdditionalRoomHtml('driver', cardIndex, existingData)}

                                <!-- Guide's Room -->
                                ${createAdditionalRoomHtml('guide', cardIndex, existingData)}
                            </div>
                        </div>
                    </div>
                </div>
            `;

                document.querySelector("#accommodation-section").insertAdjacentHTML("beforeend", cardHtml);

                const newCard = document.querySelectorAll('.accommodation-card')[cardIndex];
                const hotelSelect = newCard.querySelector('.hotel-select');

                initializeTomSelect(hotelSelect);

                // Set selected values if existingData is provided
                if (existingData) {
        const card = document.querySelectorAll('.accommodation-card')[cardIndex];
        
        // Set basic accommodation data
        const hotelSelect = card.querySelector(`select[name="accommodations[${cardIndex}][hotel_id]"]`);
        const tomSelect = hotelSelect.tomselect;
        tomSelect.setValue(existingData.hotel_id);
        
        card.querySelector(`input[name="accommodations[${cardIndex}][start_date]"]`).value = existingData.start_date;
        card.querySelector(`input[name="accommodations[${cardIndex}][end_date]"]`).value = existingData.end_date;
        card.querySelector(`select[name="accommodations[${cardIndex}][meal_plan_id]"]`).value = existingData.meal_plan_id;
        card.querySelector(`select[name="accommodations[${cardIndex}][room_category_id]"]`).value = existingData.room_category_id;

        // Set room details
        if (existingData.room_details) {
            existingData.room_details.forEach(room => {
                const roomType = room.room_type;
                const perNightInput = card.querySelector(`input[name="accommodations[${cardIndex}][room_types][${roomType}][per_night_cost]"]`);
                const nightsInput = card.querySelector(`input[name="accommodations[${cardIndex}][room_types][${roomType}][nights]"]`);
                const totalInput = card.querySelector(`input[name="accommodations[${cardIndex}][room_types][${roomType}][total_cost]"]`);

                if (perNightInput && nightsInput && totalInput) {
                    perNightInput.value = room.per_night_cost;
                    nightsInput.value = room.nights;
                    totalInput.value = room.total_cost;
                }
            });
        }

        // Set additional rooms data
        if (existingData.additional_rooms) {
            existingData.additional_rooms.forEach(room => {
                const roomType = room.room_type; // 'driver' or 'guide'
                const container = card.querySelector(`[name="accommodations[${cardIndex}][additional_rooms][${roomType}][per_night_cost]"]`).closest('.bg-white');
                
                container.querySelector(`[name="accommodations[${cardIndex}][additional_rooms][${roomType}][per_night_cost]"]`).value = room.per_night_cost;
                container.querySelector(`[name="accommodations[${cardIndex}][additional_rooms][${roomType}][nights]"]`).value = room.nights;
                container.querySelector(`[name="accommodations[${cardIndex}][additional_rooms][${roomType}][total_cost]"]`).value = room.total_cost;
                
                // Set radio button for provided_by_hotel
                const providedByHotelValue = room.provided_by_hotel ? "1" : "0";
                const radioButton = container.querySelector(`input[type="radio"][value="${providedByHotelValue}"]`);
                if (radioButton) {
                    radioButton.checked = true;
                }
            });
        }
    }


                // Initialize event listeners for the new card
                initializeCardEvents(cardIndex);
            }

            // Add function to initialize Tom Select
            function initializeTomSelect(selectElement) {
                return new TomSelect(selectElement, {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    placeholder: 'Search for a hotel...',
                    maxOptions: null,
                });
            }

            function createRoomTypeHtml(type, cardIndex, existingData) {
                const roomDetails = existingData ? existingData.room_details.find(detail => detail.room_type ===
                    type) : null;

                return `
                <div class="bg-white p-4 rounded-md shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-gray-700">${type.charAt(0).toUpperCase() + type.slice(1)} Room</span>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500">Per Night</label>
                            <input type="number" 
                                name="accommodations[${cardIndex}][room_types][${type}][per_night_cost]" 
                                value="${roomDetails ? roomDetails.per_night_cost : ''}"
                                class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Nights</label>
                            <input type="number" 
                                name="accommodations[${cardIndex}][room_types][${type}][nights]" 
                                value="${roomDetails ? roomDetails.nights : ''}"
                                class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" 
                                min="0">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Total</label>
                            <input type="text" 
                                name="accommodations[${cardIndex}][room_types][${type}][total_cost]" 
                                value="${roomDetails ? roomDetails.total_cost : ''}"
                                class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" 
                                readonly>
                        </div>
                    </div>
                </div>
            `;
            }

            function createAdditionalRoomHtml(type, cardIndex, existingData) {
    const roomDetails = existingData ? existingData.additional_rooms?.find(room => room.room_type === type) : null;
    const capitalizedType = type.charAt(0).toUpperCase() + type.slice(1);

    return `
    <div class="bg-white p-4 rounded-md shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <span class="font-medium text-gray-700">${capitalizedType}'s Accommodation</span>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div>
                <label class="block text-xs text-gray-500">Per Night</label>
                <input type="number" 
                    name="accommodations[${cardIndex}][additional_rooms][${type}][per_night_cost]" 
                    value="${roomDetails ? roomDetails.per_night_cost : ''}"
                    class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
            </div>
            <div>
                <label class="block text-xs text-gray-500">Nights</label>
                <input type="number" 
                    name="accommodations[${cardIndex}][additional_rooms][${type}][nights]" 
                    value="${roomDetails ? roomDetails.nights : ''}"
                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" 
                    min="0">
            </div>
            <div>
                <label class="block text-xs text-gray-500">Total</label>
                <input type="text" 
                    name="accommodations[${cardIndex}][additional_rooms][${type}][total_cost]" 
                    value="${roomDetails ? roomDetails.total_cost : ''}"
                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" 
                    readonly>
            </div>
        </div>
        <div class="flex gap-4 mt-4 items-center">
            <label class="font-medium text-gray-700 text-sm">Provided by hotel?</label>
            <div class="flex items-center">
                <input type="radio" 
                    id="${cardIndex}_${type}_provided_by_hotel_yes" 
                    name="accommodations[${cardIndex}][additional_rooms][${type}][provided_by_hotel]" 
                    value="1" 
                    ${roomDetails && roomDetails.provided_by_hotel ? 'checked' : ''}
                    class="mr-2">
                <label for="${cardIndex}_${type}_provided_by_hotel_yes" class="text-sm">Yes</label>
            </div>
            <div class="flex items-center">
                <input type="radio" 
                    id="${cardIndex}_${type}_provided_by_hotel_no" 
                    name="accommodations[${cardIndex}][additional_rooms][${type}][provided_by_hotel]" 
                    value="0" 
                    ${roomDetails && !roomDetails.provided_by_hotel ? 'checked' : ''}
                    class="mr-2">
                <label for="${cardIndex}_${type}_provided_by_hotel_no" class="text-sm">No</label>
            </div>
        </div>
    </div>`;
}

            // Add hotel button event listener
            document.getElementById("add-hotel").addEventListener("click", () => addAccommodationCard());

            // Remove hotel card event listener
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-card')) {
                    const card = e.target.closest('.accommodation-card');
                    if (document.querySelectorAll('.accommodation-card').length > 1) {
                        // Destroy Tom Select instance before removing the card
                        const select = card.querySelector('.hotel-select');
                        if (select.tomselect) {
                            select.tomselect.destroy();
                        }
                        card.remove();
                    } else {
                        alert('At least one hotel accommodation is required.');
                    }
                }
            });

            // Date validation and calculation event listener
            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("checkin-date") || e.target.classList.contains(
                        "checkout-date")) {
                    const card = e.target.closest('.accommodation-card');
                    const checkInInput = card.querySelector('.checkin-date');
                    const checkOutInput = card.querySelector('.checkout-date');

                    if (checkInInput.value && checkOutInput.value) {
                        validateAndCalculateDates(checkInInput, checkOutInput, card);
                    }
                }
            });

            // Cost calculation event listener
            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("per-night-cost") || e.target.classList.contains(
                        "total-nights")) {
                    calculateRoomCosts(e.target);
                }
            });

            function validateAndCalculateDates(checkInInput, checkOutInput, card) {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);
                const quotationStart = new Date(quotationStartDate);
                const quotationEnd = new Date(quotationEndDate);

                if (checkOut <= checkIn) {
                    alert('Check-out date must be after check-in date');
                    checkOutInput.value = '';
                    return;
                }

                if (checkIn < quotationStart || checkOut > quotationEnd) {
                    alert('Accommodation dates must be within the quotation date range');
                    if (checkIn < quotationStart) checkInInput.value = '';
                    if (checkOut > quotationEnd) checkOutInput.value = '';
                    return;
                }

                const nights = calculateNights(checkIn, checkOut);
                updateNightsAndTotals(card, nights);
            }

            function calculateNights(checkIn, checkOut) {
                const diffTime = checkOut - checkIn;
                return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            }

            function updateNightsAndTotals(card, nights) {
                const nightInputs = card.querySelectorAll('.total-nights');
                nightInputs.forEach(input => {
                    input.value = nights;
                    calculateRoomCosts(input);
                });
            }

            function calculateRoomCosts(input) {
                const container = input.closest('.grid');
                const perNightCostInput = container.querySelector('.per-night-cost');
                const nightsInput = container.querySelector('.total-nights');
                const totalCostInput = container.querySelector('.total-cost');

                if (perNightCostInput.value && nightsInput.value) {
                    const total = (parseFloat(perNightCostInput.value) * parseInt(nightsInput.value)).toFixed(2);
                    totalCostInput.value = total;
                } else {
                    totalCostInput.value = '';
                }
            }

            function initializeCardEvents(cardIndex) {
                const card = document.querySelectorAll('.accommodation-card')[cardIndex];

                // Initialize date inputs
                const checkInInput = card.querySelector('.checkin-date');
                const checkOutInput = card.querySelector('.checkout-date');

                checkInInput.addEventListener('change', () => {
                    checkOutInput.min = checkInInput.value;
                });

                checkOutInput.addEventListener('change', () => {
                    checkInInput.max = checkOutInput.value;
                });

                // Initialize cost calculations
                const roomTypes = ['single', 'double', 'triple'];
                roomTypes.forEach(type => {
                    const container = card.querySelector(
                            `[name="accommodations[${cardIndex}][room_types][${type}][per_night_cost]"]`)
                        .closest('.grid');
                    const inputs = container.querySelectorAll('input');
                    inputs.forEach(input => {
                        input.addEventListener('input', () => calculateRoomCosts(input));
                    });
                });
            }
        });
    </script>
</x-app-layout>
