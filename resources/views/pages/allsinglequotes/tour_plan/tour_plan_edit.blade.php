<x-app-layout>
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Tour Plan</h2>
                        <a href="{{ route('individual_tour_plan_vouchers.index', ['quotation' => $quotation->id]) }}"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Back to Tour Plans
                        </a>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Booking Details</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
                            <p class="text-blue-700"><span class="font-bold">Booking Reference:</span> {{ $quotation->booking_reference }}</p>
                            <p class="text-blue-700"><span class="font-bold">Guest Name:</span> {{ $quotation->name }}</p>
                            @if ($tourStartDate && $tourEndDate)
                                <p class="text-blue-700"><span class="font-bold">Tour Period:</span> {{ \Carbon\Carbon::parse($tourStartDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tourEndDate)->format('d M Y') }}</p>
                                <p class="text-blue-700"><span class="font-bold">Duration:</span> {{ $quotation->duration }} days</p>
                            @endif
                            <p class="text-blue-700"><span class="font-bold">Pax:</span> Adults: {{ $quotation->adults }}, Children: {{ $quotation->children }}</p>
                        </div>
                    </div>

                    <div class="mt-8 bg-white shadow-md rounded-lg p-6 " id="planDetailsSection">
                        <form id="tourPlanForm" action="{{ route('individual_tour_plan_vouchers.update', [$quotation->id, $tourPlan->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Tour Plan Title -->
                            <div class="mb-6">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tour Plan Title</label>
                                <input type="text" name="title" id="title"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    value="{{ old('title', $tourPlan->title) }}">
                            </div>

                            <!-- Pax Details Section -->
                            <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                    <h5 class="font-medium text-gray-700">Guest List</h5>
                                    <button type="button" class="px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        onclick="addMainGuestRow()">
                                        Add Guest
                                    </button>
                                </div>
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3">Guest Name</th>
                                            <th class="px-4 py-3">Arrival</th>
                                            <th class="px-4 py-3">Departure</th>
                                            <th class="px-4 py-3">Remarks</th>
                                            <th class="px-4 py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="mainGuestTableBody">
                                        @foreach(json_decode($tourPlan->guests, true) ?? [] as $index => $guest)
                                        <tr class="bg-white border-b">
                                            <td class="px-4 py-2">
                                                <input type="text" name="guests[{{ $index }}][name]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $guest['name'] }}" placeholder="Full name">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="date" name="guests[{{ $index }}][arrival]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $guest['arrival'] ?? $tourStartDate }}">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="date" name="guests[{{ $index }}][departure]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $guest['departure'] ?? $tourEndDate }}">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" name="guests[{{ $index }}][remarks]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $guest['remarks'] ?? '' }}" placeholder="Add remarks">
                                            </td>
                                            <td class="px-4 py-2">
                                                <button type="button" class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="removeMainGuestRow(this)">Remove</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tour Notes -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">Tour Commencing Notes</h4>
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                    <div class="mb-4">
                                        <label for="tour_notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                        <div id="editor" style="min-height: 400px; border: 1px solid #ccc;">{!! old('tour_notes', $tourPlan->tour_notes) !!}</div>
                                        <input type="hidden" name="tour_notes" id="tour_notes">
                                    </div>
                                </div>
                            </div>

                            <!-- Itinerary Plan Section -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">Itinerary Plan</h4>
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                        <h5 class="font-medium text-gray-700">Daily Activities</h5>
                                        <div>
                                            <button type="button" class="mr-2 px-3 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500" onclick="generateFullItinerary()">Generate Full Itinerary</button>
                                            <button type="button" class="px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="addItineraryRow()">Add Day</button>
                                        </div>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-left">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Sites/Experiences</th>
                                                    <th>Special Guidelines</th>
                                                    <th>Contact Details</th>
                                                    <th>Hotel Details</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itineraryTableBody">
                                                @foreach(json_decode($tourPlan->itinerary_days, true) ?? [] as $index => $day)
                                                <tr class="bg-white border-b">
                                                    <td class="px-4 py-2">
                                                        <input type="date" name="itinerary[{{ $index }}][date]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $day['date'] ?? $tourStartDate }}" min="{{ $tourStartDate }}" max="{{ $tourEndDate }}">
                                                    </td>
                                                    <td class="px-4 py-2"><textarea name="itinerary[{{ $index }}][sites_experiences]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ $day['sites_experiences'] ?? '' }}</textarea></td>
                                                    <td class="px-4 py-2"><textarea name="itinerary[{{ $index }}][guidelines]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ $day['guidelines'] ?? '' }}</textarea></td>
                                                    <td class="px-4 py-2"><textarea name="itinerary[{{ $index }}][contact_details]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ $day['contact_details'] ?? '' }}</textarea></td>
                                                    <td class="px-4 py-2"><textarea name="itinerary[{{ $index }}][hotel_details]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ $day['hotel_details'] ?? '' }}</textarea></td>
                                                    <td class="px-4 py-2"><button type="button" class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="removeItineraryRow(this)">Remove</button></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Notes -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">Important Notes</h4>
                                <div class="bg-red-50 border border-red-200 rounded-lg shadow-sm p-4">
                                    <textarea name="important_notes" id="important_notes" rows="4" class="w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('important_notes', $tourPlan->important_notes) }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex justify-end space-x-4 mt-8">
                                <button type="button" class="px-5 py-2 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400" onclick="window.history.back()">Cancel</button>
                                <button type="submit" class="px-5 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500" onclick="prepareFormForSubmission()">Update Tour Plan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Quill -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    // Initialize Quill editor with existing content
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    function prepareFormForSubmission() {
        document.getElementById('tour_notes').value = quill.root.innerHTML;
    }

    // Global tour dates
    const tourStartDate = "{{ $tourStartDate ?? '' }}";
    const tourEndDate = "{{ $tourEndDate ?? '' }}";

    /* ----------------- Guest List Functions ----------------- */
    function addMainGuestRow() {
        const tableBody = document.getElementById('mainGuestTableBody');
        const rowCount = tableBody.querySelectorAll('tr').length;

        const newRow = document.createElement('tr');
        newRow.className = 'bg-white border-b';
        newRow.innerHTML = `
            <td class="px-4 py-2">
                <input type="text" name="guests[${rowCount}][name]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Full name">
            </td>
            <td class="px-4 py-2">
                <input type="date" name="guests[${rowCount}][arrival]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="${tourStartDate}">
            </td>
            <td class="px-4 py-2">
                <input type="date" name="guests[${rowCount}][departure]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="${tourEndDate}">
            </td>
            <td class="px-4 py-2">
                <input type="text" name="guests[${rowCount}][remarks]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Add remarks">
            </td>
            <td class="px-4 py-2">
                <button type="button" class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="removeMainGuestRow(this)">Remove</button>
            </td>
        `;
        tableBody.appendChild(newRow);
    }

    function removeMainGuestRow(button) {
        const row = button.closest('tr');
        row.remove();
        reindexMainGuestRows();
    }

    function reindexMainGuestRows() {
        const tableBody = document.getElementById('mainGuestTableBody');
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const inputs = row.querySelectorAll('input, select');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if(name) input.setAttribute('name', name.replace(/guests\[\d+\]/, `guests[${index}]`));
            });
        });
    }

    /* ----------------- Itinerary Functions ----------------- */
    function addItineraryRow() {
        const tableBody = document.getElementById('itineraryTableBody');
        const rowCount = tableBody.querySelectorAll('tr').length;

        let rowDate = '';
        if(tourStartDate) {
            const date = new Date(tourStartDate);
            date.setDate(date.getDate() + rowCount);
            const y = date.getFullYear(), m = String(date.getMonth() + 1).padStart(2, '0'), d = String(date.getDate()).padStart(2, '0');
            rowDate = `${y}-${m}-${d}`;
        }

        const newRow = document.createElement('tr');
        newRow.className = 'bg-white border-b';
        newRow.innerHTML = `
            <td class="px-4 py-2">
                <input type="date" name="itinerary[${rowCount}][date]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="${rowDate}" min="${tourStartDate}" max="${tourEndDate}">
            </td>
            <td class="px-4 py-2"><textarea name="itinerary[${rowCount}][sites_experiences]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="List the sites and experiences"></textarea></td>
            <td class="px-4 py-2"><textarea name="itinerary[${rowCount}][guidelines]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Special guidelines"></textarea></td>
            <td class="px-4 py-2"><textarea name="itinerary[${rowCount}][contact_details]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Contact details"></textarea></td>
            <td class="px-4 py-2"><textarea name="itinerary[${rowCount}][hotel_details]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Hotel details"></textarea></td>
            <td class="px-4 py-2"><button type="button" class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="removeItineraryRow(this)">Remove</button></td>
        `;
        tableBody.appendChild(newRow);
    }

    function removeItineraryRow(button) {
        const row = button.closest('tr');
        row.remove();
        reindexItineraryRows();
    }

    function reindexItineraryRows() {
        const tableBody = document.getElementById('itineraryTableBody');
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row,index)=>{
            const inputs = row.querySelectorAll('input, textarea');
            inputs.forEach(input=>{
                const name = input.getAttribute('name');
                if(name) input.setAttribute('name', name.replace(/itinerary\[\d+\]/, `itinerary[${index}]`));
            });
        });
    }

    function generateFullItinerary() {
        if(!tourStartDate || !tourEndDate) return;
        const tableBody = document.getElementById('itineraryTableBody');
        tableBody.innerHTML = '';

        const start = new Date(tourStartDate);
        const end = new Date(tourEndDate);
        const diffDays = Math.ceil((end-start)/(1000*60*60*24)) + 1;

        for(let i=0; i<diffDays; i++){
            const current = new Date(start);
            current.setDate(current.getDate()+i);
            const y = current.getFullYear(), m = String(current.getMonth()+1).padStart(2,'0'), d = String(current.getDate()).padStart(2,'0');
            const formattedDate = `${y}-${m}-${d}`;

            const newRow = document.createElement('tr');
            newRow.className='bg-white border-b';
            newRow.innerHTML = `
                <td class="px-4 py-2">
                    <input type="date" name="itinerary[${i}][date]" value="${formattedDate}" min="${tourStartDate}" max="${tourEndDate}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-4 py-2"><textarea name="itinerary[${i}][sites_experiences]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="List the sites and experiences"></textarea></td>
                <td class="px-4 py-2"><textarea name="itinerary[${i}][guidelines]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Special guidelines"></textarea></td>
                <td class="px-4 py-2"><textarea name="itinerary[${i}][contact_details]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Contact details"></textarea></td>
                <td class="px-4 py-2"><textarea name="itinerary[${i}][hotel_details]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Hotel details"></textarea></td>
                <td class="px-4 py-2"><button type="button" class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="removeItineraryRow(this)">Remove</button></td>
            `;
            tableBody.appendChild(newRow);
        }
    }

    // Initialize first row min/max dates on load
    document.addEventListener('DOMContentLoaded', function(){
        const firstDateInput = document.querySelector('#itineraryTableBody tr:first-child input[type="date"]');
        if(firstDateInput){
            firstDateInput.min = tourStartDate || '';
            firstDateInput.max = tourEndDate || '';
        }
    });
</script>

</x-app-layout>
