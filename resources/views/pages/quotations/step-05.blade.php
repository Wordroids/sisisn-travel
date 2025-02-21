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
                        Site <span class="hidden sm:inline-flex sm:ms-2">Details</span>
                    </span>
                </li>
            </ol>
        </div>

        <p class="text-gray-700 mt-10 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step5.store', $quotation->id) }}" id="sitesForm">
            @csrf

            <div id="sites-section">
                <div class="site-entry border p-4 rounded-lg mb-4 bg-gray-100 relative">
                    <button type="button" class="remove-site absolute top-2 right-2 text-red-500 hover:text-red-700">
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
                        </div>

                        <!-- Unit Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit Price ( USD )</label>
                            <input type="number" name="sites[0][unit_price]"
                                class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01" min="0"
                                required>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="sites[0][quantity]" value="1"
                                class="block w-full border-gray-300 rounded-md shadow-sm" required disabled>
                        </div>

                        <!-- Per Adult Price-->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Per Adult Price</label>
                            <input type="number" name="sites[0][price_per_adult]"
                                class="block w-full border-gray-300 rounded-md shadow-sm" step="0.01" min="0"
                                required disabled>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Add Another Site Button -->
            <button type="button" id="add-site"
                class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                + Add Another Site
            </button>

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

            // Function to calculate per adult price
            function calculatePerAdultPrice(siteEntry) {
                const unitPrice = parseFloat(siteEntry.querySelector('input[name*="unit_price"]').value) || 0;
                const quantity = parseFloat(siteEntry.querySelector('input[name*="quantity"]').value) || 1;
                const perAdultPriceInput = siteEntry.querySelector('input[name*="price_per_adult"]');

                const perAdultPrice = unitPrice * quantity;
                perAdultPriceInput.value = perAdultPrice.toFixed(2);
            }

            // Add event listener for unit price changes
            function addUnitPriceListener(siteEntry) {
                const unitPriceInput = siteEntry.querySelector('input[name*="unit_price"]');
                unitPriceInput.addEventListener('input', function() {
                    calculatePerAdultPrice(siteEntry);
                });
            }

            // Add initial listener to first site entry
            addUnitPriceListener(document.querySelector('.site-entry'));

            // Add new site entry
            function addSiteEntry() {
                let newSite = document.querySelector(".site-entry").cloneNode(true);

                // Clear values and update indexes
                newSite.querySelectorAll("input").forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, "[" + siteIndex + "]");
                    if (input.name.includes('quantity')) {
                        input.value = "1"; // Set default quantity to 1
                    } else {
                        input.value = "";
                    }
                });

                // Add unit price listener to new entry
                addUnitPriceListener(newSite);

                // Append new entry
                document.querySelector("#sites-section").appendChild(newSite);
                siteIndex++;
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

            // Attach event listener to "Add Site" button
            document.querySelector("#add-site").addEventListener("click", addSiteEntry);

            // Form validation
            document.getElementById('sitesForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const siteEntries = document.querySelectorAll('.site-entry');
                let isValid = true;

                siteEntries.forEach(entry => {
                    const nameInput = entry.querySelector('input[name*="name"]');
                    const unitPriceInput = entry.querySelector('input[name*="unit_price"]');
                    const quantityInput = entry.querySelector('input[name*="quantity"]');
                    const perAdultPriceInput = entry.querySelector(
                    'input[name*="price_per_adult"]');

                    // Enable disabled fields before submit to include their values
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

                    // Recalculate per adult price before submit
                    const unitPrice = parseFloat(unitPriceInput.value) || 0;
                    const quantity = parseFloat(quantityInput.value) || 1;
                    perAdultPriceInput.value = (unitPrice * quantity).toFixed(2);
                });

                if (isValid) {
                    // Create hidden fields for any additional data if needed
                    const formData = new FormData(this);

                    // Submit the form with all data
                    this.submit();

                    // Re-disable the fields after submission
                    siteEntries.forEach(entry => {
                        const quantityInput = entry.querySelector('input[name*="quantity"]');
                        const perAdultPriceInput = entry.querySelector(
                            'input[name*="price_per_adult"]');
                        quantityInput.disabled = true;
                        perAdultPriceInput.disabled = true;
                    });
                }
            });
        });
    </script>
</x-app-layout>
