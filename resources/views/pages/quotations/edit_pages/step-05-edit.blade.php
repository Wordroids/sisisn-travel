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

                <li class="flex items-center text-blue-600 test:text-blue-500">
                    <span class="flex items-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Site <span class="hidden sm:inline-flex ">|Extra</span>
                    </span>
                </li>
            </ol>
        </div>

        <p class="text-gray-700 mt-10 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.update_step_five', $quotation->id) }}" id="sitesForm">
            @csrf
            @method('PUT')

            <!-- Sites Section -->
            <div id="sites-section">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quotation Sites</h3>
                @forelse($quotation->siteSeeings->where('type', 'site') as $index => $site)
                    <div class="site-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                        <button type="button"
                            class="remove-site absolute top-2 right-2 text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="grid grid-cols-4 gap-4">
                            <!-- Site Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Site Name</label>
                                <input type="text" name="sites[{{ $index }}][name]"
                                    value="{{ $site->name }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <input type="hidden" name="sites[{{ $index }}][type]" value="site">
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit Price ( USD )</label>
                                <input type="number" name="sites[{{ $index }}][unit_price]"
                                    value="{{ $site->unit_price }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" required>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="sites[{{ $index }}][quantity]"
                                    value="{{ $site->quantity }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required disabled>
                            </div>

                            <!-- Per Adult Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Per Adult Price</label>
                                <input type="number" name="sites[{{ $index }}][price_per_adult]"
                                    value="{{ $site->price_per_adult }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" required disabled>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Default empty site entry -->
                    <div class="site-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                        <button type="button"
                            class="remove-site absolute top-2 right-2 text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="grid grid-cols-4 gap-4">
                            <!-- Site Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Site Name</label>
                                <input type="text" name="sites[0][name]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <input type="hidden" name="sites[0][type]" value="site">
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit Price ( USD )</label>
                                <input type="number" name="sites[0][unit_price]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" required>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="sites[0][quantity]" value="1"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required disabled>
                            </div>

                            <!-- Per Adult Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Per Adult Price</label>
                                <input type="number" name="sites[0][price_per_adult]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" required disabled>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Add Site Button -->
            <button type="button" id="add-site"
                class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                + Add Another Site
            </button>

            <!-- Site Extras Section -->
            <div id="site-extras-section" class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Site Extras</h3>
                @forelse($quotation->siteSeeings->where('type', 'extra') as $index => $extra)
                    <div class="site-extra-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                        <button type="button"
                            class="remove-site-extra absolute top-2 right-2 text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="grid grid-cols-4 gap-4">
                            <!-- Extra Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Extra Name</label>
                                <input type="text" name="site_extras[{{ $index }}][name]"
                                    value="{{ $extra->name }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <input type="hidden" name="site_extras[{{ $index }}][type]" value="extra">
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit Price ( USD )</label>
                                <input type="number" name="site_extras[{{ $index }}][unit_price]"
                                    value="{{ $extra->unit_price }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" required>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="site_extras[{{ $index }}][quantity]"
                                    value="{{ $extra->quantity }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <!-- Per Adult Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Per Adult Price</label>
                                <input type="number" name="site_extras[{{ $index }}][price_per_adult]"
                                    value="{{ $extra->price_per_adult }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" required disabled>
                            </div>
                        </div>
                    </div>
                @empty

                    <!-- Default empty extra entry -->
                    <div class="site-extra-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                        <button type="button"
                            class="remove-site-extra absolute top-2 right-2 text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="grid grid-cols-4 gap-4">
                            <!-- Extra Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Extra Name</label>
                                <input type="text" name="site_extras[0][name]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <input type="hidden" name="site_extras[0][type]" value="extra">
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit Price ( USD )</label>
                                <input type="number" name="site_extras[0][unit_price]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" required>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="site_extras[0][quantity]" value="1"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <!-- Per Adult Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Per Adult Price</label>
                                <input type="number" name="site_extras[0][price_per_adult]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" required disabled>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Add Site Extra Button -->
            <button type="button" id="add-site-extra"
                class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                + Add Another Extra
            </button>

            <!-- Add this after the sites-section div and before the form closing tag -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quotation Extras</h3>
                <div id="extras-section">
                    @forelse($quotation->extras as $index => $extra)
                        <div class="extra-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                            <button type="button"
                                class="remove-extra absolute top-2 right-2 text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <div class="grid grid-cols-5 gap-4">
                                <!-- Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" name="extras[{{ $index }}][date]"
                                        value="{{ $extra->date->format('Y-m-d') }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm"
                                        min="{{ $quotation->start_date }}" max="{{ $quotation->end_date }}"
                                        required>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" name="extras[{{ $index }}][description]"
                                        value="{{ $extra->description }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>

                                <!-- Unit Price -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Unit Price (USD)</label>
                                    <input type="number" name="extras[{{ $index }}][unit_price]"
                                        value="{{ $extra->unit_price }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                        min="0" required>
                                </div>

                                <!-- Quantity Per Pax -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Quantity Per Pax</label>
                                    <input type="number" name="extras[{{ $index }}][quantity_per_pax]"
                                        value="{{ $extra->quantity_per_pax }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" min="1"
                                        required>
                                </div>

                                <!-- Total Price -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Price (USD)</label>
                                    <input type="number" name="extras[{{ $index }}][total_price]"
                                        value="{{ $extra->total_price }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                        min="0" required disabled>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Default empty extra entry if no existing records -->
                        <div class="extra-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                            <button type="button"
                                class="remove-extra absolute top-2 right-2 text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <div class="grid grid-cols-5 gap-4">
                                <!-- Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" name="extras[0][date]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm"
                                        min="{{ $quotation->start_date }}" max="{{ $quotation->end_date }}"
                                        required>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" name="extras[0][description]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>

                                <!-- Unit Price -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Unit Price (USD)</label>
                                    <input type="number" name="extras[0][unit_price]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                        min="0" required>
                                </div>

                                <!-- Quantity Per Pax -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Quantity Per Pax</label>
                                    <input type="number" name="extras[0][quantity_per_pax]" value="1"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" min="1"
                                        required>
                                </div>

                                <!-- Total Price -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Price (USD)</label>
                                    <input type="number" name="extras[0][total_price]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                        min="0" required disabled>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Add Another Extra Button -->
                <button type="button" id="add-extra"
                    class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    + Add Another Extra
                </button>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ $navigation['back'] }}" class="bg-gray-500 text-white py-2 px-4 rounded-md">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Update & Complete
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let siteIndex = {{ count($quotation->siteSeeings->where('type', 'site')) }} || 0;
            let extraIndex = {{ count($quotation->siteSeeings->where('type', 'extra')) }} || 0;

            // Function to calculate price
            function calculatePrice(entry) {
                const unitPrice = parseFloat(entry.querySelector('input[name*="unit_price"]').value) || 0;
                const quantity = parseFloat(entry.querySelector('input[name*="quantity"]').value) || 1;
                const perAdultPriceInput = entry.querySelector('input[name*="price_per_adult"]');
                const perAdultPrice = unitPrice * quantity;
                perAdultPriceInput.value = perAdultPrice.toFixed(2);
            }

            // Add price listeners
            function addPriceListeners(entry) {
                const unitPriceInput = entry.querySelector('input[name*="unit_price"]');
                unitPriceInput.addEventListener('input', () => calculatePrice(entry));
            }

            // Initialize existing entries
            document.querySelectorAll('.site-entry, .site-extra-entry').forEach(entry => {
                addPriceListeners(entry);
                calculatePrice(entry);
            });

            // Add new site entry
            document.querySelector("#add-site").addEventListener("click", function() {
                siteIndex++;
                let newSite = document.querySelector(".site-entry").cloneNode(true);

                newSite.querySelectorAll("input").forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, `[${siteIndex}]`);
                    if (input.name.includes('quantity')) {
                        input.value = "1";
                    } else if (input.name.includes('type')) {
                        input.value = "site";
                    } else {
                        input.value = "";
                    }
                });

                addPriceListeners(newSite);
                document.querySelector("#sites-section").appendChild(newSite);
            });

            // Add new extra entry
            document.querySelector("#add-site-extra").addEventListener("click", function() {
                extraIndex++;
                let newExtra = document.querySelector(".site-extra-entry").cloneNode(true);

                newExtra.querySelectorAll("input").forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, `[${extraIndex}]`);
                    if (input.name.includes('quantity')) {
                        input.value = "1";
                    } else if (input.name.includes('type')) {
                        input.value = "extra";
                    } else {
                        input.value = "";
                    }
                });

                addPriceListeners(newExtra);
                document.querySelector("#site-extras-section").appendChild(newExtra);
            });

            // Remove entries
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-site')) {
                    const siteEntry = e.target.closest('.site-entry');
                    if (document.querySelectorAll('.site-entry').length > 1) {
                        siteEntry.remove();
                    } else {
                        alert('At least one site is required.');
                    }
                } else if (e.target.closest('.remove-site-extra')) {
                    const extraEntry = e.target.closest('.site-extra-entry');
                    if (document.querySelectorAll('.site-extra-entry').length > 1) {
                        extraEntry.remove();
                    } else {
                        alert('At least one extra is required.');
                    }
                }
            });

            // Form validation
            document.getElementById('sitesForm').addEventListener('submit', function(e) {
                e.preventDefault();
                let isValid = true;

                // Enable disabled fields
                document.querySelectorAll('input[disabled]').forEach(input => {
                    input.disabled = false;
                });

                // Validate sites
                document.querySelectorAll('.site-entry').forEach(entry => {
                    if (!validateEntry(entry)) isValid = false;
                });

                // Validate extras
                document.querySelectorAll('.site-extra-entry').forEach(entry => {
                    if (!validateEntry(entry)) isValid = false;
                });

                if (isValid) {
                    this.submit();
                }
            });

            function validateEntry(entry) {
                const nameInput = entry.querySelector('input[name*="name"]');
                const unitPriceInput = entry.querySelector('input[name*="unit_price"]');

                if (!nameInput.value.trim()) {
                    alert('Please enter all names');
                    return false;
                }

                if (!unitPriceInput.value || parseFloat(unitPriceInput.value) < 0) {
                    alert('Please enter valid unit prices');
                    return false;
                }

                return true;
            }
        });
    </script>

    <script>
        // Add to your existing JavaScript in step-05-edit.blade.php
        let extraIndex = {{ count($quotation->extras) }} || 0;

        // Function to calculate total price for extras
        function calculateTotalPrice(extraEntry) {
            const unitPrice = parseFloat(extraEntry.querySelector('input[name*="unit_price"]').value) || 0;
            const quantityPerPax = parseFloat(extraEntry.querySelector('input[name*="quantity_per_pax"]').value) || 1;
            const totalPriceInput = extraEntry.querySelector('input[name*="total_price"]');

            const totalPrice = unitPrice * quantityPerPax;
            totalPriceInput.value = totalPrice.toFixed(2);
        }

        // Add event listeners for price calculations
        function addExtraPriceListeners(extraEntry) {
            const unitPriceInput = extraEntry.querySelector('input[name*="unit_price"]');
            const quantityInput = extraEntry.querySelector('input[name*="quantity_per_pax"]');

            [unitPriceInput, quantityInput].forEach(input => {
                input.addEventListener('input', () => calculateTotalPrice(extraEntry));
            });
        }

        // Set date restrictions on extra entries
        function setDateRestrictions(extraEntry) {
            const dateInput = extraEntry.querySelector('input[name*="date"]');
            if (dateInput) {
                dateInput.min = "{{ $quotation->start_date }}";
                dateInput.max = "{{ $quotation->end_date }}";

                dateInput.addEventListener('change', function(e) {
                    const selectedDate = new Date(this.value);
                    const startDate = new Date("{{ $quotation->start_date }}");
                    const endDate = new Date("{{ $quotation->end_date }}");

                    if (selectedDate < startDate || selectedDate > endDate) {
                        alert('Date must be within the quotation duration');
                        this.value = '';
                    }
                });
            }
        }

        // Initialize existing extras
        document.querySelectorAll('.extra-entry').forEach(entry => {
            addExtraPriceListeners(entry);
            setDateRestrictions(entry);
        });

        // Add new extra entry
        document.querySelector("#add-extra").addEventListener("click", function() {
            extraIndex++;
            let newExtra = document.querySelector(".extra-entry").cloneNode(true);

            // Clear values and update indexes
            newExtra.querySelectorAll("input").forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${extraIndex}]`);
                if (input.name.includes('quantity_per_pax')) {
                    input.value = "1";
                } else {
                    input.value = "";
                }
            });

            // Add price listeners to new entry
            addExtraPriceListeners(newExtra);
            setDateRestrictions(newExtra);

            document.querySelector("#extras-section").appendChild(newExtra);
        });

        // Remove extra entry
        document.addEventListener("click", function(e) {
            if (e.target.closest('.remove-extra')) {
                const extraEntry = e.target.closest('.extra-entry');
                if (document.querySelectorAll('.extra-entry').length > 1) {
                    extraEntry.remove();
                } else {
                    alert('At least one extra is required.');
                }
            }
        });

        // Enable disabled fields before form submission
        document.getElementById('sitesForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const extraEntries = document.querySelectorAll('.extra-entry');
            let isValid = true;

            extraEntries.forEach(entry => {
                const totalPriceInput = entry.querySelector('input[name*="total_price"]');
                totalPriceInput.disabled = false;

                // Validate required fields
                const dateInput = entry.querySelector('input[name*="date"]');
                const descriptionInput = entry.querySelector('input[name*="description"]');
                const unitPriceInput = entry.querySelector('input[name*="unit_price"]');
                const quantityInput = entry.querySelector('input[name*="quantity_per_pax"]');

                if (!dateInput.value || !descriptionInput.value || !unitPriceInput.value || !quantityInput
                    .value) {
                    isValid = false;
                    alert('Please fill in all required fields for extras');
                    return;
                }
            });

            if (isValid) {
                this.submit();
            }
        });
    </script>
</x-app-layout>
