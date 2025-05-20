<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
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
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_two', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </a>
                </li>

                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_three', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Accommodation
                    </a>
                </li>

                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_four', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan</span>
                    </a>
                </li>

                <li class="flex items-center">
                    <a href="{{ route('quotations.edit_step_five', $quotation->id) }}" class="flex items-center">
                        <span class="me-2">5</span>
                        Site <span class="hidden sm:inline-flex ">|Extra</span>
                    </a>
                </li>
            </ol>
        </div>

        @if (count($errors->all()) > 0)
            <div class="mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">Please correct the following errors:</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <p class="text-gray-700 mt-10 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.update_step_four', $quotation->id) }} " id="travelPlanForm">
            @csrf
            @method('PUT')

            <div id="travel-plan-section">
                @foreach ($quotation->travelPlans as $index => $travelPlan)
                    <div class="travel-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                        <button type="button"
                            class="remove-travel absolute top-2 right-2 text-red-500 hover:text-red-700">
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
                                    <input type="date" name="travel[{{ $index }}][start_date]"
                                        value="{{ $travelPlan->start_date }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <input type="date" name="travel[{{ $index }}][end_date]"
                                        value="{{ $travelPlan->end_date }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>
                            </div>

                            <!-- Route -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Route</label>
                                <select name="travel[{{ $index }}][route_id]"
                                    class="route-select block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Select Route</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id }}" data-mileage="{{ $route->mileage }}"
                                            {{ $travelPlan->route_id == $route->id ? 'selected' : '' }}>
                                            {{ $route->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Vehicle Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                                <select name="travel[{{ $index }}][vehicle_type_id]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
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
                                <input type="number" name="travel[{{ $index }}][mileage]"
                                    value="{{ $travelPlan->mileage }}"
                                    class="mileage-input block w-full border-gray-300 rounded-md shadow-sm" readonly>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add Another Travel Plan Button -->
            <button type="button" id="add-travel"
                class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                + Add Another Travel Plan
            </button>

            <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
                <div class="mt-8">
                    <div class="flex items-center mb-4">
                        <h3 class="text-lg font-semibold">Jeep Charges</h3>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" id="enableJeepCharges" name="enable_jeep_charges" value="1"
                                {{ $quotation->jeepCharges->count() > 0 ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900">Enable Jeep Charges</span>
                        </label>
                    </div>

                    <div id="jeepChargesSection" class="{{ $quotation->jeepCharges->count() > 0 ? '' : 'hidden' }}">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Pax Range</th>
                                        <th class="px-4 py-2">Unit Price (US$)</th>
                                        <th class="px-4 py-2">Quantity</th>
                                        <th class="px-4 py-2">Total Price (US$)</th>
                                        <th class="px-4 py-2">Per Person (US$)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotation->paxSlabs as $paxSlab)
                                        @php
                                            $jeepCharge = $quotation->jeepCharges
                                                ->where('pax_range', $paxSlab->paxSlab->name)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-2">
                                                <input type="text"
                                                    name="jeep_charges[{{ $loop->index }}][pax_range]"
                                                    value="{{ $paxSlab->paxSlab->name }}"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm" readonly>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number" step="0.01"
                                                    name="jeep_charges[{{ $loop->index }}][unit_price]"
                                                    value="{{ $jeepCharge->unit_price ?? '' }}"
                                                    class="jeep-unit-price block w-full border-gray-300 rounded-md shadow-sm">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number"
                                                    name="jeep_charges[{{ $loop->index }}][quantity]"
                                                    value="{{ $jeepCharge->quantity ?? '' }}"
                                                    class="jeep-quantity block w-full border-gray-300 rounded-md shadow-sm">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number" step="0.01"
                                                    name="jeep_charges[{{ $loop->index }}][total_price]"
                                                    value="{{ $jeepCharge->total_price ?? '' }}"
                                                    class="jeep-total-price block w-full border-gray-300 rounded-md shadow-sm"
                                                    readonly>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number" step="0.01"
                                                    name="jeep_charges[{{ $loop->index }}][per_person]"
                                                    value="{{ $jeepCharge->per_person ?? '' }}"
                                                    class="jeep-per-person block w-full border-gray-300 rounded-md shadow-sm"
                                                    data-min-pax="{{ $paxSlab->paxSlab->min_pax }}" readonly>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($quotation->paxSlabs->isEmpty())
                                        <tr>
                                            <td colspan="5" class="px-4 py-2 text-center">
                                                <p class="text-gray-500">No Jeep Charges inputs available. Please
                                                    Complete Pax Slabs Details.</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add this after the existing Jeep Charges section -->
            <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
                <div class="mt-8">
                    <div class="flex items-center mb-4">
                        <h3 class="text-lg font-semibold">Route-specific Jeep Charges</h3>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" id="enableRouteJeepCharges" name="enable_route_jeep_charges"
                                value="1"
                                {{ $quotation->jeepCharges->where('travel_plan_id', '!=', null)->count() > 0 ? 'checked' : '' }}
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900">Enable Route-specific Jeep
                                Charges</span>
                        </label>
                    </div>

                    <div id="routeJeepChargesSection"
    class="{{ $quotation->jeepCharges->where('travel_plan_id', '!=', null)->count() > 0 ? '' : 'hidden' }}">
    <div id="route-jeep-charges-container">
        @foreach ($quotation->travelPlans as $travelIndex => $travelPlan)
            <div class="bg-gray-100 p-4 rounded-lg mb-4 route-jeep-charge-entry" data-travel-index="{{ $travelIndex }}">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-medium">Jeep Charges for Route: {{ $travelPlan->route->name }}</h4>
                    <button type="button" class="remove-route-jeep-charge text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <input type="hidden" name="route_jeep_charges[{{ $travelIndex }}][route_id]"
                    value="{{ $travelPlan->route_id }}">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Pax Range</th>
                            <th class="px-4 py-2">Unit Price (US$)</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Total Price (US$)</th>
                            <th class="px-4 py-2">Per Person (US$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotation->paxSlabs as $paxSlabIndex => $paxSlab)
                            @php
                                $routeJeepCharge = $quotation->jeepCharges
                                    ->where('travel_plan_id', $travelPlan->id)
                                    ->where('pax_range', $paxSlab->paxSlab->name)
                                    ->first();
                            @endphp
                            <tr>
                                <td class="px-4 py-2">
                                    <input type="text"
                                        name="route_jeep_charges[{{ $travelIndex }}][charges][{{ $paxSlabIndex }}][pax_range]"
                                        value="{{ $paxSlab->paxSlab->name }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm"
                                        readonly>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" step="0.01"
                                        name="route_jeep_charges[{{ $travelIndex }}][charges][{{ $paxSlabIndex }}][unit_price]"
                                        value="{{ $routeJeepCharge->unit_price ?? '' }}"
                                        class="route-jeep-unit-price block w-full border-gray-300 rounded-md shadow-sm">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number"
                                        name="route_jeep_charges[{{ $travelIndex }}][charges][{{ $paxSlabIndex }}][quantity]"
                                        value="{{ $routeJeepCharge->quantity ?? '' }}"
                                        class="route-jeep-quantity block w-full border-gray-300 rounded-md shadow-sm">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" step="0.01"
                                        name="route_jeep_charges[{{ $travelIndex }}][charges][{{ $paxSlabIndex }}][total_price]"
                                        value="{{ $routeJeepCharge->total_price ?? '' }}"
                                        class="route-jeep-total-price block w-full border-gray-300 rounded-md shadow-sm"
                                        readonly>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" step="0.01"
                                        name="route_jeep_charges[{{ $travelIndex }}][charges][{{ $paxSlabIndex }}][per_person]"
                                        value="{{ $routeJeepCharge->per_person ?? '' }}"
                                        class="route-jeep-per-person block w-full border-gray-300 rounded-md shadow-sm"
                                        data-min-pax="{{ $paxSlab->paxSlab->min_pax }}" readonly>
                                </td>
                            </tr>
                        @endforeach

                        @if ($quotation->paxSlabs->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center">
                                    <p class="text-gray-500">No Route Jeep Charges inputs
                                        available. Please Complete Pax Slabs Details.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>
                </div>
            </div>

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
            let travelIndex = {{ count($quotation->travelPlans) }};
            const quotationStartDate = "{{ $quotation->start_date }}";
            const quotationEndDate = "{{ $quotation->end_date }}";

            // Initialize existing entries or create new one if empty
            const existingEntries = document.querySelectorAll('.travel-entry');
            if (existingEntries.length > 0) {
                existingEntries.forEach(entry => {
                    setMinDates(entry);
                    initializeRouteSelect(entry);
                });
            } else {
                // Add initial empty travel plan if none exists
                addNewTravelPlan();
            }

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
                    return;
                }

                if (startDateInput.value && endDateInput.value) {
                    if (checkDateOverlap(
                            startDateInput.value,
                            endDateInput.value,
                            input.closest('.travel-entry')
                        )) {
                        alert('Travel dates cannot overlap with other travel plans');
                        input.value = '';
                        return;
                    }
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

            function addNewTravelPlan() {
                const template = `
            <div class="travel-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                <button type="button" class="remove-travel absolute top-2 right-2 text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="date" name="travel[${travelIndex}][start_date]" 
                                class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <input type="date" name="travel[${travelIndex}][end_date]" 
                                class="block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Route</label>
                        <select name="travel[${travelIndex}][route_id]" class="route-select block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Route</option>
                            ${generateRouteOptions()}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                        <select name="travel[${travelIndex}][vehicle_type_id]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Vehicle</option>
                            ${generateVehicleOptions()}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mileage</label>
                        <input type="number" name="travel[${travelIndex}][mileage]" class="mileage-input block w-full border-gray-300 rounded-md shadow-sm" readonly>
                    </div>
                </div>
            </div>
        `;

                const travelSection = document.getElementById('travel-plan-section');
                travelSection.insertAdjacentHTML('beforeend', template);

                const newEntry = travelSection.lastElementChild;
                setMinDates(newEntry);
                initializeRouteSelect(newEntry);
                travelIndex++;
            }

            function generateRouteOptions() {
                return `
            @foreach ($routes as $route)
                <option value="{{ $route->id }}" data-mileage="{{ $route->mileage }}">
                    {{ $route->name }}
                </option>
            @endforeach
        `;
            }

            function generateVehicleOptions() {
                return `
            @foreach ($vehicleTypes as $vehicleType)
                <option value="{{ $vehicleType->id }}">
                    {{ $vehicleType->name }}
                </option>
            @endforeach
        `;
            }

            // Add event listeners
            document.getElementById('add-travel').addEventListener('click', addNewTravelPlan);

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

            document.getElementById('travelPlanForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const travelEntries = document.querySelectorAll('.travel-entry');
                let dates = [];



                for (let entry of travelEntries) {
                    const startInput = entry.querySelector('input[name*="start_date"]');
                    const endInput = entry.querySelector('input[name*="end_date"]');

                    if (!startInput.value || !endInput.value) {
                        alert('Please fill in all date fields');
                        return false;
                    }

                    dates.push({
                        start: new Date(startInput.value),
                        end: new Date(endInput.value)
                    });
                }

                dates.sort((a, b) => a.start - b.start);

                const qStart = new Date(quotationStartDate);
                const qEnd = new Date(quotationEndDate);
                qStart.setHours(0, 0, 0, 0);
                qEnd.setHours(0, 0, 0, 0);

                const firstStart = new Date(dates[0].start);
                firstStart.setHours(0, 0, 0, 0);
                if (firstStart.getTime() !== qStart.getTime()) {
                    alert(`First travel plan must start on quotation start date (${quotationStartDate})`);
                    return false;
                }

                const lastEnd = new Date(dates[dates.length - 1].end);
                lastEnd.setHours(0, 0, 0, 0);
                if (lastEnd.getTime() !== qEnd.getTime()) {
                    alert(`Last travel plan must end on quotation end date (${quotationEndDate})`);
                    return false;
                }



                this.submit();
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const enableJeepCharges = document.getElementById('enableJeepCharges');
            const jeepChargesSection = document.getElementById('jeepChargesSection');
            const travelPlanForm = document.getElementById('travelPlanForm');

            if (enableJeepCharges && jeepChargesSection) {
                // Create hidden input for enable_jeep_charges if it doesn't exist
                let hiddenInput = document.querySelector('input[name="enable_jeep_charges"][type="hidden"]');
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'enable_jeep_charges';
                    travelPlanForm.appendChild(hiddenInput);
                }

                // Set initial value
                hiddenInput.value = enableJeepCharges.checked ? '1' : '0';

                // Set initial state
                jeepChargesSection.classList.toggle('hidden', !enableJeepCharges.checked);

                // Initialize inputs with default values when no existing data
                if (enableJeepCharges.checked) {
                    initializeEmptyInputs();
                }

                // Toggle visibility and update hidden input on checkbox change
                enableJeepCharges.addEventListener('change', function() {
                    jeepChargesSection.classList.toggle('hidden', !this.checked);
                    hiddenInput.value = this.checked ? '1' : '0';

                    // Initialize or clear inputs
                    if (this.checked) {
                        initializeEmptyInputs();
                    } else {
                        const jeepRows = jeepChargesSection.querySelectorAll('tbody tr');
                        jeepRows.forEach(row => {
                            row.querySelectorAll('input:not([readonly])').forEach(input => {
                                if (!input.name.includes('pax_range')) {
                                    input.value = '';
                                }
                            });
                        });
                    }
                });

                // Function to initialize empty inputs with default values
                function initializeEmptyInputs() {
                    const jeepRows = jeepChargesSection.querySelectorAll('tbody tr');
                    jeepRows.forEach(row => {
                        const unitPriceInput = row.querySelector('.jeep-unit-price');
                        const quantityInput = row.querySelector('.jeep-quantity');
                        const totalPriceInput = row.querySelector('.jeep-total-price');
                        const perPersonInput = row.querySelector('.jeep-per-person');

                        // Only set defaults if values are empty
                        if (!unitPriceInput.value) unitPriceInput.value = '0';
                        if (!quantityInput.value) quantityInput.value = '0';
                        if (!totalPriceInput.value) totalPriceInput.value = '0.00';
                        if (!perPersonInput.value) perPersonInput.value = '0.00';

                        // Calculate totals
                        calculateRowTotals(row);
                    });
                }

                // Set up calculations for each row
                const jeepRows = jeepChargesSection.querySelectorAll('tbody tr');
                jeepRows.forEach(row => {
                    initializeJeepRow(row);
                });

                function initializeJeepRow(row) {
                    const unitPriceInput = row.querySelector('.jeep-unit-price');
                    const quantityInput = row.querySelector('.jeep-quantity');

                    if (unitPriceInput && quantityInput) {
                        unitPriceInput.addEventListener('input', () => calculateRowTotals(row));
                        quantityInput.addEventListener('input', () => calculateRowTotals(row));
                    }
                }

                function calculateRowTotals(row) {
                    if (!enableJeepCharges.checked) return;

                    const unitPriceInput = row.querySelector('.jeep-unit-price');
                    const quantityInput = row.querySelector('.jeep-quantity');
                    const totalPriceInput = row.querySelector('.jeep-total-price');
                    const perPersonInput = row.querySelector('.jeep-per-person');

                    const unitPrice = parseFloat(unitPriceInput.value) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    const minPax = parseInt(perPersonInput.dataset.minPax) || 1;

                    const totalPrice = unitPrice * quantity;
                    totalPriceInput.value = totalPrice.toFixed(2);

                    const perPerson = totalPrice / minPax;
                    perPersonInput.value = perPerson.toFixed(2);
                }
            }
        });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const enableRouteJeepCharges = document.getElementById('enableRouteJeepCharges');
        const routeJeepChargesSection = document.getElementById('routeJeepChargesSection');
        const routeJeepChargesContainer = document.getElementById('route-jeep-charges-container');
        const travelPlanForm = document.getElementById('travelPlanForm');

        if (enableRouteJeepCharges && routeJeepChargesSection) {
            // Create hidden input for enable_route_jeep_charges if it doesn't exist
            let hiddenInput = document.querySelector('input[name="enable_route_jeep_charges"][type="hidden"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'enable_route_jeep_charges';
                travelPlanForm.appendChild(hiddenInput);
            }

            // Set initial value
            hiddenInput.value = enableRouteJeepCharges.checked ? '1' : '0';

            // Set initial state
            routeJeepChargesSection.classList.toggle('hidden', !enableRouteJeepCharges.checked);

            // Toggle visibility and update hidden input on checkbox change
            enableRouteJeepCharges.addEventListener('change', function() {
                routeJeepChargesSection.classList.toggle('hidden', !this.checked);
                hiddenInput.value = this.checked ? '1' : '0';

                // Initialize or clear inputs
                if (this.checked) {
                    // Generate route-specific jeep charge tables for each travel plan
                    generateRouteJeepChargeTables();
                } else {
                    // Clear all route-specific jeep charges
                    routeJeepChargesContainer.innerHTML = '';
                }
            });

            // Initialize calculations for route-specific jeep charges
            initRouteJeepCalculations();

            // Function to regenerate route-specific jeep charge tables
            function generateRouteJeepChargeTables() {
                if (!enableRouteJeepCharges.checked) return;

                routeJeepChargesContainer.innerHTML = '';
                const travelEntries = document.querySelectorAll('.travel-entry');

                travelEntries.forEach((entry, travelIndex) => {
                    const routeSelect = entry.querySelector('.route-select');
                    const routeId = routeSelect.value;
                    const routeName = routeSelect.options[routeSelect.selectedIndex]?.text ||
                        'Unknown Route';

                    if (!routeId) return; // Skip if no route is selected

                    // Create a table for this route
                    const routeTableHtml = `
                    <div class="bg-gray-100 p-4 rounded-lg mb-4 route-jeep-charge-entry" data-travel-index="${travelIndex}">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-medium">Jeep Charges for Route: ${routeName}</h4>
                            <button type="button" class="remove-route-jeep-charge text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <input type="hidden" name="route_jeep_charges[${travelIndex}][route_id]" value="${routeId}">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Pax Range</th>
                                    <th class="px-4 py-2">Unit Price (US$)</th>
                                    <th class="px-4 py-2">Quantity</th>
                                    <th class="px-4 py-2">Total Price (US$)</th>
                                    <th class="px-4 py-2">Per Person (US$)</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${generatePaxRows(travelIndex)}
                            </tbody>
                        </table>
                    </div>
                `;

                    routeJeepChargesContainer.insertAdjacentHTML('beforeend', routeTableHtml);
                });
                
                // Add event listeners for removal buttons
                addRouteJeepChargeRemovalListeners();
                
                // Set up calculations for all the newly created tables
                initRouteJeepCalculations();
            }
            
            // Function to add event listeners for remove buttons
            function addRouteJeepChargeRemovalListeners() {
                const removeButtons = routeJeepChargesContainer.querySelectorAll('.remove-route-jeep-charge');
                removeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const chargeEntry = this.closest('.route-jeep-charge-entry');
                        if (chargeEntry) {
                            // Get the travel index to update hidden inputs if needed
                            const travelIndex = chargeEntry.dataset.travelIndex;
                            
                            // Add a hidden input to mark this route charge as removed in the backend
                            const removeInput = document.createElement('input');
                            removeInput.type = 'hidden';
                            removeInput.name = `remove_route_jeep_charge[${travelIndex}]`;
                            removeInput.value = '1';
                            travelPlanForm.appendChild(removeInput);
                            
                            // Remove the charge entry from DOM
                            chargeEntry.remove();
                            
                            // If no more route charges, disable the checkbox
                            if (routeJeepChargesContainer.querySelectorAll('.route-jeep-charge-entry').length === 0) {
                                enableRouteJeepCharges.checked = false;
                                routeJeepChargesSection.classList.add('hidden');
                                hiddenInput.value = '0';
                            }
                        }
                    });
                });
            }

            // Function to generate pax rows for a route table
            function generatePaxRows(travelIndex) {
                let rowsHtml = '';

                @foreach ($quotation->paxSlabs as $paxSlabIndex => $paxSlab)
                    rowsHtml += `
                    <tr>
                        <td class="px-4 py-2">
                            <input type="text"
                                name="route_jeep_charges[${travelIndex}][charges][{{ $paxSlabIndex }}][pax_range]"
                                value="{{ $paxSlab->paxSlab->name }}"
                                class="block w-full border-gray-300 rounded-md shadow-sm" readonly>
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" step="0.01"
                                name="route_jeep_charges[${travelIndex}][charges][{{ $paxSlabIndex }}][unit_price]"
                                value="0"
                                class="route-jeep-unit-price block w-full border-gray-300 rounded-md shadow-sm">
                        </td>
                        <td class="px-4 py-2">
                            <input type="number"
                                name="route_jeep_charges[${travelIndex}][charges][{{ $paxSlabIndex }}][quantity]"
                                value="0"
                                class="route-jeep-quantity block w-full border-gray-300 rounded-md shadow-sm">
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" step="0.01"
                                name="route_jeep_charges[${travelIndex}][charges][{{ $paxSlabIndex }}][total_price]"
                                value="0.00"
                                class="route-jeep-total-price block w-full border-gray-300 rounded-md shadow-sm"
                                readonly>
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" step="0.01"
                                name="route_jeep_charges[${travelIndex}][charges][{{ $paxSlabIndex }}][per_person]"
                                value="0.00"
                                class="route-jeep-per-person block w-full border-gray-300 rounded-md shadow-sm"
                                data-min-pax="{{ $paxSlab->paxSlab->min_pax }}" readonly>
                        </td>
                    </tr>
                `;
                @endforeach

                @if ($quotation->paxSlabs->isEmpty())
                    rowsHtml += `
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">
                            <p class="text-gray-500">No Route Jeep Charges inputs available. Please Complete Pax Slabs Details.</p>
                        </td>
                    </tr>
                `;
                @endif

                return rowsHtml;
            }

            // Initialize route jeep charge calculations
            function initRouteJeepCalculations() {
                const routeJeepRows = routeJeepChargesSection.querySelectorAll('tbody tr');

                routeJeepRows.forEach(row => {
                    initializeRouteJeepRow(row);
                });
            }

            // Initialize existing route-specific jeep charges with removal buttons
            function initializeExistingRouteJeepCharges() {
                const existingEntries = document.querySelectorAll('.route-jeep-charge-entry');
                
                existingEntries.forEach((entry, index) => {
                    // Add remove button if it doesn't exist
                    if (!entry.querySelector('.remove-route-jeep-charge')) {
                        const heading = entry.querySelector('h4');
                        if (heading) {
                            // Create wrapper div for heading and button
                            const wrapper = document.createElement('div');
                            wrapper.className = 'flex justify-between items-center mb-2';
                            
                            // Move heading to wrapper
                            heading.parentNode.insertBefore(wrapper, heading);
                            wrapper.appendChild(heading);
                            
                            // Add remove button
                            const removeButton = document.createElement('button');
                            removeButton.type = 'button';
                            removeButton.className = 'remove-route-jeep-charge text-red-500 hover:text-red-700';
                            removeButton.innerHTML = `
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            `;
                            wrapper.appendChild(removeButton);
                        }
                    }
                });
                
                // Add event listeners for the remove buttons
                addRouteJeepChargeRemovalListeners();
            }

            function initializeRouteJeepRow(row) {
                const unitPriceInput = row.querySelector('.route-jeep-unit-price');
                const quantityInput = row.querySelector('.route-jeep-quantity');

                if (unitPriceInput && quantityInput) {
                    unitPriceInput.addEventListener('input', () => calculateRouteRowTotals(row));
                    quantityInput.addEventListener('input', () => calculateRouteRowTotals(row));
                }
            }

            function calculateRouteRowTotals(row) {
                if (!enableRouteJeepCharges.checked) return;

                const unitPriceInput = row.querySelector('.route-jeep-unit-price');
                const quantityInput = row.querySelector('.route-jeep-quantity');
                const totalPriceInput = row.querySelector('.route-jeep-total-price');
                const perPersonInput = row.querySelector('.route-jeep-per-person');

                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const minPax = parseInt(perPersonInput.dataset.minPax) || 1;

                const totalPrice = unitPrice * quantity;
                totalPriceInput.value = totalPrice.toFixed(2);

                const perPerson = totalPrice / minPax;
                perPersonInput.value = perPerson.toFixed(2);
            }

            // Update route jeep charges when travel plans change
            function checkTravelPlanChanges() {
                // Add event listeners for travel plan changes
                document.getElementById('add-travel').addEventListener('click', function() {
                    if (enableRouteJeepCharges.checked) {
                        // Wait for DOM to update with new travel entry
                        setTimeout(() => {
                            generateRouteJeepChargeTables();
                        }, 100);
                    }
                });

                // Listen for route selection changes
                document.addEventListener('change', function(event) {
                    if (event.target.classList.contains('route-select') && enableRouteJeepCharges.checked) {
                        generateRouteJeepChargeTables();
                    }
                });

                // Listen for travel plan removal
                document.addEventListener('click', function(event) {
                    if (event.target.closest('.remove-travel') && enableRouteJeepCharges.checked) {
                        // Wait for DOM to update after removal
                        setTimeout(() => {
                            generateRouteJeepChargeTables();
                        }, 100);
                    }
                });
            }

            // Call this to set up event listeners for travel plan changes
            checkTravelPlanChanges();
            
            // Initialize existing entries with remove buttons
            initializeExistingRouteJeepCharges();
        }
    });
</script>


</x-app-layout>
