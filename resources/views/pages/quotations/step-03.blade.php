<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">

        @php
            // display  all errors
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    echo "<div class='text-red-500'>$error</div>";
                }
            }
        @endphp

        <!-- Progress Bar  -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <!-- Step 1: Reference Info -->
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_one', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Reference <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </a>
                </li>

                <!-- Step 2: Pax Slab -->
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_two', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </a>
                </li>

                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Accommodation
                    </span>
                </li>
                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">4</span>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan </span> <span
                            class="hidden sm:inline-flex sm:ms-2"> </span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">5</span>
                    Site <span class="hidden sm:inline-flex ">|Extra</span>
                </li>
            </ol>
        </div>


        <p class="text-gray-700 mt-10 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step3.store', $quotation->id) }}">
            @csrf

            <!-- Dynamic Accommodation Section -->
            <div id="accommodation-section" class="space-y-6">
                <!-- Cards will be inserted here -->
            </div>

            <button type="button" id="add-hotel"
                class="mt-6 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Another Hotel
            </button>

            <div class="flex justify-between mt-6">
                @if (isset($navigation['back']))
                    <a href="{{ $navigation['back'] }}"
                        class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
                        Back
                    </a>
                @else
                    <div></div> {{-- Empty div to maintain spacing --}}
                @endif

                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Save & Next
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

            function addAccommodationCard() {
                let cardIndex = document.querySelectorAll('#accommodation-section > div').length;

                // Get quotation dates from PHP variables
                const quotationStartDate = "{{ $quotation->start_date }}".split(' ')[0]; // Extract date part only
                const quotationEndDate = "{{ $quotation->end_date }}".split(' ')[0]; // Extract date part only

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
                                    @error('hotel_id')
                                        <p class="text-red-500 text-xs">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-in / Check-out</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="date" name="accommodations[${cardIndex}][start_date]" 
                                            class="block w-full border-gray-300 rounded-md shadow-sm checkin-date" 
                                            min="${quotationStartDate}" 
                                            max="${quotationEndDate}"
                                            required>

                                        <input type="date" name="accommodations[${cardIndex}][end_date]" 
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
                                            <option value="">Select Plan</option>${mealPlanOptions}
                                        </select>
                                        @error('meal_plan_id')
                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Room Category</label>
                                        <select name="accommodations[${cardIndex}][room_category_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                            <option value="">Select Category</option>${roomCategoryOptions}
                                        </select>
                                        @error('room_category_id')
                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Room Details -->
                            <div class="space-y-4">
                                <h3 class="font-medium text-gray-900">Room Details</h3>
                                
                                <!-- Room Types -->
                                <div class="space-y-4">
                                    <!-- Single Room -->
                                    <div class="bg-white p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Single Room</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night ( USD )</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][single][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                                                     @error('per_night_cost')
                                                         <p class="text-red-500 text-xs">{{ $message }}</p>
                                                     @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Nights</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][single][nights]" 
                                                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" min="0">
                                                @error('nights')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Total</label>
                                                <input type="text" name="accommodations[${cardIndex}][room_types][single][total_cost]" 
                                                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" readonly>
                                                @error('total_cost')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Repeat similar structure for Double and Triple rooms -->
                                    <!-- Double Room -->
                                    <div class="bg-white p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Double Room</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night ( USD )</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][double][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                                                     @error('per_night_cost')
                                                         <p class="text-red-500 text-xs">{{ $message }}</p>
                                                     @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Nights</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][double][nights]" 
                                                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" min="0">
                                                @error('nights')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Total</label>
                                                <input type="text" name="accommodations[${cardIndex}][room_types][double][total_cost]" 
                                                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" readonly>
                                                @error('total_cost')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Triple Room -->
                                    <div class="bg-white p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Triple Room</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night ( USD )</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][triple][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                                                        @error('per_night_cost')
                                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                                        @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Nights</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][triple][nights]" 
                                                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" min="0">
                                                @error('nights')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Total</label>
                                                <input type="text" name="accommodations[${cardIndex}][room_types][triple][total_cost]" 
                                                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" readonly>
                                                @error('total_cost')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Driver's Room -->
                                    <div class="bg-white p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Driver's Accommodation</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night ( LKR )</label>
                                                <input type="number" name="accommodations[${cardIndex}][additional_rooms][driver][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                                                        @error('per_night_cost')
                                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                                        @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Nights</label>
                                                <input type="number" name="accommodations[${cardIndex}][additional_rooms][driver][nights]" 
                                                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" min="0">
                                                @error('nights')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Total</label>
                                                <input type="text" name="accommodations[${cardIndex}][additional_rooms][driver][total_cost]" 
                                                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" readonly>
                                                @error('total_cost')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="flex gap-4 mt-4 items-center">
                                            <label class="font-medium text-gray-700 text-sm">Provided by hotel?</label>
                                            <div class="flex items-center">
                                                <input type="radio" id="${cardIndex}_driver_provided_by_hotel_yes" name="accommodations[${cardIndex}][additional_rooms][driver][provided_by_hotel]" value="1" class="mr-2">
                                                <label for="${cardIndex}_driver_provided_by_hotel_yes" class="text-sm">Yes</label>
                                                @error('provided_by_hotel')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" id="${cardIndex}_driver_provided_by_hotel_no" name="accommodations[${cardIndex}][additional_rooms][driver][provided_by_hotel]" value="0" class="mr-2">
                                                <label for="${cardIndex}_driver_provided_by_hotel_no" class="text-sm">No</label>
                                                @error('provided_by_hotel')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Guide's Room -->
                                    <div class="bg-white p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Guide's Accommodation</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night ( LKR )</label>
                                                <input type="number" name="accommodations[${cardIndex}][additional_rooms][guide][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                                                        @error('per_night_cost')
                                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                                        @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Nights</label>
                                                <input type="number" name="accommodations[${cardIndex}][additional_rooms][guide][nights]" 
                                                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" min="0">
                                                @error('nights')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Total</label>
                                                <input type="text" name="accommodations[${cardIndex}][additional_rooms][guide][total_cost]" 
                                                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" readonly>
                                                @error('total_cost')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="flex gap-4 mt-4 items-center">
                                            <label class="font-medium text-gray-700 text-sm">Provided by hotel?</label>
                                            <div class="flex items-center">
                                                <input type="radio" id="${cardIndex}_guide_provided_by_hotel_yes" name="accommodations[${cardIndex}][additional_rooms][guide][provided_by_hotel]" value="1" class="mr-2">
                                                <label for="${cardIndex}_guide_provided_by_hotel_yes" class="text-sm">Yes</label>
                                                @error('provided_by_hotel')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" id="${cardIndex}_guide_provided_by_hotel_no" name="accommodations[${cardIndex}][additional_rooms][guide][provided_by_hotel]" value="0" class="mr-2">
                                                <label for="${cardIndex}_guide_provided_by_hotel_no" class="text-sm">No</label>
                                                @error('provided_by_hotel')
                                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.querySelector("#accommodation-section").insertAdjacentHTML("beforeend", cardHtml);

                const newCard = document.querySelector("#accommodation-section").lastElementChild;
                const selectElement = newCard.querySelector('.hotel-select');
                new TomSelect(selectElement, {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    placeholder: 'Search for a hotel...',
                    maxOptions: null,
                });

                function calculateNights(checkIn, checkOut) {
                    const start = new Date(checkIn);
                    const end = new Date(checkOut);
                    const diffTime = end - start; // Remove Math.abs() to handle dates in correct order
                    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // This will give actual nights
                }

                // Update the event listener for date changes
                document.addEventListener("change", function(e) {
                    if (e.target.classList.contains("checkin-date") || e.target.classList.contains(
                            "checkout-date")) {
                        const card = e.target.closest('.accommodation-card');
                        const checkInDate = card.querySelector('.checkin-date').value;
                        const checkOutDate = card.querySelector('.checkout-date').value;

                        if (checkInDate && checkOutDate) {
                            const nights = calculateNights(checkInDate, checkOutDate);
                            if (nights <= 0) {
                                alert('Check-out date must be after check-in date');
                                e.target.value = ''; // Clear the invalid date
                                return;
                            }
                            // Update all night inputs in the card
                            const nightInputs = card.querySelectorAll('.total-nights');
                            nightInputs.forEach(input => {
                                input.value = nights;
                                // Trigger input event to recalculate totals
                                input.dispatchEvent(new Event('input'));
                            });
                        }
                    }
                });

            }

            // Event Listeners
            document.getElementById("add-hotel").addEventListener("click", addAccommodationCard);

            // Replace the existing input event listener with this updated version
            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("per-night-cost") || e.target.classList.contains(
                        "total-nights")) {
                    const container = e.target.closest('.grid');
                    const perNightCostInput = container.querySelector('.per-night-cost');
                    const nightsInput = container.querySelector('.total-nights');
                    const totalCostInput = container.querySelector('.total-cost');
                    const cost = perNightCostInput.value;
                    const nights = nightsInput.value;

                    if (cost && nights) {
                        totalCostInput.value = (parseFloat(cost) * parseInt(nights)).toFixed(2);
                    } else {
                        totalCostInput.value = '';
                    }
                }
            });



            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-card')) {
                    e.target.closest('.accommodation-card').remove();
                }
            });

            // Add initial card
            addAccommodationCard();
        });
    </script>

    <script>
        document.addEventListener("change", function(e) {
            if (e.target.classList.contains("checkin-date") || e.target.classList.contains("checkout-date")) {
                const card = e.target.closest('.accommodation-card');
                const checkInInput = card.querySelector('.checkin-date');
                const checkOutInput = card.querySelector('.checkout-date');

                // When check-in date changes, update check-out min date
                if (e.target.classList.contains("checkin-date")) {
                    checkOutInput.min = checkInInput.value;
                }

                // When check-out date changes, update check-in max date
                if (e.target.classList.contains("checkout-date")) {
                    checkInInput.max = checkOutInput.value;
                }

                if (checkInInput.value && checkOutInput.value) {
                    const nights = calculateNights(checkInInput.value, checkOutInput.value);
                    if (nights <= 0) {
                        alert('Check-out date must be after check-in date');
                        e.target.value = '';
                        return;
                    }

                    // Validate against quotation date range
                    const checkIn = new Date(checkInInput.value);
                    const checkOut = new Date(checkOutInput.value);
                    const quotationStart = new Date(quotationStartDate);
                    const quotationEnd = new Date(quotationEndDate);

                    if (checkIn < quotationStart || checkOut > quotationEnd) {
                        alert('Accommodation dates must be within the quotation date range');
                        e.target.value = '';
                        return;
                    }

                    // Update night inputs
                    const nightInputs = card.querySelectorAll('.total-nights');
                    nightInputs.forEach(input => {
                        input.value = nights;
                        input.dispatchEvent(new Event('input'));
                    });
                }
            }
        });
    </script>
</x-app-layout>
