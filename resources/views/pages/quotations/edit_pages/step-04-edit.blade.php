<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar -->
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

            <div class="flex justify-between mt-6">
                <a href="{{ $navigation['back'] }}" class="bg-gray-500 text-white py-2 px-4 rounded-md">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md">
                    Update & Complete
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

            function checkDateOverlap(startDate, endDate, currentEntry) {
                const allEntries = document.querySelectorAll('.travel-entry');
                const start = new Date(startDate);
                const end = new Date(endDate);

                for (let entry of allEntries) {
                    if (entry === currentEntry) continue;

                    const otherStartInput = entry.querySelector('input[name*="start_date"]');
                    const otherEndInput = entry.querySelector('input[name*="end_date"]');

                    if (!otherStartInput.value || !otherEndInput.value) continue;

                    const otherStart = new Date(otherStartInput.value);
                    const otherEnd = new Date(otherEndInput.value);

                    if ((start <= otherEnd && start >= otherStart) ||
                        (end <= otherEnd && end >= otherStart) ||
                        (start <= otherStart && end >= otherEnd)) {
                        return true;
                    }
                }
                return false;
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

                for (let i = 0; i < dates.length - 1; i++) {
                    const currentEnd = new Date(dates[i].end);
                    const nextStart = new Date(dates[i + 1].start);
                    currentEnd.setHours(0, 0, 0, 0);
                    nextStart.setHours(0, 0, 0, 0);

                    const expectedNextDay = new Date(currentEnd);
                    expectedNextDay.setDate(expectedNextDay.getDate() + 1);

                    if (nextStart.getTime() !== expectedNextDay.getTime()) {
                        const gap = Math.floor((nextStart - expectedNextDay) / (1000 * 60 * 60 * 24));
                        if (gap > 0) {
                            alert(
                                `Found a gap of ${gap} day(s) between ${currentEnd.toLocaleDateString()} and ${nextStart.toLocaleDateString()}`);
                            return false;
                        }
                    }

                    if (currentEnd >= nextStart) {
                        alert(
                            `Travel plans cannot overlap. Found overlap between ${dates[i].start.toLocaleDateString()} - ${dates[i].end.toLocaleDateString()} and ${dates[i + 1].start.toLocaleDateString()} - ${dates[i + 1].end.toLocaleDateString()}`);
                        return false;
                    }
                }

                this.submit();
            });
        });
    </script>

</x-app-layout>
