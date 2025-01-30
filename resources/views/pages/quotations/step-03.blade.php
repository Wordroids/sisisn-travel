<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Step 3: Accommodation</h2>
        <p class="text-gray-700">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step3.store', $quotation->id) }}">
            @csrf

            <div id="accommodation-section">
                <div class="accommodation-entry border p-4 rounded-lg mb-4 bg-gray-100">
                    <div class="grid grid-cols-6 gap-4">
                        <!-- Hotel Selection -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Hotel</label>
                            <select name="accommodation[0][hotel_id]" class="hotel-select block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Hotel</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Date Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" name="accommodation[0][start_date]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <input type="date" name="accommodation[0][end_date]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <!-- Meal Plan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Meal Plan</label>
                            <select name="accommodation[0][meal_plan_id]" class="block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Meal Plan</option>
                                @foreach ($mealPlans as $mealPlan)
                                    <option value="{{ $mealPlan->id }}">{{ $mealPlan->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Room Category</label>
                            <select name="accommodation[0][room_category_id]" class="block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Room Category</option>
                                @foreach ($roomCategories as $roomCategory)
                                    <option value="{{ $roomCategory->id }}">{{ $roomCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Room Type Selection -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Room Type</label>
                        <select name="accommodation[0][room_type_id]" class="room-type-select block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Room Type</option>
                            @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}" data-price="{{ $roomType->price_per_night }}">{{ $roomType->name }} ({{ $roomType->price_per_night }} USD/Night)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Total Nights -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Number of Nights</label>
                        <input type="number" name="accommodation[0][nights]" class="nights-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <!-- Cost Calculation -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Total Cost (USD)</label>
                        <input type="number" name="accommodation[0][total_cost]" class="total-cost block w-full border-gray-300 rounded-md shadow-sm" readonly>
                    </div>
                </div>
            </div>

            <!-- Add Another Hotel Button -->
            <button type="button" id="add-hotel" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">+ Add Another Hotel</button>

            <div class="flex justify-between mt-6">
                <a href="{{ route('quotations.step2', $quotation->id) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back</a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Save & Next</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let hotelIndex = 1;

            document.querySelector("#add-hotel").addEventListener("click", function () {
                let newHotel = document.querySelector(".accommodation-entry").cloneNode(true);
                newHotel.querySelectorAll("select, input").forEach(input => {
                    input.name = input.name.replace("[0]", "[" + hotelIndex + "]");
                    input.value = "";
                });
                document.querySelector("#accommodation-section").appendChild(newHotel);
                hotelIndex++;
            });

            document.querySelectorAll(".room-type-select").forEach(select => {
                select.addEventListener("change", function () {
                    let pricePerNight = this.options[this.selectedIndex].getAttribute("data-price");
                    let nightsInput = this.closest(".accommodation-entry").querySelector(".nights-input");
                    let totalCostInput = this.closest(".accommodation-entry").querySelector(".total-cost");
                    nightsInput.addEventListener("input", function () {
                        totalCostInput.value = pricePerNight * nightsInput.value;
                    });
                });
            });
        });
    </script>
</x-app-layout>
