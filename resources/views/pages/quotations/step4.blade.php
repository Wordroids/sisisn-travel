<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">

        <!-- Progress Bar  -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <!-- Step 1: Reference Info -->
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_one', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Reference <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </a>
                </li>
        
                <!-- Step 2: Pax Slab -->
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_two', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </a>
                </li>
        
                <!-- Step 3: Accommodation -->
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_three', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Accommodation
                    </a>
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
                        Travel <span class="hidden sm:inline-flex sm:ms-2"> Plan </span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">5</span>
                    Site <span class="hidden sm:inline-flex sm:ms-2"> Details </span>
                </li>
            </ol>
        </div>

        <p class="text-gray-700 mt-10 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step4.store', $quotation->id) }}" id="travelPlanForm">
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
            @if(isset($navigation['back']))
                <a href="{{ $navigation['back'] }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
                    Back
                </a>
            @else
                <div></div> {{-- Empty div to maintain spacing --}}
            @endif
        
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                Save & Complete
            </button>
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

                // Function to check date overlap with other travel plans
                function checkDateOverlap(startDate, endDate, currentContainer) {
                    const allTravelEntries = document.querySelectorAll('.travel-entry');
                    for (let entry of allTravelEntries) {
                        if (entry === currentContainer) continue;

                        const otherStartDate = entry.querySelector('input[name*="start_date"]').value;
                        const otherEndDate = entry.querySelector('input[name*="end_date"]').value;

                        if (!otherStartDate || !otherEndDate) continue;

                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        const otherStart = new Date(otherStartDate);
                        const otherEnd = new Date(otherEndDate);

                        // Check for overlap
                        if ((start <= otherEnd && start >= otherStart) ||
                            (end <= otherEnd && end >= otherStart) ||
                            (start <= otherStart && end >= otherEnd)) {
                            return true;
                        }
                    }
                    return false;
                }

                // When start date changes
                startDateInput.addEventListener('change', function() {
                    if (this.value) {
                        endDateInput.min = this.value;
                        if (endDateInput.value && new Date(endDateInput.value) < new Date(this.value)) {
                            endDateInput.value = this.value;
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

                        // Check for overlap if end date is also selected
                        if (endDateInput.value &&
                            checkDateOverlap(this.value, endDateInput.value, this.closest('.travel-entry'))
                            ) {
                            alert('Travel dates cannot overlap with other travel plans');
                            this.value = '';
                            return;
                        }
                    }
                });

                // When end date changes
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

                        // Check for overlap if start date is also selected
                        if (startDateInput.value &&
                            checkDateOverlap(startDateInput.value, this.value, this.closest(
                                '.travel-entry'))) {
                            alert('Travel dates cannot overlap with other travel plans');
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

            document.getElementById('travelPlanForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const travelEntries = document.querySelectorAll('.travel-entry');
                let dates = [];

                // Collect all travel dates
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

                // Sort dates by start date
                dates.sort((a, b) => a.start - b.start);

                const qStart = new Date(quotationStartDate);
                const qEnd = new Date(quotationEndDate);

                // Remove time component from dates for comparison
                qStart.setHours(0, 0, 0, 0);
                qEnd.setHours(0, 0, 0, 0);

                // Check if first travel plan starts exactly on quotation start date
                const firstStart = new Date(dates[0].start);
                firstStart.setHours(0, 0, 0, 0);
                if (firstStart.getTime() !== qStart.getTime()) {
                    alert(`First travel plan must start on quotation start date (${quotationStartDate})`);
                    return false;
                }

                // Check if last travel plan ends exactly on quotation end date
                const lastEnd = new Date(dates[dates.length - 1].end);
                lastEnd.setHours(0, 0, 0, 0);
                if (lastEnd.getTime() !== qEnd.getTime()) {
                    alert(`Last travel plan must end on quotation end date (${quotationEndDate})`);
                    return false;
                }

                // Check for gaps and overlaps
                for (let i = 0; i < dates.length - 1; i++) {
                    const currentEnd = new Date(dates[i].end);
                    const nextStart = new Date(dates[i + 1].start);
                    currentEnd.setHours(0, 0, 0, 0);
                    nextStart.setHours(0, 0, 0, 0);

                    // Calculate the next day after current end
                    const expectedNextDay = new Date(currentEnd);
                    expectedNextDay.setDate(expectedNextDay.getDate() + 1);

                    // Check for gaps
                    if (nextStart.getTime() !== expectedNextDay.getTime()) {
                        const gap = Math.floor((nextStart - expectedNextDay) / (1000 * 60 * 60 * 24));
                        if (gap > 0) {
                            alert(
                                `Found a gap of ${gap} day(s) between ${currentEnd.toLocaleDateString()} and ${nextStart.toLocaleDateString()}`);
                            return false;
                        }
                    }

                    // Check for overlaps
                    if (currentEnd >= nextStart) {
                        alert(
                            `Travel plans cannot overlap. Found overlap between ${dates[i].start.toLocaleDateString()} - ${dates[i].end.toLocaleDateString()} and ${dates[i + 1].start.toLocaleDateString()} - ${dates[i + 1].end.toLocaleDateString()}`);
                        return false;
                    }
                }

                // If all validations pass, submit the form
                this.submit();
            });

        });
    </script>

</x-app-layout>
