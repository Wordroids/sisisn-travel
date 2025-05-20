<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar -->
        <div class="mb-8">
            <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base">
                <li class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_01', $quotation->id) }}" class="flex items-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Basic <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </a>
                </li>
                <li class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_02', $quotation->id) }}" class="flex items-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slabs</span>
                    </a>
                </li>
                <li class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_03', $quotation->id) }}" class="flex items-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Accommodation
                    </a>
                </li>
                <li class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    <a href="{{ route('group_quotations.step_04', $quotation->id) }}" class="flex items-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan</span>
                    </a>
                </li>
                <li class="flex items-center text-blue-600">
                    <span class="flex items-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Site <span class="hidden sm:inline-flex sm:ms-2">|Extras</span>
                    </span>
                </li>
            </ol>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Validation Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p class="text-gray-700 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('group_quotations.store_step_05', $quotation->id) }}">
            @csrf
            @method('PUT')

            <!-- Site Seeing Section -->
            <div class="mb-8 p-4 border border-gray-200 rounded-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Site Seeing &amp; Site-Related Extras</h2>
                <div id="site-seeing-section" class="space-y-4">
                    <!-- Site seeing entries will be added here -->
                </div>
                <button type="button" id="add-site-seeing" class="mt-4 bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 text-sm flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Site Seeing / Site Extra
                </button>
            </div>

            <!-- General Extras Section -->
            <div class="mb-8 p-4 border border-gray-200 rounded-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">General Quotation Extras</h2>
                <div id="extras-section" class="space-y-4">
                    <!-- Extras entries will be added here -->
                </div>
                <button type="button" id="add-extra" class="mt-4 bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 text-sm flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add General Extra
                </button>
            </div>

            <div class="flex justify-between mt-10">
                <a href="{{ route('group_quotations.step_04', $quotation->id) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back to Travel Plan</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Save & Complete
                </button>
            </div>
        </form>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const siteSeeingSection = document.getElementById('site-seeing-section');
    const addSiteSeeingButton = document.getElementById('add-site-seeing');
    let siteSeeingIndex = 0;
    const existingSiteSeeings = @json($quotation->siteSeeings ?? []);

    const extrasSection = document.getElementById('extras-section');
    const addExtraButton = document.getElementById('add-extra');
    let extraIndex = 0;
    const existingExtras = @json($quotation->extras ?? []);
    const quotationStartDate = "{{ $quotation->start_date ? $quotation->start_date->format('Y-m-d') : '' }}";
    const quotationEndDate = "{{ $quotation->end_date ? $quotation->end_date->format('Y-m-d') : '' }}";

    const siteSeeingTypes = [
        { value: "site", text: "Site/Attraction" },
        { value: "extra", text: "Extra" },
       
    ];
    const siteSeeingTypeOptionsHTML = siteSeeingTypes.map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('');


    // --- Site Seeing Functions ---
    function addSiteSeeingEntry(existingEntry = null) {
        const currentIndex = siteSeeingIndex++;
        const entryDiv = document.createElement('div');
        entryDiv.className = 'p-3 border border-gray-300 rounded-md bg-gray-50 site-seeing-entry relative';
        // Grid layout adjusted for the new Type field
        entryDiv.innerHTML = `
            <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700 remove-site-seeing">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name*</label>
                    <input type="text" name="site_seeings[${currentIndex}][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type*</label>
                    <select name="site_seeings[${currentIndex}][type]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                        <option value="">Select Type</option>
                        ${siteSeeingTypeOptionsHTML}
                    </select>
                </div>
                <div class="lg:col-span-1"> {{-- Adjusted for layout --}}
                    <label class="block text-sm font-medium text-gray-700">Description <span class="text-xs text-gray-500">(Optional)</span></label>
                    <textarea name="site_seeings[${currentIndex}][description]" rows="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Unit Price</label>
                    <input type="number" step="0.01" name="site_seeings[${currentIndex}][unit_price]" class="site-seeing-unit-price mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="site_seeings[${currentIndex}][quantity]" class="site-seeing-quantity mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price Per Adult</label>
                    <input type="number" step="0.01" name="site_seeings[${currentIndex}][price_per_adult]" class="site-seeing-price-per-adult mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="0.00">
                </div>
            </div>
        `;
        siteSeeingSection.appendChild(entryDiv);

        if (existingEntry) {
            entryDiv.querySelector(`input[name="site_seeings[${currentIndex}][name]"]`).value = existingEntry.name || '';
            entryDiv.querySelector(`select[name="site_seeings[${currentIndex}][type]"]`).value = existingEntry.type || '';
            entryDiv.querySelector(`textarea[name="site_seeings[${currentIndex}][description]"]`).value = existingEntry.description || '';
            entryDiv.querySelector(`input[name="site_seeings[${currentIndex}][unit_price]"]`).value = existingEntry.unit_price || '';
            entryDiv.querySelector(`input[name="site_seeings[${currentIndex}][quantity]"]`).value = existingEntry.quantity || '';
            entryDiv.querySelector(`input[name="site_seeings[${currentIndex}][price_per_adult]"]`).value = existingEntry.price_per_adult || '';
        }

        entryDiv.querySelector('.remove-site-seeing').addEventListener('click', () => entryDiv.remove());
    }

    addSiteSeeingButton.addEventListener('click', () => addSiteSeeingEntry());
    existingSiteSeeings.forEach(entry => addSiteSeeingEntry(entry));
    if (existingSiteSeeings.length === 0) {
        addSiteSeeingEntry();
    }


    // --- General Extras Functions (remains the same as before) ---
    function addExtraEntry(existingEntry = null) {
        const currentIndex = extraIndex++;
        const entryDiv = document.createElement('div');
        entryDiv.className = 'p-3 border border-gray-300 rounded-md bg-gray-50 extra-entry relative';
        entryDiv.innerHTML = `
            <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700 remove-extra">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 items-end"> {{-- Adjusted grid for extras --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="extras[${currentIndex}][date]" class="extra-date mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </div>
                <div class="lg:col-span-1"> {{-- Adjusted for layout --}}
                    <label class="block text-sm font-medium text-gray-700">Description*</label>
                    <input type="text" name="extras[${currentIndex}][description]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Unit Price</label>
                    <input type="number" step="0.01" name="extras[${currentIndex}][unit_price]" class="extra-unit-price mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Qty Per Pax</label>
                    <input type="number" name="extras[${currentIndex}][quantity_per_pax]" class="extra-quantity-per-pax mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="0">
                </div>
            </div>
        `;
        extrasSection.appendChild(entryDiv);

        const dateInput = entryDiv.querySelector('.extra-date');
        if (quotationStartDate) dateInput.min = quotationStartDate;
        if (quotationEndDate) dateInput.max = quotationEndDate;

        if (existingEntry) {
            dateInput.value = existingEntry.date ? existingEntry.date.substring(0,10) : '';
            entryDiv.querySelector(`input[name="extras[${currentIndex}][description]"]`).value = existingEntry.description || '';
            entryDiv.querySelector(`input[name="extras[${currentIndex}][unit_price]"]`).value = existingEntry.unit_price || '';
            entryDiv.querySelector(`input[name="extras[${currentIndex}][quantity_per_pax]"]`).value = existingEntry.quantity_per_pax || '';
        }

        entryDiv.querySelector('.remove-extra').addEventListener('click', () => entryDiv.remove());
    }

    addExtraButton.addEventListener('click', () => addExtraEntry());
    existingExtras.forEach(entry => addExtraEntry(entry));
    if (existingExtras.length === 0) {
        addExtraEntry();
    }
});
</script>
</x-app-layout>