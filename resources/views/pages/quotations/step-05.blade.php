<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <!-- Step 1: Reference Info -->
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

                <!-- Step 2: Pax Slab -->
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_two', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </a>
                </li>

                <!-- Step 3: Accommodation -->
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_three', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Accommodation
                    </a>
                </li>

                <!-- Step 4: Travel Plan -->
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_four', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan</span>
                    </a>
                </li>

                <!-- Step 5: Sites Details (Current) -->
                <li class="flex items-center text-blue-600">
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

        <form method="POST" action="{{ route('quotations.step5.store', $quotation->id) }}" id="sitesForm">
            @csrf

            <!-- Replace the existing sites section with this -->
<div id="sites-section">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Quotation Sites</h3>
    <div class="site-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
        <button type="button" class="remove-site absolute top-2 right-2 text-red-500 hover:text-red-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="grid grid-cols-4 gap-4">
            <!-- Site Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Site Name</label>
                <input type="text" name="sites[0][name]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                <input type="hidden" name="sites[0][type]" value="site">
            </div>

            <!-- Unit Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Unit Price ( USD )</label>
                <input type="number" name="sites[0][unit_price]" class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01" min="0" required>
            </div>

            <!-- Quantity -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="sites[0][quantity]" value="1" class="block w-full border-gray-300 rounded-md shadow-sm" required disabled>
            </div>

            <!-- Per Adult Price-->
            <div>
                <label class="block text-sm font-medium text-gray-700">Per Adult Price</label>
                <input type="number" name="sites[0][price_per_adult]" class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01" min="0" required disabled>
            </div>
        </div>
    </div>
</div>

<!-- Add Site Button -->
<button type="button" id="add-site" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
    + Add Another Site
</button>

<!-- Site Extras Section -->
<div id="site-extras-section" class="mt-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Site Extras</h3>
    <div class="site-extra-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
        <button type="button" class="remove-site-extra absolute top-2 right-2 text-red-500 hover:text-red-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="grid grid-cols-4 gap-4">
            <!-- Extra Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Extra Name</label>
                <input type="text" name="site_extras[0][name]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                <input type="hidden" name="site_extras[0][type]" value="extra">
            </div>

            <!-- Unit Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Unit Price ( USD )</label>
                <input type="number" name="site_extras[0][unit_price]" class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01" min="0" required>
            </div>

            <!-- Quantity -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="site_extras[0][quantity]" value="1" class="block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <!-- Per Adult Price-->
            <div>
                <label class="block text-sm font-medium text-gray-700">Per Adult Price</label>
                <input type="number" name="site_extras[0][price_per_adult]" class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01" min="0" required disabled>
            </div>
        </div>
    </div>
</div>

<!-- Add Site Extra Button -->
<button type="button" id="add-site-extra" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
    + Add Another Site Extra
