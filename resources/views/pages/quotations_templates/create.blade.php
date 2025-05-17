<!-- filepath: d:\Saruna\Work\sisisn-travel\resources\views\pages\quotations_templates\create.blade.php -->
<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Quotation Template</h2>
        
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('quotations_templates.store') }}" id="templateForm">
            @csrf

            <!-- Template Basic Info -->
            <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Template Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="template_name" class="block text-sm font-medium text-gray-700 mb-1">Template Name</label>
                        <input type="text" id="template_name" name="template_name" value="{{ old('template_name') }}" 
                               class="block w-full border-gray-300 rounded-md shadow-sm" >
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="2" 
                                  class="block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Accommodations Section -->
            <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Accommodations</h3>
                
                <div id="accommodation-section" class="space-y-6">
                    <!-- Cards will be inserted here -->
                </div>

                <button type="button" id="add-hotel"
                    class="mt-6 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Another Hotel
                </button>
            </div>

            <!-- Travel Plans Section -->
            <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Travel Plans</h3>
                
                <div id="travel-plan-section">
                    <div class="travel-entry border p-4 rounded-lg mb-4 bg-white relative">
                        <button type="button" class="remove-travel absolute top-2 right-2 text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Route -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Route</label>
                                <select name="travel_plans[0][route_id]"
                                    class="route-select block w-full border-gray-300 rounded-md shadow-sm" >
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
                                <select name="travel_plans[0][vehicle_type_id]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm" >
                                    <option value="">Select Vehicle</option>
                                    @foreach ($vehicleTypes as $vehicleType)
                                        <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Mileage -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Mileage</label>
                                <input type="number" name="travel_plans[0][mileage]"
                                    class="mileage-input block w-full border-gray-300 rounded-md shadow-sm" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Another Travel Plan Button -->
                <button type="button" id="add-travel"
                    class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    + Add Another Travel Plan
                </button>
            </div>

            <!-- Quotation Sites Section (Horizontal Format) -->
            <div class="mb-8 bg-gray-50 p-6 rounded-lg">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Quotation Sites</h3>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 text-left border-b">Site Name</th>
                    <th class="py-3 px-4 text-left border-b">Unit Price (USD)</th>
                    <th class="py-3 px-4 text-left border-b">Quantity</th>
                    <th class="py-3 px-4 text-left border-b">Per Adult Price</th>
                    <th class="py-3 px-4 text-left border-b">Actions</th>
                </tr>
            </thead>
            <tbody id="sites-section">
                <tr class="site-entry hover:bg-gray-50">
                    <td class="py-3 px-4 border-b">
                        <input type="text" name="site_seeings[0][name]" class="block w-full border-gray-300 rounded-md shadow-sm" >
                        <input type="hidden" name="site_seeings[0][type]" value="site">
                    </td>
                    <td class="py-3 px-4 border-b">
                        <input type="number" name="site_seeings[0][unit_price]" class="site-unit-price block w-full border-gray-300 rounded-md shadow-sm" 
                               step="0.01" min="0" >
                    </td>
                    <td class="py-3 px-4 border-b">
                        <input type="number" name="site_seeings[0][quantity]" value="1" 
                               class="site-quantity block w-full border-gray-300 rounded-md shadow-sm" min="1" >
                    </td>
                    <td class="py-3 px-4 border-b">
                        <input type="number" name="site_seeings[0][price_per_adult]" 
                               class="site-price-per-adult block w-full border-gray-300 rounded-md shadow-sm" 
                               step="0.01" min="0" readonly>
                    </td>
                    <td class="py-3 px-4 border-b">
                        <button type="button" class="remove-site text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Add Site Button -->
    <button type="button" id="add-site" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
        + Add Another Site
    </button>
