<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Step 4: Travel Plan</h2>
        <p class="text-gray-700">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step4.store', $quotation->id) }}">
            @csrf

            <div id="travel-plan-section">
                <div class="travel-entry border p-4 rounded-lg mb-4 bg-gray-100">
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" name="travel[0][start_date]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <input type="date" name="travel[0][end_date]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <!-- Route -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Route</label>
                            <select name="travel[0][route_id]" class="route-select block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Route</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}" data-mileage="{{ $route->mileage }}">{{ $route->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Vehicle Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                            <select name="travel[0][vehicle_type_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Vehicle</option>
                                @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mileage -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mileage</label>
                            <input type="number" name="travel[0][mileage]" class="mileage-input block w-full border-gray-300 rounded-md shadow-sm" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Another Travel Plan Button -->
            <button type="button" id="add-travel" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">+ Add Another Travel Plan</button>

            <div class="flex justify-between mt-6">
                <a href="{{ route('quotations.step3', $quotation->id) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back</a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Save & Next</button>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let travelIndex = 1;

        function addTravelEntry() {
            let newTravel = document.querySelector(".travel-entry").cloneNode(true);

            // Clear values and update indexes
            newTravel.querySelectorAll("select, input").forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, "[" + travelIndex + "]");
                input.value = "";
            });

            // Append new entry
            document.querySelector("#travel-plan-section").appendChild(newTravel);

            // Attach event listener to the new route dropdown
            newTravel.querySelector(".route-select").addEventListener("change", function () {
                let mileage = this.options[this.selectedIndex].getAttribute("data-mileage");
                this.closest(".travel-entry").querySelector(".mileage-input").value = mileage;
            });

            travelIndex++;
        }

        // Attach event listener to "Add Travel" button
        document.querySelector("#add-travel").addEventListener("click", addTravelEntry);

        // Attach event listener to existing route dropdowns
        document.querySelectorAll(".route-select").forEach(select => {
            select.addEventListener("change", function () {
                let mileage = this.options[this.selectedIndex].getAttribute("data-mileage");
                this.closest(".travel-entry").querySelector(".mileage-input").value = mileage;
            });
        });
    });
</script>

</x-app-layout>