</button>

            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quotation Extras</h3>
                <div id="extras-section">
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
                                    min="{{ $quotation->start_date }}" max="{{ $quotation->end_date }}">
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="extras[0][description]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit Price (USD)</label>
                                <input type="number" name="extras[0][unit_price]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0">
                            </div>

                            <!-- Quantity Per Pax -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity Per Pax</label>
                                <input type="number" name="extras[0][quantity_per_pax]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" min="1">
                            </div>

                            <!-- Total Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Price (USD)</label>
                                <input type="number" name="extras[0][total_price]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01"
                                    min="0" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Another Extra Button -->
                <button type="button" id="add-extra"
                    class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    + Add Another Extra
                </button>
            </div>

            <div class="flex justify-between mt-6">
                @if (isset($navigation['back']))
                    <a href="{{ $navigation['back'] }}"
                        class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
                        Back
                    </a>
                @else
                    <div></div>
                @endif

                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Save & Complete
                </button>
            </div>
        </form>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let siteIndex = 1;
            let siteExtraIndex = 1;
        
            // Function to calculate per adult price
            function calculatePerAdultPrice(entry) {
                const unitPrice = parseFloat(entry.querySelector('input[name*="unit_price"]').value) || 0;
                const quantity = parseFloat(entry.querySelector('input[name*="quantity"]').value) || 1;
                const perAdultPriceInput = entry.querySelector('input[name*="price_per_adult"]');
                const perAdultPrice = unitPrice * quantity;
                perAdultPriceInput.value = perAdultPrice.toFixed(2);
            }
        
            // Add event listener for unit price changes
            function addUnitPriceListener(entry) {
                const unitPriceInput = entry.querySelector('input[name*="unit_price"]');
                unitPriceInput.addEventListener('input', function() {
                    calculatePerAdultPrice(entry);
                });
            }
        
            // Add initial listeners
            addUnitPriceListener(document.querySelector('.site-entry'));
            addUnitPriceListener(document.querySelector('.site-extra-entry'));
        
            // Add new site entry
            function addSiteEntry() {
                let newSite = document.querySelector(".site-entry").cloneNode(true);
                
                // Clear values and update indexes
                newSite.querySelectorAll("input").forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, "[" + siteIndex + "]");
                    if (input.name.includes('quantity')) {
                        input.value = "1";
                    } else if (input.name.includes('type')) {
                        input.value = "site";
                    } else {
                        input.value = "";
                    }
                });
        
                addUnitPriceListener(newSite);
                document.querySelector("#sites-section").appendChild(newSite);
                siteIndex++;
            }
        
            // Add new site extra entry
            function addSiteExtraEntry() {
                let newExtra = document.querySelector(".site-extra-entry").cloneNode(true);
                
                // Clear values and update indexes
                newExtra.querySelectorAll("input").forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, "[" + siteExtraIndex + "]");
                    if (input.name.includes('quantity')) {
                        input.value = "1";
                    } else if (input.name.includes('type')) {
                        input.value = "extra";
                    } else {
                        input.value = "";
                    }
                });
        
                addUnitPriceListener(newExtra);
                document.querySelector("#site-extras-section").appendChild(newExtra);
                siteExtraIndex++;
            }
        
            // Remove site entry
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-site')) {
                    const siteEntry = e.target.closest('.site-entry');
                    if (document.querySelectorAll('.site-entry').length > 1) {
                        siteEntry.remove();
                    } else {
                        alert('At least one site is required.');
                    }
                }
            });
        
            // Remove site extra entry
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-site-extra')) {
                    const extraEntry = e.target.closest('.site-extra-entry');
                    if (document.querySelectorAll('.site-extra-entry').length > 1) {
                        extraEntry.remove();
                    } else {
                        alert('At least one site extra is required.');
                    }
                }
            });
        
            // Add button event listeners
            document.querySelector("#add-site").addEventListener("click", addSiteEntry);
            document.querySelector("#add-site-extra").addEventListener("click", addSiteExtraEntry);
        
            // Form validation and submission
            document.getElementById('sitesForm').addEventListener('submit', function(e) {
                e.preventDefault();
                let isValid = true;
        
                // Validate sites
                document.querySelectorAll('.site-entry').forEach(entry => {
                    const nameInput = entry.querySelector('input[name*="name"]');
                    const unitPriceInput = entry.querySelector('input[name*="unit_price"]');
                    const quantityInput = entry.querySelector('input[name*="quantity"]');
                    const perAdultPriceInput = entry.querySelector('input[name*="price_per_adult"]');
        
                    // Enable disabled fields
                    quantityInput.disabled = false;
                    perAdultPriceInput.disabled = false;
        
                    if (!nameInput.value.trim()) {
                        alert('Please enter all site names');
                        isValid = false;
                        return;
                    }
        
                    if (!unitPriceInput.value || parseFloat(unitPriceInput.value) < 0) {
                        alert('Please enter valid unit prices for all sites');
                        isValid = false;
                        return;
                    }
        
                    // Recalculate per adult price
                    calculatePerAdultPrice(entry);
                });
        
                // Validate site extras
                document.querySelectorAll('.site-extra-entry').forEach(entry => {
                    const nameInput = entry.querySelector('input[name*="name"]');
                    const unitPriceInput = entry.querySelector('input[name*="unit_price"]');
                    const quantityInput = entry.querySelector('input[name*="quantity"]');
                    const perAdultPriceInput = entry.querySelector('input[name*="price_per_adult"]');
        
                    // Enable disabled fields
                    perAdultPriceInput.disabled = false;
        
                    if (!nameInput.value.trim()) {
                        alert('Please enter all extra names');
                        isValid = false;
                        return;
                    }
        
                    if (!unitPriceInput.value || parseFloat(unitPriceInput.value) < 0) {
                        alert('Please enter valid unit prices for all extras');
                        isValid = false;
                        return;
                    }
        
                    // Recalculate per adult price
                    calculatePerAdultPrice(entry);
                });
        
                if (isValid) {
                    this.submit();
        
                    // Re-disable fields after submission
                    document.querySelectorAll('.site-entry, .site-extra-entry').forEach(entry => {
                        const quantityInput = entry.querySelector('input[name*="quantity"]');
                        const perAdultPriceInput = entry.querySelector('input[name*="price_per_adult"]');
                        
                        if (entry.classList.contains('site-entry')) {
                            quantityInput.disabled = true;
                        }
                        perAdultPriceInput.disabled = true;
                    });
                }
            });
        });
        </script>
        
    <script>
        // Get quotation dates from PHP variables
        const quotationStartDate = "{{ $quotation->start_date }}".split(' ')[0]; // Extract date part only
        const quotationEndDate = "{{ $quotation->end_date }}".split(' ')[0]; // Extract date part only

        // Function to set date restrictions on extra entries
        function setDateRestrictions(extraEntry) {
            const dateInput = extraEntry.querySelector('input[name*="date"]');
            if (dateInput) {
                dateInput.min = quotationStartDate;
                dateInput.max = quotationEndDate;

                // Add event listener to validate date
                dateInput.addEventListener('change', function(e) {
                    const selectedDate = new Date(this.value);
                    const startDate = new Date(quotationStartDate);
                    const endDate = new Date(quotationEndDate);

                    if (selectedDate < startDate || selectedDate > endDate) {
                        alert('Date must be within the quotation duration');
                        this.value = '';
                    }
                });
            }
        }

        // Extras handling
        let extraIndex = 1;

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

        // Add initial listener to first extra entry
        addExtraPriceListeners(document.querySelector('.extra-entry'));

        // Add new extra entry
        document.querySelector("#add-extra").addEventListener("click", function() {
            let newExtra = document.querySelector(".extra-entry").cloneNode(true);

            // Clear values and update indexes
            newExtra.querySelectorAll("input").forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, "[" + extraIndex + "]");
                if (input.name.includes('quantity_per_pax')) {
                    input.value = "1";
                } else {
                    input.value = "";
                }
            });

            // Add price listeners to new entry
            addExtraPriceListeners(newExtra);

            // Append new entry
            document.querySelector("#extras-section").appendChild(newExtra);
            extraIndex++;
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

        // Add extras validation to form submit
        document.getElementById('sitesForm').addEventListener('submit', function(e) {
            const extraEntries = document.querySelectorAll('.extra-entry');
            extraEntries.forEach(entry => {
                const totalPriceInput = entry.querySelector('input[name*="total_price"]');
                totalPriceInput.disabled = false;
            });
        });
    </script>
</x-app-layout>