</div>

            <!-- Site Extras Section (Horizontal Format) -->
            <div class="mb-8 bg-gray-50 p-6 rounded-lg">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Site Extras</h3>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 text-left border-b">Extra Name</th>
                    <th class="py-3 px-4 text-left border-b">Unit Price (USD)</th>
                    <th class="py-3 px-4 text-left border-b">Quantity</th>
                    <th class="py-3 px-4 text-left border-b">Per Adult Price</th>
                    <th class="py-3 px-4 text-left border-b">Actions</th>
                </tr>
            </thead>
            <tbody id="site-extras-section">
                <tr class="site-extra-entry hover:bg-gray-50">
                    <td class="py-3 px-4 border-b">
                        <input type="text" name="site_extras[0][name]" class="block w-full border-gray-300 rounded-md shadow-sm" >
                        <input type="hidden" name="site_extras[0][type]" value="extra">
                    </td>
                    <td class="py-3 px-4 border-b">
                        <input type="number" name="site_extras[0][unit_price]" class="extra-unit-price block w-full border-gray-300 rounded-md shadow-sm" 
                               step="0.01" min="0" >
                    </td>
                    <td class="py-3 px-4 border-b">
                        <input type="number" name="site_extras[0][quantity]" value="1" 
                               class="extra-quantity block w-full border-gray-300 rounded-md shadow-sm" min="1" >
                    </td>
                    <td class="py-3 px-4 border-b">
                        <input type="number" name="site_extras[0][price_per_adult]" 
                               class="extra-price-per-adult block w-full border-gray-300 rounded-md shadow-sm" 
                               step="0.01" min="0" readonly>
                    </td>
                    <td class="py-3 px-4 border-b">
                        <button type="button" class="remove-site-extra text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Add Site Extra Button -->
    <button type="button" id="add-site-extra" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
        + Add Another Extra
    </button>
