<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Step 3: Accommodation</h2>
        <p class="text-gray-700 mb-6">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

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

            <div class="flex justify-between mt-8">
                <a href="{{ route('quotations.step2', $quotation->id) }}"
                    class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back</a>
                <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">
                    Save & Continue
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hotelSelectOptions = `@foreach ($hotels as $hotel)<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>@endforeach`;
            const mealPlanOptions = `@foreach ($mealPlans as $mealPlan)<option value="{{ $mealPlan->id }}">{{ $mealPlan->name }}</option>@endforeach`;
            const roomCategoryOptions = `@foreach ($roomCategories as $roomCategory)<option value="{{ $roomCategory->id }}">{{ $roomCategory->name }}</option>@endforeach`;

            function addAccommodationCard() {
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
                                    <select name="accommodations[${cardIndex}][hotel_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">Select Hotel</option>${hotelSelectOptions}
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-in / Check-out</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="date" name="accommodations[${cardIndex}][start_date]" 
                                            class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <input type="date" name="accommodations[${cardIndex}][end_date]" 
                                            class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Meal Plan</label>
                                        <select name="accommodations[${cardIndex}][meal_plan_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                            <option value="">Select Plan</option>${mealPlanOptions}
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Room Category</label>
                                        <select name="accommodations[${cardIndex}][room_category_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                            <option value="">Select Category</option>${roomCategoryOptions}
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
                                    <div class="bg-white p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Single Room</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][single][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Nights</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][single][nights]" 
                                                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" min="0">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Total</label>
                                                <input type="text" name="accommodations[${cardIndex}][room_types][single][total_cost]" 
                                                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" readonly>
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
                                                <label class="block text-xs text-gray-500">Per Night</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][double][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Nights</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][double][nights]" 
                                                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" min="0">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Total</label>
                                                <input type="text" name="accommodations[${cardIndex}][room_types][double][total_cost]" 
                                                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" readonly>
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
                                                <label class="block text-xs text-gray-500">Per Night</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][triple][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Nights</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][triple][nights]" 
                                                    class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" min="0">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500">Total</label>
                                                <input type="text" name="accommodations[${cardIndex}][room_types][triple][total_cost]" 
                                                    class="block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm total-cost text-center" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.querySelector("#accommodation-section").insertAdjacentHTML("beforeend", cardHtml);
            }

            // Event Listeners
            document.getElementById("add-hotel").addEventListener("click", addAccommodationCard);

            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("total-nights")) {
                    const nightsInput = e.target;
                    const nights = nightsInput.value;
                    const perNightCostInput = nightsInput.parentElement.previousElementSibling.querySelector('.per-night-cost');
                    const totalCostInput = nightsInput.parentElement.nextElementSibling.querySelector('.total-cost');
                    const cost = perNightCostInput.value;

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
</x-app-layout>