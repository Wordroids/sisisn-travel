<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar -->
        <div class="mb-8">
            <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base">
                <li
                    class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_01', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Basic <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </a>
                </li>
                <li
                    class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_02', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </a>
                </li>
                <li
                    class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_03', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Accommodation
                    </a>
                </li>
                <li
                    class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan</span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">5</span>
                    Site <span class="hidden sm:inline-flex sm:ms-2">|Extras</span>
                </li>
            </ol>
        </div>

        @php
            // display  all errors
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    echo "<div class='text-red-500'>$error</div>";
                }
            }
        @endphp

        <p class="text-gray-700 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('group_quotations.store_step_04', $quotation->id) }}">
            @csrf
            @method('PUT')

            <!-- Travel Plans Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Travel Itinerary</h2>
                <div id="travel-plan-section" class="space-y-6">
                    <!-- Travel plan cards will be added here -->
                </div>
                <button type="button" id="add-travel-plan"
                    class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Travel Plan Leg
                </button>
            </div>

            <!-- Hidden input for enable_route_jeep_charges -->
            <input type="hidden" name="enable_route_jeep_charges" id="enable_route_jeep_charges_input" value="0">

            <!-- Global Jeep Charges Section -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="enable-global-jeep-charges-checkbox"
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="enable-global-jeep-charges-checkbox"
                        class="ml-2 block text-sm font-medium text-gray-700">Enable Other Jeep Charges (not tied to a
                        specific route)</label>
                </div>
                <input type="hidden" name="enable_jeep_charges" id="enable_jeep_charges_input" value="0">

                <div id="global-jeep-charges-container"
                    class="hidden space-y-4 p-4 border border-gray-200 rounded-md bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Other Jeep Charges</h3>
                    <div id="global-jeep-charges-list" class="space-y-3">
                        <!-- Global jeep charge rows will be added here -->
                    </div>

                </div>
            </div>


            <div class="flex justify-between mt-10">
                <a href="{{ route('group_quotations.step_03', $quotation->id) }}"
                    class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
                    Back to Accommodation
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
            const quotationStartDate =
            "{{ $quotation->start_date ? $quotation->start_date->format('Y-m-d') : '' }}";
            const quotationEndDate = "{{ $quotation->end_date ? $quotation->end_date->format('Y-m-d') : '' }}";

            const travelRouteOptions =
                `@foreach ($travelRoutes as $route)<option value="{{ $route->id }}" data-mileage="{{ $route->mileage ?? 0 }}">{{ $route->name }}</option>@endforeach`;
            const vehicleTypeOptions =
                `@foreach ($vehicleTypes as $type)<option value="{{ $type->id }}">{{ $type->name }}</option>@endforeach`;

            const paxSlabRangesArray = @json($paxSlabRanges);
            const paxSlabRangeOptionsHTML = paxSlabRangesArray.map(range =>
                `<option value="${range}">${range}</option>`).join('');

            const existingTravelPlans = @json($quotation->travelPlans->load('jeepCharges'));
            const existingGlobalJeepCharges = @json($quotation->jeepCharges->whereNull('travel_plan_id')->values());

            const travelPlanSection = document.getElementById('travel-plan-section');
            const globalJeepChargesList = document.getElementById('global-jeep-charges-list');

            const enableGlobalJeepChargesCheckbox = document.getElementById('enable-global-jeep-charges-checkbox');
            const globalJeepChargesContainer = document.getElementById('global-jeep-charges-container');
            const enableJeepChargesInput = document.getElementById('enable_jeep_charges_input');
            const enableRouteJeepChargesInput = document.getElementById('enable_route_jeep_charges_input');
            const mainForm = document.querySelector('form'); // Get the form

            let travelPlanCounter = 0;

            function getMinPaxFromRange(paxRangeString) {
                if (!paxRangeString) return 1;
                const match = paxRangeString.match(/^(\d+)/);
                return match ? parseInt(match[1], 10) : 1;
            }

            function updateEnableRouteJeepChargesFlag() {
                let hasRouteJeepChargeEntry = false;
                document.querySelectorAll('.route-jeep-charges-list .jeep-charge-row').forEach(row => {
                    const unitPrice = parseFloat(row.querySelector('.jeep-unit-price').value) || 0;
                    const quantity = parseInt(row.querySelector('.jeep-quantity').value) || 0;
                    if (unitPrice > 0 || quantity > 0) {
                        hasRouteJeepChargeEntry = true;
                    }
                });
                enableRouteJeepChargesInput.value = hasRouteJeepChargeEntry ? "1" : "0";
            }


            function calculateJeepChargeTotals(chargeRow) {
                const unitPriceInput = chargeRow.querySelector('.jeep-unit-price');
                const quantityInput = chargeRow.querySelector('.jeep-quantity');
                const totalPriceInput = chargeRow.querySelector('.jeep-total-price');
                const perPersonPriceInput = chargeRow.querySelector('.jeep-per-person');
                const paxRangeSelect = chargeRow.querySelector('.jeep-pax-range');

                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const paxRange = paxRangeSelect ? paxRangeSelect.value : null;

                const total = unitPrice * quantity;
                totalPriceInput.value = total.toFixed(2);

                if (paxRange) {
                    const minPax = getMinPaxFromRange(paxRange);
                    if (minPax > 0 && total > 0) {
                        perPersonPriceInput.value = (total / minPax).toFixed(2);
                    } else {
                        perPersonPriceInput.value = '0.00';
                    }
                } else {
                    perPersonPriceInput.value = '0.00';
                }
                // If this is a route jeep charge, update the flag
                if (chargeRow.closest('.route-jeep-charges-list')) {
                    updateEnableRouteJeepChargesFlag();
                }
            }

            function addTravelPlanCard(existingPlan = null) {
                const planIndex = travelPlanCounter++;
                const card = document.createElement('div');
                card.className =
                    'p-4 border border-gray-300 rounded-md bg-white shadow-sm relative travel-plan-card';
                card.innerHTML = `
            <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700 remove-travel-plan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
            <h4 class="text-md font-semibold text-gray-700 mb-3">Leg #${planIndex + 1}</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="travel[${planIndex}][start_date]" class="travel-start-date mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="travel[${planIndex}][end_date]" class="travel-end-date mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Route</label>
                    <select name="travel[${planIndex}][route_id]" class="travel-route-select mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                        <option value="">Select Route</option>${travelRouteOptions}</select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                    <select name="travel[${planIndex}][vehicle_type_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                        <option value="">Select Vehicle</option>${vehicleTypeOptions}</select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mileage (km)</label>
                    <input type="number" step="0.01" name="travel[${planIndex}][mileage]" class="travel-mileage mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="0.00" required>
                </div>
            </div>
            <div class="mt-4">
                <h5 class="text-sm font-medium text-gray-600 mb-2">Jeep Charges for this Route Leg</h5>
                <div class="route-jeep-charges-list space-y-2">
                    {{-- Route-specific jeep charges will be auto-generated here --}}
                </div>
            </div>
        `;
                travelPlanSection.appendChild(card);
                initializeTravelPlanCardEvents(card, planIndex);

                const routeSelect = card.querySelector('.travel-route-select');
                const mileageInput = card.querySelector('.travel-mileage');
                const routeJeepChargesListEl = card.querySelector('.route-jeep-charges-list');
                routeJeepChargesListEl.innerHTML = '';

                paxSlabRangesArray.forEach((paxRangeStr, chargeIndex) => {
                    let chargeDataForThisRange = null;
                    if (existingPlan && existingPlan.jeep_charges) {
                        chargeDataForThisRange = existingPlan.jeep_charges.find(jc => jc.pax_range ===
                            paxRangeStr);
                    }
                    addRouteJeepChargeRow(routeJeepChargesListEl, planIndex, chargeIndex,
                        chargeDataForThisRange, paxRangeStr);
                });

                if (existingPlan) {
                    card.querySelector(`input[name="travel[${planIndex}][start_date]"]`).value = existingPlan
                        .start_date ? existingPlan.start_date.substring(0, 10) : '';
                    card.querySelector(`input[name="travel[${planIndex}][end_date]"]`).value = existingPlan
                        .end_date ? existingPlan.end_date.substring(0, 10) : '';
                    routeSelect.value = existingPlan.route_id;
                    mileageInput.value = existingPlan.mileage;
                    card.querySelector(`select[name="travel[${planIndex}][vehicle_type_id]"]`).value = existingPlan
                        .vehicle_type_id;
                }

                card.querySelectorAll('select:not(.jeep-pax-range)').forEach(selectEl => {
                    if (typeof TomSelect !== 'undefined') {
                        new TomSelect(selectEl, {
                            create: false,
                            sortField: {
                                field: "text",
                                direction: "asc"
                            }
                        });
                    }
                });
                if (existingPlan && routeSelect.tomselect) {
                    routeSelect.tomselect.setValue(existingPlan.route_id);
                }
                updateEnableRouteJeepChargesFlag(); // Initial check
            }

            function initializeTravelPlanCardEvents(card, planIndex) {
                card.querySelector('.remove-travel-plan').addEventListener('click', () => {
                    card.querySelectorAll('select:not(.jeep-pax-range)').forEach(selectEl => {
                        if (selectEl.tomselect) selectEl.tomselect.destroy();
                    });
                    card.remove();
                    updateEnableRouteJeepChargesFlag(); // Re-check after removing a plan
                });

                const startDateInput = card.querySelector('.travel-start-date');
                const endDateInput = card.querySelector('.travel-end-date');
                const routeSelect = card.querySelector('.travel-route-select');
                const mileageInput = card.querySelector('.travel-mileage');

                if (quotationStartDate) startDateInput.min = quotationStartDate;
                if (quotationEndDate) {
                    startDateInput.max = quotationEndDate;
                    endDateInput.max = quotationEndDate;
                }
                startDateInput.addEventListener('change', () => {
                    if (startDateInput.value) endDateInput.min = startDateInput.value;
                    validateTravelPlanDates(startDateInput, endDateInput);
                });
                endDateInput.addEventListener('change', () => {
                    if (endDateInput.value && startDateInput.value) startDateInput.max = endDateInput.value;
                    validateTravelPlanDates(startDateInput, endDateInput);
                });
                routeSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    mileageInput.value = selectedOption.dataset.mileage || '0.00';
                });
            }

            function validateTravelPlanDates(startDateInput, endDateInput) {
                const start = startDateInput.value;
                const end = endDateInput.value;
                if (start && end && end < start) {
                    alert('End date cannot be before start date for a travel leg.');
                    endDateInput.value = '';
                }
                if (quotationStartDate && start && start < quotationStartDate) {
                    alert('Travel leg start date cannot be before quotation start date.');
                    startDateInput.value = quotationStartDate;
                }
                if (quotationEndDate && end && end > quotationEndDate) {
                    alert('Travel leg end date cannot be after quotation end date.');
                    endDateInput.value = quotationEndDate;
                }
            }

            function addRouteJeepChargeRow(listElement, travelPlanIndex, chargeIndex, existingChargeData = null,
                specificPaxRange = null) {
                const row = document.createElement('div');
                row.className =
                    'grid grid-cols-1 sm:grid-cols-6 gap-2 items-center jeep-charge-row p-2 border rounded bg-gray-50';
                // REMOVED disabled from pax_range select, added hidden input for actual submission
                row.innerHTML = `
            <div>
                <label class="text-xs text-gray-600">Pax Range</label>
                <select class="jeep-pax-range-display mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1 bg-gray-100" disabled>
                    ${paxSlabRangeOptionsHTML}
                </select>
                <input type="hidden" name="route_jeep_charges[${travelPlanIndex}][charges][${chargeIndex}][pax_range]" class="jeep-pax-range">
            </div>
            <div>
                <label class="text-xs text-gray-600">Unit Price</label>
                <input type="number" step="0.01" name="route_jeep_charges[${travelPlanIndex}][charges][${chargeIndex}][unit_price]" class="jeep-unit-price mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1" placeholder="0.00">
            </div>
            <div>
                <label class="text-xs text-gray-600">Qty</label>
                <input type="number" name="route_jeep_charges[${travelPlanIndex}][charges][${chargeIndex}][quantity]" class="jeep-quantity mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1" placeholder="0">
            </div>
            <div>
                <label class="text-xs text-gray-600">Total</label>
                <input type="number" step="0.01" name="route_jeep_charges[${travelPlanIndex}][charges][${chargeIndex}][total_price]" class="jeep-total-price bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1" readonly>
            </div>
            <div>
                <label class="text-xs text-gray-600">Per Person</label>
                <input type="number" step="0.01" name="route_jeep_charges[${travelPlanIndex}][charges][${chargeIndex}][per_person]" class="jeep-per-person bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1" readonly>
            </div>
            <button type="button" class="remove-jeep-charge text-red-500 hover:text-red-700 self-end mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;
                listElement.appendChild(row);
                const paxRangeDisplaySelect = row.querySelector('.jeep-pax-range-display');
                const paxRangeHiddenInput = row.querySelector('.jeep-pax-range');
                if (specificPaxRange) {
                    paxRangeDisplaySelect.value = specificPaxRange;
                    paxRangeHiddenInput.value = specificPaxRange; // Sync hidden input
                }
                initializeJeepChargeRowEvents(row);

                if (existingChargeData) {
                    row.querySelector('.jeep-unit-price').value = existingChargeData.unit_price || '';
                    row.querySelector('.jeep-quantity').value = existingChargeData.quantity || '';
                }
                calculateJeepChargeTotals(row);
            }

            function populateGlobalJeepCharges() {
                globalJeepChargesList.innerHTML = '';
                paxSlabRangesArray.forEach((paxRangeStr, chargeIndex) => {
                    let chargeDataForThisRange = null;
                    if (existingGlobalJeepCharges) {
                        chargeDataForThisRange = existingGlobalJeepCharges.find(jc => jc.pax_range ===
                            paxRangeStr);
                    }
                    addGlobalJeepChargeRow(chargeIndex, chargeDataForThisRange, paxRangeStr);
                });
            }

            enableGlobalJeepChargesCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    globalJeepChargesContainer.style.display = 'block';
                    enableJeepChargesInput.value = "1";
                    populateGlobalJeepCharges();
                } else {
                    globalJeepChargesContainer.style.display = 'none';
                    enableJeepChargesInput.value = "0";
                }
            });

            function addGlobalJeepChargeRow(chargeIndex, existingChargeData = null, specificPaxRange = null) {
                const row = document.createElement('div');
                row.className =
                    'grid grid-cols-1 sm:grid-cols-6 gap-2 items-center jeep-charge-row p-2 border rounded bg-white';
                // REMOVED disabled from pax_range select, added hidden input
                row.innerHTML = `
            <div>
                <label class="text-xs text-gray-600">Pax Range</label>
                <select class="jeep-pax-range-display mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1 bg-gray-100" disabled>
                     ${paxSlabRangeOptionsHTML}
                </select>
                 <input type="hidden" name="jeep_charges[${chargeIndex}][pax_range]" class="jeep-pax-range">
            </div>
            <div>
                <label class="text-xs text-gray-600">Unit Price</label>
                <input type="number" step="0.01" name="jeep_charges[${chargeIndex}][unit_price]" class="jeep-unit-price mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1" placeholder="0.00">
            </div>
            <div>
                <label class="text-xs text-gray-600">Qty</label>
                <input type="number" name="jeep_charges[${chargeIndex}][quantity]" class="jeep-quantity mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1" placeholder="0">
            </div>
            <div>
                <label class="text-xs text-gray-600">Total</label>
                <input type="number" step="0.01" name="jeep_charges[${chargeIndex}][total_price]" class="jeep-total-price bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1" readonly>
            </div>
            <div>
                <label class="text-xs text-gray-600">Per Person</label>
                <input type="number" step="0.01" name="jeep_charges[${chargeIndex}][per_person]" class="jeep-per-person bg-gray-100 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-xs py-1" readonly>
            </div>
            <button type="button" class="remove-jeep-charge text-red-500 hover:text-red-700 self-end mb-1">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;
                globalJeepChargesList.appendChild(row);
                const paxRangeDisplaySelect = row.querySelector('.jeep-pax-range-display');
                const paxRangeHiddenInput = row.querySelector('.jeep-pax-range');

                if (specificPaxRange) {
                    paxRangeDisplaySelect.value = specificPaxRange;
                    paxRangeHiddenInput.value = specificPaxRange; // Sync hidden input
                }
                initializeJeepChargeRowEvents(row);

                if (existingChargeData) {
                    row.querySelector('.jeep-unit-price').value = existingChargeData.unit_price || '';
                    row.querySelector('.jeep-quantity').value = existingChargeData.quantity || '';
                }
                calculateJeepChargeTotals(row);
            }

            function initializeJeepChargeRowEvents(row) {
                // The remove button for global jeep charges should not affect route jeep charge flag
                const removeButton = row.querySelector('.remove-jeep-charge');
                if (removeButton) {
                    removeButton.addEventListener('click', () => {
                        row.remove();
                        // Only update flag if it's a route jeep charge being removed
                        if (row.closest('.route-jeep-charges-list')) {
                            updateEnableRouteJeepChargesFlag();
                        }
                    });
                }

                row.querySelectorAll('.jeep-unit-price, .jeep-quantity').forEach(input => {
                    input.addEventListener('input', () => calculateJeepChargeTotals(row));
                });
                calculateJeepChargeTotals(row);
            }

            // --- Initial Load ---
            document.getElementById('add-travel-plan').addEventListener('click', () => addTravelPlanCard());

            if (existingTravelPlans.length > 0) {
                existingTravelPlans.forEach(plan => addTravelPlanCard(plan));
            } else {
                if (paxSlabRangesArray.length > 0) {
                    addTravelPlanCard();
                }
            }

            if ({{ $hasGlobalJeepCharges ? 'true' : 'false' }} || (existingGlobalJeepCharges &&
                    existingGlobalJeepCharges.length > 0)) {
                enableGlobalJeepChargesCheckbox.checked = true;
                globalJeepChargesContainer.style.display = 'block';
                enableJeepChargesInput.value = "1";
                populateGlobalJeepCharges();
            }

            // Initial check for enable_route_jeep_charges based on existing data
            updateEnableRouteJeepChargesFlag();
            // Additionally, if the controller flag was set (e.g. from a previous save where it was enabled but all values were 0)
            if ({{ $hasRouteWiseJeepCharges ? 'true' : 'false' }} && enableRouteJeepChargesInput.value === "0") {
                // This case is tricky: if the backend says it was enabled, but JS calculates it as disabled (all zeros)
                // For now, JS calculation takes precedence on load. If you want backend to override, set it here.
                // enableRouteJeepChargesInput.value = "1"; 
            }

            // Before submitting the form, ensure all hidden pax_range inputs are synced
            // This is a fallback, ideally they are synced when set.
            if (mainForm) {
                mainForm.addEventListener('submit', function() {
                    document.querySelectorAll('.jeep-pax-range-display').forEach(displaySelect => {
                        const hiddenInput = displaySelect
                        .nextElementSibling; // Assumes hidden input is immediately after
                        if (hiddenInput && hiddenInput.classList.contains('jeep-pax-range')) {
                            hiddenInput.value = displaySelect.value;
                        }
                    });
                });
            }

        });
    </script>
</x-app-layout>
