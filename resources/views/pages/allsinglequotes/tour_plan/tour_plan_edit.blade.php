<!-- filepath: d:\Saruna\Work\sisisn-travel\resources\views\pages\allquotes\tour_plan\tour_plan_edit.blade.php -->
<x-app-layout>
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Tour Plan</h2>
                        <a href="{{ route('tour_plan_vouchers.index', ['main_ref' => $main_ref]) }}"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Back to Tour Plans
                        </a>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Group Quotation Details</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
                            <p class="text-blue-700"><span class="font-bold">Booking Reference:</span>
                                {{ $main_ref }}</p>
                            @if ($tourStartDate && $tourEndDate)
                                <p class="text-blue-700"><span class="font-bold">Tour Period:</span>
                                    {{ \Carbon\Carbon::parse($tourStartDate)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($tourEndDate)->format('d M Y') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Group quotation sub-tours -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-3">Sub-Tours in This Group</h4>
                        <div class="overflow-x-auto shadow-md rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Booking Reference</th>
                                        <th scope="col" class="px-4 py-3">Tour Name</th>
                                        <th scope="col" class="px-4 py-3">Start Date</th>
                                        <th scope="col" class="px-4 py-3">End Date</th>
                                        <th scope="col" class="px-4 py-3">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupQuotations as $quotation)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-gray-900">
                                                {{ $quotation->booking_reference }}</td>
                                            <td class="px-4 py-2">{{ $quotation->name }}</td>
                                            <td class="px-4 py-2">
                                                {{ $quotation->start_date ? $quotation->start_date->format('d M Y') : 'N/A' }}
                                            </td>
                                            <td class="px-4 py-2">
                                                {{ $quotation->end_date ? $quotation->end_date->format('d M Y') : 'N/A' }}
                                            </td>
                                            <td class="px-4 py-2">{{ $quotation->duration ?? 'N/A' }} days</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <!-- Main Form with the rest of the tour plan details -->
                    <div class="mt-8 bg-white shadow-md rounded-lg p-6" id="planDetailsSection">
                        <form id="tourPlanForm"
                            action="{{ route('tour_plan_vouchers.update', ['main_ref' => $main_ref, 'id' => $tourPlan->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="group_quotation_id" value="{{ $main_ref }}">

                            <!-- Guest List Table -->
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
                                        @if (!empty($tourPlan->guests))
                                            @foreach ($tourPlan->guests as $index => $guest)
                                                <tr class="bg-white border-b">
                                                    <td class="px-4 py-2">
                                                        <input type="text"
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="guests[{{ $index }}][name]"
                                                            value="{{ $guest['name'] ?? '' }}" placeholder="Full name">
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <input type="date"
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="guests[{{ $index }}][arrival]"
                                                            value="{{ $guest['arrival'] ?? '' }}">
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <input type="date"
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="guests[{{ $index }}][departure]"
                                                            value="{{ $guest['departure'] ?? '' }}">
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <input type="text"
                                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                            name="guests[{{ $index }}][remarks]"
                                                            value="{{ $guest['remarks'] ?? '' }}"
                                                            placeholder="Add remarks">
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <button type="button"
                                                            class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                            onclick="removeMainGuestRow(this)">
                                                            Remove
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="bg-white border-b">
                                                <td class="px-4 py-2">
                                                    <input type="text"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                        name="guests[0][name]" placeholder="Full name">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="date"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                        name="guests[0][arrival]">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="date"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                        name="guests[0][departure]">
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
                                        @endif
                                    </tbody>
                                </table>
                            </div>


                            <!-- Tour Commencing Notes Section with Quill Editor -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">Tour Commencing Notes</h4>
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                    <div class="mb-4">
                                        <label for="tour_notes" class="block text-sm font-medium text-gray-700 mb-1">
                                            Notes
                                        </label>
                                        <!-- Quill editor container -->
                                        <div id="editor" style="min-height: 400px; border: 1px solid #ccc;"></div>
                                        <input type="hidden" name="tour_notes" id="tour_notes"
                                            value="{{ $tourPlan->tour_notes }}">
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
                                            <button type="button"
                                                class="px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onclick="addItineraryRow()">
                                                Add Day
                                            </button>
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
                                                @if (!empty($tourPlan->itinerary_days))
                                                    @foreach ($tourPlan->itinerary_days as $index => $day)
                                                        <tr class="bg-white border-b">
                                                            <td class="px-4 py-2">
                                                                <input type="date"
                                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                                    name="itinerary[{{ $index }}][date]"
                                                                    value="{{ $day['date'] ?? '' }}"
                                                                    min="{{ $tourStartDate }}"
                                                                    max="{{ $tourEndDate }}">
                                                            </td>
                                                            <td class="px-4 py-2">
                                                                <textarea
                                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                                    name="itinerary[{{ $index }}][sites_experiences]" rows="3"
                                                                    placeholder="List the sites and experiences for this day">{{ $day['sites_experiences'] ?? '' }}</textarea>
                                                            </td>
                                                            <td class="px-4 py-2">
                                                                <textarea
                                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                                    name="itinerary[{{ $index }}][guidelines]" rows="3"
                                                                    placeholder="Any special guidelines or instructions">{{ $day['guidelines'] ?? '' }}</textarea>
                                                            </td>
                                                            <td class="px-4 py-2">
                                                                <textarea
                                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                                    name="itinerary[{{ $index }}][contact_details]" rows="3"
                                                                    placeholder="Contact information for guides, drivers, etc.">{{ $day['contact_details'] ?? '' }}</textarea>
                                                            </td>
                                                            <td class="px-4 py-2">
                                                                <textarea
                                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                                    name="itinerary[{{ $index }}][hotel_details]" rows="3"
                                                                    placeholder="Hotel name, address, check-in/out times">{{ $day['hotel_details'] ?? '' }}</textarea>
                                                            </td>
                                                            <td class="px-4 py-2">
                                                                <button type="button"
                                                                    class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                                    onclick="removeItineraryRow(this)">
                                                                    Remove
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="bg-white border-b">
                                                        <td class="px-4 py-2">
                                                            <input type="date"
                                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                                name="itinerary[0][date]" min="{{ $tourStartDate }}"
                                                                max="{{ $tourEndDate }}">
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
                                                @endif
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
                                            placeholder="Enter any critical information, alerts, or special attention items for this tour (e.g., dietary restrictions, medical needs, accessibility requirements)">{{ $tourPlan->important_notes }}</textarea>
                                        <p class="mt-1 text-sm text-red-600">This information will be highlighted in
                                            the tour
                                            plan report.</p>
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
                                    Update Tour Plan
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

    <!-- Initialize Quill editor with existing content -->
    <script>
        // Initialize the Quill editor
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Set the existing content
        quill.root.innerHTML = {!! json_encode($tourPlan->tour_notes) !!};

        function prepareFormForSubmission() {
            // Save Quill editor content to hidden input
            document.getElementById('tour_notes').value = quill.root.innerHTML;

            // Submit the form
            document.getElementById('tourPlanForm').submit();
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
                           name="guests[${rowCount}][arrival]">
                </td>
                <td class="px-4 py-2">
                    <input type="date" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                           name="guests[${rowCount}][departure]">
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

        function addGuestRow() {
            const tableBody = document.getElementById('guestTableBody');
            const rowCount = tableBody.querySelectorAll('tr').length;

            // Create a new row for detailed guest info
            const newRow = document.createElement('tr');
            newRow.className = 'bg-white border-b';
            newRow.innerHTML = `
                <td class="px-4 py-2">
                    <input type="text" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                           name="detailed_guests[${rowCount}][name]" 
                           placeholder="Full name">
                </td>
                <td class="px-4 py-2">
                    <input type="number" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                           name="detailed_guests[${rowCount}][age]" 
                           placeholder="Age">
                </td>
                <td class="px-4 py-2">
                    <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                            name="detailed_guests[${rowCount}][gender]">
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </td>
                <td class="px-4 py-2">
                    <input type="text" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                           name="detailed_guests[${rowCount}][passport]" 
                           placeholder="Passport/ID">
                </td>
                <td class="px-4 py-2">
                    <input type="text" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                           name="detailed_guests[${rowCount}][requirements]" 
                           placeholder="Special requirements">
                </td>
                <td class="px-4 py-2">
                    <button type="button" 
                            class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                            onclick="removeGuestRow(this)">
                        Remove
                    </button>
                </td>
            `;

            tableBody.appendChild(newRow);
        }

        function removeGuestRow(button) {
            const row = button.closest('tr');
            row.remove();

            // Reindex the remaining rows
            reindexGuestRows();
        }

        function reindexGuestRows() {
            const tableBody = document.getElementById('guestTableBody');
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach((row, index) => {
                const inputs = row.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        // Replace the index in the name attribute
                        const newName = name.replace(/detailed_guests\[\d+\]/, `detailed_guests[${index}]`);
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
            const tourStartDate = "{{ $tourStartDate ?? '' }}";
            const tourEndDate = "{{ $tourEndDate ?? '' }}";

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
    </script>
</x-app-layout>
