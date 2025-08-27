<x-app-layout>
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Create Tour Plan</h2>
                        <a href="{{ route('individual_tour_plan_vouchers.index', ['quotation' => $quotation->id]) }}"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Back to Tour Plans
                        </a>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Booking Details</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
                            <p class="text-blue-700"><span class="font-bold">Booking Reference:</span>
                                {{ $quotation->booking_reference }}</p>
                            <p class="text-blue-700"><span class="font-bold">Guest Name:</span>
                                {{ $quotation->name }}</p>
                            @if ($tourStartDate && $tourEndDate)
                                <p class="text-blue-700"><span class="font-bold">Tour Period:</span>
                                    {{ \Carbon\Carbon::parse($tourStartDate)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($tourEndDate)->format('d M Y') }}
                                </p>
                                <p class="text-blue-700"><span class="font-bold">Duration:</span>
                                    {{ $quotation->duration }} days
                                </p>
                            @endif
                            <p class="text-blue-700"><span class="font-bold">Pax:</span>
                                Adults: {{ $quotation->adults }}, Children: {{ $quotation->children }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 bg-white shadow-md rounded-lg p-6 " id="planDetailsSection">
                        <form id="tourPlanForm" action="{{ route('individual_tour_plan_vouchers.store', $quotation->id) }}" method="POST">
                            @csrf

                            <!-- Tour Plan Title -->
                            <div class="mb-6">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tour Plan Title
                                </label>
                                <input type="text" name="title" id="title"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="Enter a title for this tour plan"
                                    value="{{ $quotation->name ? $quotation->name . ' - Tour Plan' : 'Tour Plan' }}">
                            </div>

                            <!-- Pax Details Section -->
                            <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                                <div class="p-4 border-b border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <h5 class="font-medium text-gray-700">Guest List</h5>
                                        <button type="button"
                                            class="px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            onclick="addMainGuestRow()">
                                            Add Guest
                                        </button>
                                    </div>
                                </div>
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Guest Name</th>
                                            <th scope="col" class="px-4 py-3">Arrival</th>
                                            <th scope="col" class="px-4 py-3">Departure</th>
                                            <th scope="col" class="px-4 py-3">Remarks</th>
                                            <th scope="col" class="px-4 py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="mainGuestTableBody">
                                        <tr class="bg-white border-b">
                                            <td class="px-4 py-2">
                                                <input type="text"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                    name="guests[0][name]" value="{{ $quotation->name }}" placeholder="Full name">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="date"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                    name="guests[0][arrival]" value="{{ $tourStartDate }}">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="date"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                    name="guests[0][departure]" value="{{ $tourEndDate }}">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                    name="guests[0][remarks]" placeholder="Add remarks">
                                            </td>
                                            <td class="px-4 py-2">
                                                <button type="button"
                                                    class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                    onclick="removeMainGuestRow(this)">
                                                    Remove
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                                
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">Tour Commencing Notes</h4>
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                    <div class="mb-4">
                                        <label for="tour_notes" class="block text-sm font-medium text-gray-700 mb-1">
                                            Notes
                                        </label>
                                        <!-- Fix the editor container and add a hidden input -->
                                        <div id="editor" style="min-height: 400px; border: 1px solid #ccc; "></div>
                                        <input type="hidden" name="tour_notes" id="tour_notes">
                                    </div>
                                </div>
                            </div>

                            <!-- Itinerary Plan Section -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">Itinerary Plan</h4>
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="p-4 border-b border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <h5 class="font-medium text-gray-700">Daily Activities</h5>
                                            <div>
                                                <button type="button"
                                                    class="mr-2 px-3 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                                    onclick="generateFullItinerary()">
                                                    Generate Full Itinerary
                                                </button>
                                                <button type="button"
                                                    class="px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    onclick="addItineraryRow()">
                                                    Add Day
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-left">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-4 py-3">Date</th>
                                                    <th scope="col" class="px-4 py-3">Sites/Experiences</th>
                                                    <th scope="col" class="px-4 py-3">Special Guidelines</th>
                                                    <th scope="col" class="px-4 py-3">Contact Details</th>
                                                    <th scope="col" class="px-4 py-3">Hotel Details</th>
                                                    <th scope="col" class="px-4 py-3">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itineraryTableBody">
                                                <tr class="bg-white border-b">
                                                    <td class="px-4 py-2">
                                                        <input type="date"
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="itinerary[0][date]" value="{{ $tourStartDate }}">
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <textarea
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="itinerary[0][sites_experiences]" rows="3" placeholder="List the sites and experiences for this day"></textarea>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <textarea
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="itinerary[0][guidelines]" rows="3" placeholder="Any special guidelines or instructions"></textarea>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <textarea
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="itinerary[0][contact_details]" rows="3" placeholder="Contact information for guides, drivers, etc."></textarea>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <textarea
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="itinerary[0][hotel_details]" rows="3" placeholder="Hotel name, address, check-in/out times"></textarea>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <button type="button"
                                                            class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                            onclick="removeItineraryRow(this)">
                                                            Remove
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Notes Section -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">Important Notes</h4>
                                <div class="bg-red-50 border border-red-200 rounded-lg shadow-sm p-4">
                                    <div class="mb-4">
                                        <label for="important_notes"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Critical Information for This Tour
                                        </label>
                                        <textarea
                                            class="w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                            name="important_notes" id="important_notes" rows="4"
                                            placeholder="Enter any critical information, alerts, or special attention items for this tour (e.g., dietary restrictions, medical needs, accessibility requirements)"></textarea>
                                        <p class="mt-1 text-sm text-red-600">This information will be highlighted in
                                            the tour plan report.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit Buttons Section -->
                            <div class="flex justify-end space-x-4 mt-8">
                                <button type="button"
                                    class="px-5 py-2 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                                    onclick="window.history.back()">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    onclick="prepareFormForSubmission()">
                                    Create Tour Plan
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include the Quill library -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <!-- Initialize Quill editor -->
        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });
        </script>

        <script>
            function prepareFormForSubmission() {
                // Save Quill editor content to hidden input
                document.getElementById('tour_notes').value = quill.root.innerHTML;
            }

            function addMainGuestRow() {
                const tableBody = document.getElementById('mainGuestTableBody');
                const rowCount = tableBody.querySelectorAll('tr').length;

                // Create a new row
                const newRow = document.createElement('tr');
                newRow.className = 'bg-white border-b';
                newRow.innerHTML = `
        <td class="px-4 py-2">
            <input type="text" 
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   name="guests[${rowCount}][name]" 
                   placeholder="Full name">
        </td>
        <td class="px-4 py-2">
            <input type="date" 
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   name="guests[${rowCount}][arrival]" 
                   value="{{ $tourStartDate }}">
        </td>
        <td class="px-4 py-2">
            <input type="date" 
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   name="guests[${rowCount}][departure]" 
                   value="{{ $tourEndDate }}">
        </td>
        <td class="px-4 py-2">
            <input type="text" 
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   name="guests[${rowCount}][remarks]" 
                   placeholder="Add remarks">
        </td>
        <td class="px-4 py-2">
            <button type="button" 
                    class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                    onclick="removeMainGuestRow(this)">
                Remove
            </button>
        </td>
    `;

                tableBody.appendChild(newRow);
            }

            function removeMainGuestRow(button) {
                const row = button.closest('tr');
                row.remove();

                // Reindex the remaining rows to maintain consecutive indices
                reindexMainGuestRows();
            }

            function reindexMainGuestRows() {
                const tableBody = document.getElementById('mainGuestTableBody');
                const rows = tableBody.querySelectorAll('tr');

                rows.forEach((row, index) => {
                    const inputs = row.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            // Replace the index in the name attribute
                            const newName = name.replace(/guests\[\d+\]/, `guests[${index}]`);
                            input.setAttribute('name', newName);
                        }
                    });
                });
            }
        </script>

        <script>
            // Store tour dates globally
            const tourStartDate = "{{ $tourStartDate ?? '' }}";
            const tourEndDate = "{{ $tourEndDate ?? '' }}";


            function generateFullItinerary() {
                if (!tourStartDate || !tourEndDate) {
                    console.log('Tour start and end dates are not available.');
                    return;
                }

                // Clear existing itinerary rows
                const tableBody = document.getElementById('itineraryTableBody');
                while (tableBody.firstChild) {
                    tableBody.removeChild(tableBody.firstChild);
                }

                // Calculate number of days
                const start = new Date(tourStartDate);
                const end = new Date(tourEndDate);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Include both start and end days

                // Create a row for each day
                for (let i = 0; i < diffDays; i++) {
                    const currentDate = new Date(start);
                    currentDate.setDate(currentDate.getDate() + i);

                    // Format as YYYY-MM-DD for input value
                    const year = currentDate.getFullYear();
                    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                    const day = String(currentDate.getDate()).padStart(2, '0');
                    const formattedDate = `${year}-${month}-${day}`;

                    // Create a new row
                    const newRow = document.createElement('tr');
                    newRow.className = 'bg-white border-b';
                    newRow.innerHTML = `
                        <td class="px-4 py-2">
                            <input type="date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                name="itinerary[${i}][date]"
                                value="${formattedDate}"
                                min="${tourStartDate}" 
                                max="${tourEndDate}">
                        </td>
                        <td class="px-4 py-2">
                            <textarea
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                name="itinerary[${i}][sites_experiences]" rows="3"
                                placeholder="List the sites and experiences for Day ${i+1}"></textarea>
                        </td>
                        <td class="px-4 py-2">
                            <textarea
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                name="itinerary[${i}][guidelines]" rows="3"
                                placeholder="Any special guidelines or instructions"></textarea>
                        </td>
                        <td class="px-4 py-2">
                            <textarea
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                name="itinerary[${i}][contact_details]" rows="3"
                                placeholder="Contact information for guides, drivers, etc."></textarea>
                        </td>
                        <td class="px-4 py-2">
                            <textarea
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                name="itinerary[${i}][hotel_details]" rows="3"
                                placeholder="Hotel name, address, check-in/out times"></textarea>
                        </td>
                        <td class="px-4 py-2">
                            <button type="button"
                                class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                onclick="removeItineraryRow(this)">
                                Remove
                            </button>
                        </td>
                    `;

                    tableBody.appendChild(newRow);
                }
            }

            // Add removeItineraryRow function if it doesn't exist yet
            function removeItineraryRow(button) {
                const row = button.closest('tr');
                row.remove();

                // Reindex remaining rows
                reindexItineraryRows();
            }

            function reindexItineraryRows() {
                const tableBody = document.getElementById('itineraryTableBody');
                const rows = tableBody.querySelectorAll('tr');

                rows.forEach((row, index) => {
                    const inputs = row.querySelectorAll('input, textarea');
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            // Replace the index in the name attribute
                            const newName = name.replace(/itinerary\[\d+\]/, `itinerary[${index}]`);
                            input.setAttribute('name', newName);
                        }
                    });
                });
            }

            function addItineraryRow() {
                const tableBody = document.getElementById('itineraryTableBody');
                const rowCount = tableBody.querySelectorAll('tr').length;

                // Calculate the date for this row (tour start date + rowCount days)
                let rowDate = '';
                if (tourStartDate) {
                    const date = new Date(tourStartDate);
                    date.setDate(date.getDate() + rowCount);

                    // Format as YYYY-MM-DD for input value
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    rowDate = `${year}-${month}-${day}`;
                }

                // Create a new row for itinerary
                const newRow = document.createElement('tr');
                newRow.className = 'bg-white border-b';
                newRow.innerHTML = `
                    <td class="px-4 py-2">
                        <input type="date"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            name="itinerary[${rowCount}][date]"
                            value="${rowDate}"
                            min="${tourStartDate || ''}" 
                            max="${tourEndDate || ''}">
                    </td>
                    <td class="px-4 py-2">
                        <textarea
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            name="itinerary[${rowCount}][sites_experiences]" rows="3"
                            placeholder="List the sites and experiences for this day"></textarea>
                    </td>
                    <td class="px-4 py-2">
                        <textarea
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            name="itinerary[${rowCount}][guidelines]" rows="3"
                            placeholder="Any special guidelines or instructions"></textarea>
                    </td>
                    <td class="px-4 py-2">
                        <textarea
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            name="itinerary[${rowCount}][contact_details]" rows="3"
                            placeholder="Contact information for guides, drivers, etc."></textarea>
                    </td>
                    <td class="px-4 py-2">
                        <textarea
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            name="itinerary[${rowCount}][hotel_details]" rows="3"
                            placeholder="Hotel name, address, check-in/out times"></textarea>
                    </td>
                    <td class="px-4 py-2">
                        <button type="button"
                            class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                            onclick="removeItineraryRow(this)">
                            Remove
                        </button>
                    </td>
                `;

                tableBody.appendChild(newRow);
            }

            // Also update the first row when page loads
            document.addEventListener("DOMContentLoaded", function() {
                // Set min/max dates for the first row
                const firstDateInput = document.querySelector('#itineraryTableBody tr:first-child input[type="date"]');
                if (firstDateInput) {
                    firstDateInput.min = tourStartDate || '';
                    firstDateInput.max = tourEndDate || '';
                    if (tourStartDate) {
                        firstDateInput.value = tourStartDate;
                    }
                }
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Check if tour start and end dates are available
                if (tourStartDate && tourEndDate) {
                    // Generate the full itinerary automatically on page load
                    generateFullItinerary();
                } else {
                    // If dates are not available, just set the first row date
                    const firstDateInput = document.querySelector(
                        '#itineraryTableBody tr:first-child input[type="date"]');
                    if (firstDateInput) {
                        firstDateInput.min = tourStartDate || '';
                        firstDateInput.max = tourEndDate || '';
                        if (tourStartDate) {
                            firstDateInput.value = tourStartDate;
                        }
                    }
                }
            });
        </script>

        <!-- Add fade animations CSS -->
        <style>
            /* Add simple fade animations */
            .animate-fade-in {
                animation: fadeIn 0.3s ease-in-out;
            }

            .animate-fade-out {
                animation: fadeOut 0.3s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeOut {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }

                to {
                    opacity: 0;
                    transform: translateY(-10px);
                }
            }
        </style>
</x-app-layout>