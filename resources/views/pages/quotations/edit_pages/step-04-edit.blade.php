<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar -->
        <div>
            <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <!-- Same progress bar as step4.blade.php -->
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <!-- ... First step ... -->
                </li>
                <li class="flex md:w-full items-center text-blue-600">
                    <!-- ... Second step ... -->
                </li>
                <li class="flex md:w-full items-center text-blue-600">
                    <!-- ... Third step ... -->
                </li>
                <li class="flex items-center text-blue-600">
                    <!-- ... Fourth step ... -->
                </li>
            </ol>
        </div>

        <p class="text-gray-700 mt-10 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.update_step_four', $quotation->id) }}">
            @csrf
            @method('PUT')

            <div id="travel-plan-section">
                @foreach($quotation->travelPlans as $index => $travelPlan)
                <div class="travel-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                    <button type="button" class="remove-travel absolute top-2 right-2 text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" 
                                    name="travel[{{ $index }}][start_date]" 
                                    value="{{ $travelPlan->start_date }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" 
                                    required>
                                <input type="date" 
                                    name="travel[{{ $index }}][end_date]" 
                                    value="{{ $travelPlan->end_date }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" 
                                    required>
                            </div>
                        </div>

                        <!-- Route -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Route</label>
                            <select name="travel[{{ $index }}][route_id]" class="route-select block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Route</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}" 
                                        data-mileage="{{ $route->mileage }}"
                                        {{ $travelPlan->route_id == $route->id ? 'selected' : '' }}>
                                        {{ $route->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Vehicle Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                            <select name="travel[{{ $index }}][vehicle_type_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Vehicle</option>
                                @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{ $vehicleType->id }}"
                                        {{ $travelPlan->vehicle_type_id == $vehicleType->id ? 'selected' : '' }}>
                                        {{ $vehicleType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mileage -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mileage</label>
                            <input type="number" 
                                name="travel[{{ $index }}][mileage]" 
                                value="{{ $travelPlan->mileage }}"
                                class="mileage-input block w-full border-gray-300 rounded-md shadow-sm" 
                                readonly>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Add Another Travel Plan Button -->
            <button type="button" id="add-travel" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                + Add Another Travel Plan
            </button>

            <div class="flex justify-between mt-6">
                <a href="{{ route('quotations.edit_step_three', $quotation->id) }}" 
                    class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Update & Next
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let travelIndex = {{ count($quotation->travelPlans) }};
            const quotationStartDate = "{{ $quotation->start_date }}";
            const quotationEndDate = "{{ $quotation->end_date }}";

            // Initialize existing entries
            document.querySelectorAll('.travel-entry').forEach(entry => {
                setMinDates(entry);
                initializeRouteSelect(entry);
            });

            function setMinDates(container) {
                const startDateInput = container.querySelector('input[name*="start_date"]');
                const endDateInput = container.querySelector('input[name*="end_date"]');

                startDateInput.min = quotationStartDate;
                startDateInput.max = quotationEndDate;
                endDateInput.min = quotationStartDate;
                endDateInput.max = quotationEndDate;

                startDateInput.addEventListener('change', function() {
                    if (this.value) {
                        endDateInput.min = this.value;
                        validateDateRange(this, startDateInput, endDateInput);
                    }
                });

                endDateInput.addEventListener('change', function() {
                    if (this.value) {
                        startDateInput.max = this.value;
                        validateDateRange(this, startDateInput, endDateInput);
                    }
                });
            }

            function validateDateRange(input, startDateInput, endDateInput) {
                const selectedDate = new Date(input.value);
                const qStartDate = new Date(quotationStartDate);
                const qEndDate = new Date(quotationEndDate);

                if (selectedDate < qStartDate || selectedDate > qEndDate) {
                    alert('Travel dates must be within the quotation date range');
                    input.value = '';
                    return;
                }

                if (input === endDateInput && startDateInput.value && 
                    selectedDate < new Date(startDateInput.value)) {
                    alert('End date must be after start date');
                    input.value = '';
                }
            }

            function initializeRouteSelect(container) {
                const routeSelect = container.querySelector('.route-select');
                const mileageInput = container.querySelector('.mileage-input');

                routeSelect.addEventListener('change', function() {
                    const mileage = this.options[this.selectedIndex].getAttribute('data-mileage');
                    mileageInput.value = mileage || '';
                });
            }

            document.getElementById('add-travel').addEventListener('click', function() {
                const template = document.querySelector('.travel-entry').cloneNode(true);
                
                // Update indices and clear values
                template.querySelectorAll('input, select').forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, `[${travelIndex}]`);
                    input.value = '';
                    if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0;
                    }
                });

                document.getElementById('travel-plan-section').appendChild(template);
                setMinDates(template);
                initializeRouteSelect(template);
                travelIndex++;
            });

            // Remove travel plan handler
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-travel')) {
                    const travelEntry = e.target.closest('.travel-entry');
                    if (document.querySelectorAll('.travel-entry').length > 1) {
                        travelEntry.remove();
                    } else {
                        alert('At least one travel plan is required.');
                    }
                }
            });
        });
    </script>
</x-app-layout>