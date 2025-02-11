<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">

        <!-- Progress Bar  -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Reference <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </span>
                </li>
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </span>
                </li>

                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
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
                <li class="flex items-center text-blue-600 test:text-blue-500">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    Travel <span class="hidden sm:inline-flex sm:ms-2"> Plan </span>
                </li>
            </ol>
        </div>

        <p class="text-gray-700 mt-10 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step4.store', $quotation->id) }}">
            @csrf

            <div id="travel-plan-section">
                <div class="travel-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                    <button type="button" class="remove-travel absolute top-2 right-2 text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" name="travel[0][start_date]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <input type="date" name="travel[0][end_date]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <!-- Route -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Route</label>
                            <select name="travel[0][route_id]"
                                class="route-select block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Route</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}" data-mileage="{{ $route->mileage }}">
                                        {{ $route->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Vehicle Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                            <select name="travel[0][vehicle_type_id]"
                                class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Vehicle</option>
                                @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mileage -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mileage</label>
                            <input type="number" name="travel[0][mileage]"
                                class="mileage-input block w-full border-gray-300 rounded-md shadow-sm" readonly>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- Add Another Travel Plan Button -->
    <button type="button" id="add-travel" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">+
        Add Another Travel
        Plan</button>

    <div class="flex justify-between mt-6">
        <a href="{{ route('quotations.edit_step_three', $quotation->id) }}"
            class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back</a>
        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Save &
            Next</button>
    </div>
    </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let travelIndex = 1;
            const quotationStartDate = "{{ $quotation->start_date }}";
        const quotationEndDate = "{{ $quotation->end_date }}";

        // Function to set min/max dates for date inputs
        function setMinDates(container) {
            const startDateInput = container.querySelector('input[name*="start_date"]');
            const endDateInput = container.querySelector('input[name*="end_date"]');

            // Set min and max dates based on quotation date range
            startDateInput.min = quotationStartDate;
            startDateInput.max = quotationEndDate;
            endDateInput.min = quotationStartDate;
            endDateInput.max = quotationEndDate;

            // When start date changes, update end date constraints
            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    endDateInput.min = this.value;
                    if (endDateInput.value && new Date(endDateInput.value) < new Date(this.value)) {
                        endDateInput.value = this.value;
                    }
                }

                // Validate against quotation date range
                const selectedDate = new Date(this.value);
                const qStartDate = new Date(quotationStartDate);
                const qEndDate = new Date(quotationEndDate);

                if (selectedDate < qStartDate || selectedDate > qEndDate) {
                    alert('Travel dates must be within the quotation date range');
                    this.value = '';
                    return;
                }
            });

            // When end date changes, validate against quotation range
            endDateInput.addEventListener('change', function() {
                if (this.value) {
                    startDateInput.max = this.value;
                    
                    // Validate against quotation date range
                    const selectedDate = new Date(this.value);
                    const qStartDate = new Date(quotationStartDate);
                    const qEndDate = new Date(quotationEndDate);

                    if (selectedDate < qStartDate || selectedDate > qEndDate) {
                        alert('Travel dates must be within the quotation date range');
                        this.value = '';
                        return;
                    }

                    // Validate end date is after start date
                    if (startDateInput.value && selectedDate < new Date(startDateInput.value)) {
                        alert('End date must be after start date');
                        this.value = '';
                        return;
                    }
                }
            });
        }

        // Rest of your existing code...
        function addTravelEntry() {
            let newTravel = document.querySelector(".travel-entry").cloneNode(true);

            // Clear values and update indexes
            newTravel.querySelectorAll("select, input").forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, "[" + travelIndex + "]");
                input.value = "";
            });

            // Append new entry
            document.querySelector("#travel-plan-section").appendChild(newTravel);

            // Set min/max dates for the new entry
            setMinDates(newTravel);

            // Attach event listener to the new route dropdown
            newTravel.querySelector(".route-select").addEventListener("change", function() {
                let mileage = this.options[this.selectedIndex].getAttribute("data-mileage");
                this.closest(".travel-entry").querySelector(".mileage-input").value = mileage;
            });

            travelIndex++;
        }

        // Initialize min dates for the first travel entry
        setMinDates(document.querySelector(".travel-entry"));


            // Add remove travel plan functionality
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-travel')) {
                    const travelEntry = e.target.closest('.travel-entry');
                    if (document.querySelectorAll('.travel-entry').length > 1) {
                        travelEntry.remove();
                    } else {
                        alert('At least one travel plan is required.');
                    }
                }
            });

            // Initialize min dates for the first travel entry
            setMinDates(document.querySelector(".travel-entry"));

            // Attach event listener to "Add Travel" button
            document.querySelector("#add-travel").addEventListener("click", addTravelEntry);

            // Attach event listener to existing route dropdowns
            document.querySelectorAll(".route-select").forEach(select => {
                select.addEventListener("change", function() {
                    let mileage = this.options[this.selectedIndex].getAttribute("data-mileage");
                    this.closest(".travel-entry").querySelector(".mileage-input").value = mileage;
                });
            });
        });
    </script>

</x-app-layout>