</div>

            <!-- Quotation Extras Section (Horizontal Format) - Date removed -->
            <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quotation Extras</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left border-b">Description</th>
                                <th class="py-3 px-4 text-left border-b">Unit Price (USD)</th>
                                <th class="py-3 px-4 text-left border-b">Quantity Per Pax</th>
                                <th class="py-3 px-4 text-left border-b">Total Price (USD)</th>
                                <th class="py-3 px-4 text-left border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="extras-section">
                            <tr class="extra-entry hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">
                                    <input type="text" name="extras[0][description]" class="block w-full border-gray-300 rounded-md shadow-sm" >
                                </td>
                                <td class="py-3 px-4 border-b">
                                    <input type="number" name="extras[0][unit_price]" class="quotation-unit-price block w-full border-gray-300 rounded-md shadow-sm" 
                                           step="0.01" min="0" >
                                </td>
                                <td class="py-3 px-4 border-b">
                                    <input type="number" name="extras[0][quantity_per_pax]" value="1" 
                                           class="quotation-quantity block w-full border-gray-300 rounded-md shadow-sm" min="1" >
                                </td>
                                <td class="py-3 px-4 border-b">
                                    <input type="number" name="extras[0][total_price]" 
                                           class="quotation-total-price block w-full border-gray-300 rounded-md shadow-sm" 
                                           step="0.01" min="0" readonly>
                                </td>
                                <td class="py-3 px-4 border-b">
                                    <button type="button" class="remove-extra text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Add Quotation Extra Button -->
                <button type="button" id="add-extra" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    + Add Another Extra
                </button>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ route('quotations_templates.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Create Template
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ======================= ACCOMMODATIONS =======================
            const hotelSelectOptions =
                `@foreach ($hotels as $hotel)<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>@endforeach`;
            const mealPlanOptions =
                `@foreach ($mealPlans as $mealPlan)<option value="{{ $mealPlan->id }}">{{ $mealPlan->name }}</option>@endforeach`;
            const roomCategoryOptions =
                `@foreach ($roomCategories as $roomCategory)<option value="{{ $roomCategory->id }}">{{ $roomCategory->name }}</option>@endforeach`;

            function addAccommodationCard() {
                let cardIndex = document.querySelectorAll('#accommodation-section > div').length;

                let cardHtml = `
                    <div class="bg-white rounded-lg p-6 relative accommodation-card border">
                        <button type="button" class="absolute top-4 right-4 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 remove-card">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hotel</label>
                                    <select name="accommodations[${cardIndex}][hotel_id]" class="hotel-select block w-full border-gray-300 rounded-md shadow-sm" >
                                        <option value="">Select Hotel</option>
                                        ${hotelSelectOptions}
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Meal Plan</label>
                                        <select name="accommodations[${cardIndex}][meal_plan_id]" class="block w-full border-gray-300 rounded-md shadow-sm" >
                                            <option value="">Select Plan</option>${mealPlanOptions}
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Room Category</label>
                                        <select name="accommodations[${cardIndex}][room_category_id]" class="block w-full border-gray-300 rounded-md shadow-sm" >
                                            <option value="">Select Category</option>${roomCategoryOptions}
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3">
                                    <p class="text-xs text-yellow-800">
                                        <strong>Note:</strong> Nights will be determined when creating an actual quotation based on client's travel duration.
                                    </p>
                                </div>
                            </div>

                            <!-- Right Column - Room Details -->
                            <div class="space-y-4">
                                <h3 class="font-medium text-gray-900">Room Rate Per Night</h3>
                                
                                <!-- Room Types -->
                                <div class="space-y-4">
                                    <!-- Single Room -->
                                    <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Single Room</span>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night (USD)</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][single][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm text-center">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Double Room -->
                                    <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Double Room</span>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night (USD)</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][double][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm text-center">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Triple Room -->
                                    <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-gray-700">Triple Room</span>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <div>
                                                <label class="block text-xs text-gray-500">Per Night (USD)</label>
                                                <input type="number" name="accommodations[${cardIndex}][room_types][triple][per_night_cost]" 
                                                     class="block w-full border-gray-300 rounded-md shadow-sm text-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.querySelector("#accommodation-section").insertAdjacentHTML("beforeend", cardHtml);
            }

            // ======================= TRAVEL PLANS =======================
            let travelIndex = 1;
            function addTravelEntry() {
                let newTravel = document.querySelector(".travel-entry").cloneNode(true);

                // Clear values and update indexes
                newTravel.querySelectorAll("select, input").forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, "[" + travelIndex + "]");
                    input.value = "";
                });

                // Append new entry
                document.querySelector("#travel-plan-section").appendChild(newTravel);

                // Attach event listener to the new route dropdown
                newTravel.querySelector(".route-select").addEventListener("change", function() {
                    let mileage = this.options[this.selectedIndex].getAttribute("data-mileage");
                    this.closest(".travel-entry").querySelector(".mileage-input").value = mileage;
                });

                travelIndex++;
            }

            // ======================= SITE SEEINGS (TABLE FORMAT) =======================
            let siteIndex = 1;
            
            // Function to calculate per adult price for sites
            function calculateSitePerAdultPrice(row) {
                const unitPrice = parseFloat(row.querySelector('.site-unit-price').value) || 0;
                const quantity = parseFloat(row.querySelector('.site-quantity').value) || 1;
                const perAdultPrice = unitPrice * quantity;
                row.querySelector('.site-price-per-adult').value = perAdultPrice.toFixed(2);
            }
            
            // Add listeners to the first site entry
            document.querySelectorAll('.site-entry').forEach(row => {
                const unitPriceInput = row.querySelector('.site-unit-price');
                const quantityInput = row.querySelector('.site-quantity');
                
                unitPriceInput.addEventListener('input', () => calculateSitePerAdultPrice(row));
                quantityInput.addEventListener('input', () => calculateSitePerAdultPrice(row));
                
                // Initialize the calculation
                calculateSitePerAdultPrice(row);
            });
            
            function addSiteEntry() {
    let newRow = document.querySelector(".site-entry").cloneNode(true);
    
    // Clear values and update indexes
    newRow.querySelectorAll("input").forEach(input => {
        input.name = input.name.replace(/\[\d+\]/, "[" + siteIndex + "]");
        if (input.name.includes('quantity')) {
            input.value = "1";
        } else if (input.name.includes('type')) {
            input.value = "site"; // Keep the type value
        } else if (!input.name.includes('price_per_adult')) {
            input.value = "";
        }
    });

    // Add event listeners to new site row
    const unitPriceInput = newRow.querySelector('.site-unit-price');
    const quantityInput = newRow.querySelector('.site-quantity');
    
    unitPriceInput.addEventListener('input', () => calculateSitePerAdultPrice(newRow));
    quantityInput.addEventListener('input', () => calculateSitePerAdultPrice(newRow));
    
    // Reset price_per_adult
    newRow.querySelector('.site-price-per-adult').value = "";
    
    document.querySelector("#sites-section").appendChild(newRow);
    siteIndex++;
}

            // ======================= SITE EXTRAS (TABLE FORMAT) =======================
            let siteExtraIndex = 1;
            
            // Function to calculate per adult price for site extras
            function calculateExtraPerAdultPrice(row) {
                const unitPrice = parseFloat(row.querySelector('.extra-unit-price').value) || 0;
                const quantity = parseFloat(row.querySelector('.extra-quantity').value) || 1;
                const perAdultPrice = unitPrice * quantity;
                row.querySelector('.extra-price-per-adult').value = perAdultPrice.toFixed(2);
            }
            
            // Add listeners to the first site extra entry
            document.querySelectorAll('.site-extra-entry').forEach(row => {
                const unitPriceInput = row.querySelector('.extra-unit-price');
                const quantityInput = row.querySelector('.extra-quantity');
                
                unitPriceInput.addEventListener('input', () => calculateExtraPerAdultPrice(row));
                quantityInput.addEventListener('input', () => calculateExtraPerAdultPrice(row));
                
                // Initialize the calculation
                calculateExtraPerAdultPrice(row);
            });
            
            function addSiteExtraEntry() {
    let newRow = document.querySelector(".site-extra-entry").cloneNode(true);
    
    // Clear values and update indexes
    newRow.querySelectorAll("input").forEach(input => {
        input.name = input.name.replace(/\[\d+\]/, "[" + siteExtraIndex + "]");
        if (input.name.includes('quantity')) {
            input.value = "1";
        } else if (input.name.includes('type')) {
            input.value = "extra"; // Keep the type value
        } else if (!input.name.includes('price_per_adult')) {
            input.value = "";
        }
    });

    // Add event listeners to new site extra row
    const unitPriceInput = newRow.querySelector('.extra-unit-price');
    const quantityInput = newRow.querySelector('.extra-quantity');
    
    unitPriceInput.addEventListener('input', () => calculateExtraPerAdultPrice(newRow));
    quantityInput.addEventListener('input', () => calculateExtraPerAdultPrice(newRow));
    
    // Reset price_per_adult
    newRow.querySelector('.extra-price-per-adult').value = "";
    
    document.querySelector("#site-extras-section").appendChild(newRow);
    siteExtraIndex++;
}

            // ======================= QUOTATION EXTRAS (TABLE FORMAT) =======================
            let extraIndex = 1;
            
            // Function to calculate total price for quotation extras
            function calculateQuotationTotalPrice(row) {
                const unitPrice = parseFloat(row.querySelector('.quotation-unit-price').value) || 0;
                const quantity = parseFloat(row.querySelector('.quotation-quantity').value) || 1;
                const totalPrice = unitPrice * quantity;
                row.querySelector('.quotation-total-price').value = totalPrice.toFixed(2);
            }
            
            // Add listeners to the first quotation extra entry
            document.querySelectorAll('.extra-entry').forEach(row => {
                const unitPriceInput = row.querySelector('.quotation-unit-price');
                const quantityInput = row.querySelector('.quotation-quantity');
                
                unitPriceInput.addEventListener('input', () => calculateQuotationTotalPrice(row));
                quantityInput.addEventListener('input', () => calculateQuotationTotalPrice(row));
                
                // Initialize the calculation
                calculateQuotationTotalPrice(row);
            });
            
            function addExtraEntry() {
                let newRow = document.querySelector(".extra-entry").cloneNode(true);

                // Clear values and update indexes
                newRow.querySelectorAll("input").forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, "[" + extraIndex + "]");
                    if (input.name.includes('quantity_per_pax')) {
                        input.value = "1";
                    } else if (!input.name.includes('total_price')) {
                        input.value = "";
                    }
                });

                // Add event listeners to new quotation extra row
                const unitPriceInput = newRow.querySelector('.quotation-unit-price');
                const quantityInput = newRow.querySelector('.quotation-quantity');
                
                unitPriceInput.addEventListener('input', () => calculateQuotationTotalPrice(newRow));
                quantityInput.addEventListener('input', () => calculateQuotationTotalPrice(newRow));
                
                // Reset total_price
                newRow.querySelector('.quotation-total-price').value = "";
                
                document.querySelector("#extras-section").appendChild(newRow);
                extraIndex++;
            }

            // ======================= EVENT LISTENERS =======================
            
            // Add hotel button
            document.getElementById("add-hotel").addEventListener("click", addAccommodationCard);
            
            // Remove hotel card
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-card')) {
                    const card = e.target.closest('.accommodation-card');
                    if (document.querySelectorAll('.accommodation-card').length > 1) {
                        card.remove();
                    } else {
                        alert('At least one accommodation is .');
                    }
                }
            });

            // Add travel plan button
            document.getElementById("add-travel").addEventListener("click", addTravelEntry);
            
            // Remove travel plan
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-travel')) {
                    const entry = e.target.closest('.travel-entry');
                    if (document.querySelectorAll('.travel-entry').length > 1) {
                        entry.remove();
                    } else {
                        alert('At least one travel plan is required.');
                    }
                }
            });

            // Add site seeing button
            document.getElementById("add-site").addEventListener("click", addSiteEntry);
            
            // Remove site seeing
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-site')) {
                    const row = e.target.closest('.site-entry');
                    if (document.querySelectorAll('.site-entry').length > 1) {
                        row.remove();
                    } else {
                        alert('At least one site seeing is required.');
                    }
                }
            });

            // Add site extra button
            document.getElementById("add-site-extra").addEventListener("click", addSiteExtraEntry);
            
            // Remove site extra
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-site-extra')) {
                    const row = e.target.closest('.site-extra-entry');
                    if (document.querySelectorAll('.site-extra-entry').length > 1) {
                        row.remove();
                    } else {
                        alert('At least one site extra is required.');
                    }
                }
            });

            // Add extra button
            document.getElementById("add-extra").addEventListener("click", addExtraEntry);
            
            // Remove extra
            document.addEventListener("click", function(e) {
                if (e.target.closest('.remove-extra')) {
                    const row = e.target.closest('.extra-entry');
                    if (document.querySelectorAll('.extra-entry').length > 1) {
                        row.remove();
                    } else {
                        alert('At least one extra is required.');
                    }
                }
            });

            // Attach event listener to existing route dropdowns
            document.querySelectorAll(".route-select").forEach(select => {
                select.addEventListener("change", function() {
                    let mileage = this.options[this.selectedIndex].getAttribute("data-mileage");
                    this.closest(".travel-entry").querySelector(".mileage-input").value = mileage;
                });
            });

            // Form submission - enable read-only fields
            document.getElementById('templateForm').addEventListener('submit', function() {
                // Enable all readonly fields to ensure they get submitted
                document.querySelectorAll('.site-price-per-adult, .extra-price-per-adult, .quotation-total-price').forEach(input => {
                    input.readOnly = false;
                });
            });

            // Initialize with default entries
            addAccommodationCard();
            
            // Initialize the calculations for existing entries
            document.querySelectorAll('.site-entry').forEach(row => {
                calculateSitePerAdultPrice(row);
            });
            
            document.querySelectorAll('.site-extra-entry').forEach(row => {
                calculateExtraPerAdultPrice(row);
            });
            
            document.querySelectorAll('.extra-entry').forEach(row => {
                calculateQuotationTotalPrice(row);
            });
        });
    </script>
</x-app-layout>