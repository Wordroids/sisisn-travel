<x-app-layout>
    <div class="py-6">
        <div class="flex justify-between items-center px-10">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Confirmed Tours
            </h2>
            <div class="flex space-x-2">

            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input id="search-input" type="text"
                                class="w-full rounded-md border-gray-300 pl-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                placeholder="Search by Tour Ref, Booking Ref, Customer...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <button id="clear-search" type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3" style="display: none;">
                                <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main Content with Tabs -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="border-b border-gray-200">
                    <!-- Tab Navigation -->
                    <div class="flex border-b">
                        <button type="button"
                            class="tab-btn py-4 px-6 text-center border-b-2 border-blue-500 text-blue-500 font-medium flex-1"
                            data-tab-target="individual">
                            <span class="hidden md:inline">Individual Tours</span>
                            <span class="md:hidden">Individual</span>
                            <span
                                class="inline-block ml-2 bg-green-100 text-green-800 text-xs font-medium rounded-full px-2 py-1">{{ $confirmedQuotations->count() }}</span>
                        </button>
                        <button type="button"
                            class="tab-btn py-4 px-6 text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium flex-1"
                            data-tab-target="group">
                            <span class="hidden md:inline">Group Tours</span>
                            <span class="md:hidden">Group</span>
                            <span
                                class="inline-block ml-2 bg-purple-100 text-purple-800 text-xs font-medium rounded-full px-2 py-1">{{ $groupQuotations->count() }}</span>
                        </button>
                    </div>

                    <div class="p-6">
                        <!-- Individual Tours Content -->
                        <div id="individual" class="tab-content block space-y-6">
                            @if ($confirmedQuotations->count() > 0)

                                <div class="mt-2 overflow-x-auto">
                                    <div class="flex items-center justify-between mb-4">

                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-500">Total:
                                                {{ $confirmedQuotations->count() }}</span>
                                        </div>
                                    </div>
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Tour Ref</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Customer</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Market</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Period</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Duration</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Driver</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($confirmedQuotations as $quotation)
                                                <tr class="hover:bg-gray-50"
                                                    data-quote-ref="{{ $quotation->quote_reference }}"
                                                    data-booking-ref="{{ $quotation->booking_reference }}">
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->booking_reference }}</td>
                                                    <td
                                                        class="py-3 px-4 border-b border-gray-200 font-medium text-gray-900">
                                                        {{ $quotation->customer ? $quotation->customer->name : 'N/A' }}
                                                    </td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->market ? $quotation->market->name : 'N/A' }}</td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        @if (is_string($quotation->start_date))
                                                            {{ $quotation->start_date }} - {{ $quotation->end_date }}
                                                        @else
                                                            {{ $quotation->start_date->format('d M Y') }} -
                                                            {{ $quotation->end_date->format('d M Y') }}
                                                        @endif
                                                    </td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->duration }} days</td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->driver ? $quotation->driver->name : 'N/A' }}
                                                    </td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        <div class="flex items-center justify-center space-x-3">
                                                            <a href="{{ route('quotations.show', $quotation->id) }}"
                                                                class="text-blue-600 hover:text-blue-900">
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                                    <path fill-rule="evenodd"
                                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </a>
                                                            <a href="{{ route('quotations.edit_step_one', $quotation->id) }}"
                                                                class="text-yellow-600 hover:text-yellow-900">
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-10 10a2 2 0 01-1.414.586H3V15h1.586a1 1 0 00.707-.293l10-10z">
                                                                    </path>
                                                                    <path
                                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No confirmed individual tours
                                        found</h3>
                                    <p class="text-gray-500">There are no approved individual quotations at the moment.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Group Tours Content -->
                        <div id="group" class="tab-content hidden space-y-6">
                            @if ($groupQuotations->count() > 0)

                                <div class="mt-2 overflow-x-auto">
                                    <div class="flex items-center justify-between mb-4">

                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-500">Total:
                                                {{ $groupQuotations->count() }}</span>
                                        </div>
                                    </div>
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Group Name</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Tour Ref</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Customer</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Market</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Period</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Duration</th>
                                                <th
                                                    class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupQuotations as $quotation)
                                                <tr class="hover:bg-gray-50"
                                                    data-quote-ref="{{ $quotation->quote_reference }}"
                                                    data-booking-ref="{{ $quotation->booking_reference }}">
                                                    <td
                                                        class="py-3 px-4 border-b border-gray-200 font-medium text-gray-900">
                                                        {{ $quotation->name }}</td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->booking_reference }}</td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->customer ? $quotation->customer->name : 'N/A' }}
                                                    </td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->market ? $quotation->market->name : 'N/A' }}
                                                    </td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->start_date->format('d M Y') }} -
                                                        {{ $quotation->end_date->format('d M Y') }}
                                                    </td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        {{ $quotation->duration }} days</td>
                                                    <td class="py-3 px-4 border-b border-gray-200">
                                                        <div class="flex items-center justify-center space-x-3">
                                                            <a href="{{ route('group_quotations.show', $quotation->id) }}"
                                                                class="text-blue-600 hover:text-blue-900">
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                                    <path fill-rule="evenodd"
                                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </a>
                                                            <a href="{{ route('group_quotations.step_01', $quotation->id) }}"
                                                                class="text-yellow-600 hover:text-yellow-900">
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-10 10a2 2 0 01-1.414.586H3V15h1.586a1 1 0 00.707-.293l10-10z">
                                                                    </path>
                                                                    <path
                                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No confirmed group tours found
                                    </h3>
                                    <p class="text-gray-500">There are no approved group quotations at the moment.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fixed Tab functionality
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get target tab ID
                    const targetId = this.getAttribute('data-tab-target');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Reset all tab button styles
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-blue-500', 'text-blue-500');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });

                    // Show the selected tab content
                    document.getElementById(targetId).classList.remove('hidden');

                    // Set active tab button style
                    this.classList.remove('border-transparent', 'text-gray-500');
                    this.classList.add('border-blue-500', 'text-blue-500');
                });
            });

            // Search functionality
            const searchInput = document.getElementById('search-input');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();

                // Search in individual tab
                const individualRows = document.querySelectorAll('#individual table tbody tr');
                const individualCards = document.querySelectorAll('#individual .grid > div');

                if (individualRows) {
                    individualRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                }

                if (individualCards) {
                    individualCards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        card.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                }

                // Search in group tab
                const groupRows = document.querySelectorAll('#group table tbody tr');
                const groupCards = document.querySelectorAll('#group .grid > div');

                if (groupRows) {
                    groupRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                }

                if (groupCards) {
                    groupCards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        card.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                }
            });

            // Export functionality
            const exportBtn = document.getElementById('export-btn');
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    alert('Export feature will be implemented here');
                });
            }


        });

        // Search functionality
        const searchInput = document.getElementById('search-input');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            if (!searchTerm) {
                // If search is empty, show all rows
                showAllRows();
                return;
            }

            // Search in individual tab
            const individualRows = document.querySelectorAll('#individual table tbody tr');
            let individualMatches = 0;

            if (individualRows && individualRows.length > 0) {
                individualRows.forEach(row => {
                    const quoteRef = (row.getAttribute('data-quote-ref') || '').toLowerCase();
                    const bookingRef = (row.getAttribute('data-booking-ref') || '').toLowerCase();
                    const rowText = row.textContent.toLowerCase();

                    const isMatch = quoteRef.includes(searchTerm) ||
                        bookingRef.includes(searchTerm) ||
                        rowText.includes(searchTerm);

                    row.style.display = isMatch ? '' : 'none';
                    if (isMatch) individualMatches++;
                });

                // Update counter if it exists
                const individualCounter = document.querySelector('#individual .text-sm.text-gray-500');
                if (individualCounter) {
                    individualCounter.textContent =
                        `Total: ${individualMatches} (filtered from ${individualRows.length})`;
                }
            }

            // Search in group tab
            const groupRows = document.querySelectorAll('#group table tbody tr');
            let groupMatches = 0;

            if (groupRows && groupRows.length > 0) {
                groupRows.forEach(row => {
                    const quoteRef = (row.getAttribute('data-quote-ref') || '').toLowerCase();
                    const bookingRef = (row.getAttribute('data-booking-ref') || '').toLowerCase();
                    const rowText = row.textContent.toLowerCase();

                    const isMatch = quoteRef.includes(searchTerm) ||
                        bookingRef.includes(searchTerm) ||
                        rowText.includes(searchTerm);

                    row.style.display = isMatch ? '' : 'none';
                    if (isMatch) groupMatches++;
                });

                // Update counter if it exists
                const groupCounter = document.querySelector('#group .text-sm.text-gray-500');
                if (groupCounter) {
                    groupCounter.textContent = `Total: ${groupMatches} (filtered from ${groupRows.length})`;
                }
            }

            // Show/hide "no results" messages
            toggleNoResultsMessage('individual', individualMatches);
            toggleNoResultsMessage('group', groupMatches);
        });

        // Helper functions
        function showAllRows() {
            // Show all rows in individual tab
            const individualRows = document.querySelectorAll('#individual table tbody tr');
            if (individualRows) {
                individualRows.forEach(row => {
                    row.style.display = '';
                });

                // Reset counter
                const individualCounter = document.querySelector('#individual .text-sm.text-gray-500');
                if (individualCounter) {
                    individualCounter.textContent = `Total: ${individualRows.length}`;
                }
            }

            // Show all rows in group tab
            const groupRows = document.querySelectorAll('#group table tbody tr');
            if (groupRows) {
                groupRows.forEach(row => {
                    row.style.display = '';
                });

                // Reset counter
                const groupCounter = document.querySelector('#group .text-sm.text-gray-500');
                if (groupCounter) {
                    groupCounter.textContent = `Total: ${groupRows.length}`;
                }
            }

            // Hide "no results" messages
            toggleNoResultsMessage('individual', true);
            toggleNoResultsMessage('group', true);
        }

        function toggleNoResultsMessage(tabId, hasMatches) {
            const noResultsMsg = document.querySelector(`#${tabId} .flex.flex-col.items-center`);
            if (noResultsMsg) {
                noResultsMsg.style.display = hasMatches ? 'none' : 'flex';
            }
        }

        // Clear search functionality
        const clearSearchBtn = document.getElementById('clear-search');

        searchInput.addEventListener('input', function() {
            clearSearchBtn.style.display = this.value ? 'flex' : 'none';
        });

        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearSearchBtn.style.display = 'none';
            showAllRows();
            searchInput.focus();
        });
    </script>
</x-app-layout>
