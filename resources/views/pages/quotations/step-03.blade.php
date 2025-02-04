<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Step 3: Accommodation</h2>
        <p class="text-gray-700">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step3.store', $quotation->id) }}">
            @csrf

            <!-- Dynamic Accommodation Section -->
            <div id="accommodation-section">
                <div class="overflow-x-auto bg-gray-100 p-4 rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-gray-700 bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-center">Hotel</th>
                                <th class="px-4 py-2 text-center">Date Range</th>
                                <th class="px-4 py-2 text-center">Meal Plan</th>
                                <th class="px-4 py-2 text-center">Room Category</th>
                                <th class="px-4 py-2 text-center">Room Type</th>
                                <th class="px-4 py-2 text-center">Per Night Cost</th>
                                <th class="px-4 py-2 text-center">Total Nights</th>
                                <th class="px-4 py-2 text-center">Total Cost</th>
                                <th class="px-4 py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="accommodation-rows">
                            <!-- JavaScript will dynamically insert rows here -->
                        </tbody>
                    </table>
                </div>
                <button type="button" id="add-hotel" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    + Add Another Hotel
                </button>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('quotations.step2', $quotation->id) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back</a>
                <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">
                    Save & Next
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const hotelSelectOptions = `@foreach ($hotels as $hotel) <option value="{{ $hotel->id }}">{{ $hotel->name }}</option> @endforeach`;
            const mealPlanOptions = `@foreach ($mealPlans as $mealPlan) <option value="{{ $mealPlan->id }}">{{ $mealPlan->name }}</option> @endforeach`;
            const roomCategoryOptions = `@foreach ($roomCategories as $roomCategory) <option value="{{ $roomCategory->id }}">{{ $roomCategory->name }}</option> @endforeach`;
            const roomTypeOptions = `@foreach ($roomTypes as $roomType) <option value="{{ $roomType->id }}" data-cost="{{ $roomType->per_night_cost }}">{{ $roomType->name }}</option> @endforeach`;

            function addAccommodationRow() {
                let rowIndex = document.querySelectorAll('#accommodation-rows tr').length;
                let rowHtml = `
                    <tr>
                        <td class="px-4 py-2">
                            <select name="accommodations[${rowIndex}][hotel_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Hotel</option>${hotelSelectOptions}
                            </select>
                        </td>

                        <td class="px-4 py-2">
                            <input type="date" name="accommodations[${rowIndex}][start_date]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <input type="date" name="accommodations[${rowIndex}][end_date]" class="block w-full border-gray-300 rounded-md shadow-sm mt-2" required>
                        </td>

                        <td class="px-4 py-2">
                            <select name="accommodations[${rowIndex}][meal_plan_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Meal Plan</option>${mealPlanOptions}
                            </select>
                        </td>

                        <td class="px-4 py-2">
                            <select name="accommodations[${rowIndex}][room_category_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Room Category</option>${roomCategoryOptions}
                            </select>
                        </td>

                        <td class="px-4 py-2">
                            <select name="accommodations[${rowIndex}][room_type_id]" class="block w-full border-gray-300 rounded-md shadow-sm room-type-select" required>
                                <option value="">Select Room Type</option>${roomTypeOptions}
                            </select>
                        </td>

                        <td class="px-4 py-2">
                            <input type="text" name="accommodations[${rowIndex}][per_night_cost]" class="block w-full border-gray-300 rounded-md shadow-sm per-night-cost text-center" required>
                        </td>

                        <td class="px-4 py-2">
                            <input type="number" name="accommodations[${rowIndex}][nights]" class="block w-full border-gray-300 rounded-md shadow-sm total-nights text-center" required>
                        </td>

                        <td class="px-4 py-2">
                            <input type="text" name="accommodations[${rowIndex}][total_cost]" class="block w-full border-gray-300 rounded-md shadow-sm total-cost text-center" readonly required>
                        </td>

                        <td class="px-4 py-2">
                            <button type="button" class="bg-red-500 text-white px-3 py-1 rounded remove-row">X</button>
                        </td>
                    </tr>
                `;
                document.querySelector("#accommodation-rows").insertAdjacentHTML("beforeend", rowHtml);
            }

            document.getElementById("add-hotel").addEventListener("click", addAccommodationRow);

            document.addEventListener("change", function (e) {
                if (e.target.classList.contains("room-type-select")) {
                    let cost = e.target.options[e.target.selectedIndex].getAttribute("data-cost");
                    let row = e.target.closest("tr");
                    row.querySelector(".per-night-cost").value = cost;

                    let nights = row.querySelector(".total-nights").value;
                    if (nights) {
                        row.querySelector(".total-cost").value = (parseFloat(cost) * parseInt(nights)).toFixed(2);
                    }
                }
            });

            document.addEventListener("input", function (e) {
                if (e.target.classList.contains("total-nights")) {
                    let row = e.target.closest("tr");
                    let cost = row.querySelector(".per-night-cost").value;
                    if (cost) {
                        row.querySelector(".total-cost").value = (parseFloat(cost) * parseInt(e.target.value)).toFixed(2);
                    }
                }
            });

            document.addEventListener("click", function (e) {
                if (e.target.classList.contains("remove-row")) {
                    e.target.closest("tr").remove();
                }
            });

            addAccommodationRow();
        });
    </script>
</x-app-layout>
