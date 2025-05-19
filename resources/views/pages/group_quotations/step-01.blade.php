<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">

        <!-- Progress Bar  -->
        <div>
            <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Reference <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </span>
                </li>
                <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">2</span>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab </span> <span class="hidden sm:inline-flex sm:ms-2"> Details</span>
                    </span>
                </li>
                <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">3</span>
                        Accommodation <span class="hidden sm:inline-flex sm:ms-2"> </span>
                    </span>
                </li>
                <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">4</span>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan </span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">5</span>
                    Site <span class="hidden sm:inline-flex ">|Extra</span>
                </li>
            </ol>
        </div>

        <!-- Template-based notification -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- If this quotation was created from a template, show an info message -->
        @if(isset($groupQuotation) && $groupQuotation->is_template)
            <div class="bg-blue-50 p-4 rounded-lg mb-6 mt-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium text-blue-800">
                            Template Applied
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-blue-700">
                            <p>This quotation was created using a template. Basic information has been pre-filled. Please complete all required fields and continue to the next step.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="pt-16">
            <form action="{{ route('group_quotations.store_step_01', $groupQuotation->id ?? '') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Pass the quotation ID if editing an existing one -->
                @if(isset($groupQuotation))
                    <input type="hidden" name="quotation_id" value="{{ $groupQuotation->id }}">
                @endif

                <div class="grid gap-6 grid-cols-4">
                    <div class="mb-4">
                        <label for="quote_reference" class="block mb-2 text-sm font-medium text-gray-900 test:text-white">Quote Reference</label>
                        <input disabled type="text" value="{{ $quoteReference ?? ($groupQuotation->quote_reference ?? '') }}" name="" id=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                        <input hidden type="text" value="{{ $quoteReference ?? ($groupQuotation->quote_reference ?? '') }}" name="quote_reference"
                            id="quote_reference">
                    </div>

                    <div class="mb-4">
                        <label for="booking_reference" class="block mb-2 text-sm font-medium text-gray-900 test:text-white">Booking Reference</label>
                        <input disabled type="text" value="{{ $bookingReference ?? ($groupQuotation->booking_reference ?? '') }}" name="" id=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                        <input hidden type="text" value="{{ $bookingReference ?? ($groupQuotation->booking_reference ?? '') }}" name="booking_reference"
                            id="booking_reference">
                    </div>
                </div>

                <div class="grid gap-6 grid-cols-4">
                    <!-- Market Drop Down -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Market</label>
                        <select name="market_id" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Market</option>
                            @foreach ($markets as $market)
                                <option value="{{ $market->id }}" {{ (isset($groupQuotation) && $groupQuotation->market_id == $market->id) ? 'selected' : '' }}>
                                    {{ $market->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('market_id')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Drop Down -->
                    <div class="mb-4 grid grid-cols-4">
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Customer</label>
                            <select id="customer_id" name="customer_id" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ (isset($groupQuotation) && $groupQuotation->customer_id == $customer->id) ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="text-center items-center justify-center flex mt-5">
                            <button type="button" class="bg-blue-700 text-white p-2 text-sm" onclick="openCustomerModal()">+ Add</button>
                        </div>
                    </div>

                    <!-- Date Range  -->
                    <div class="mb-4 col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Date Range</label>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="date" name="start_date" class="block w-full border-gray-300 rounded-md shadow-sm" 
                                value="{{ isset($groupQuotation) && $groupQuotation->start_date ? $groupQuotation->start_date->format('Y-m-d') : '' }}" required>
                            <input type="date" name="end_date" class="block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ isset($groupQuotation) && $groupQuotation->end_date ? $groupQuotation->end_date->format('Y-m-d') : '' }}" required>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 grid-cols-4">
                    <div class="mb-4">
                        <label for="no_of_days" class="block mb-2 text-sm font-medium text-gray-900 test:text-white">N.O Of days</label>
                        <input type="text" name="no_of_days" id="no_of_days" 
                            value="{{ $groupQuotation->duration ?? '' }}" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                    </div>

                    <div class="mb-4">
                        <label for="no_of_nights" class="block mb-2 text-sm font-medium text-gray-900 test:text-white">N.O Of Nights</label>
                        <input type="text" name="no_of_nights" id="no_of_nights"
                            value="{{ isset($groupQuotation) && $groupQuotation->duration ? ($groupQuotation->duration - 1) : '' }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Currency</label>
                        <select name="currency_id" id="currency_id" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" data-rate="{{ $currency->conversion_rate }}"
                                    {{ (isset($groupQuotation) && $groupQuotation->currency == $currency->code) ? 'selected' : 
                                       (strtolower($currency->code) === 'usd' ? 'selected' : '') }}>
                                    {{ $currency->code }}
                                </option>
                            @endforeach
                        </select>
                        @error('currency_id')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <div class="flex gap-3">
                            <div class="mb-4">
                                <label for="conversion_rate" class="block mb-2 text-sm font-medium text-gray-900">Conversion Rate</label>
                                <input type="text" name="conversion_rate" id="conversion_rate"
                                    class="block w-full border-gray-300 rounded-md shadow-sm"
                                    value="{{ isset($groupQuotation) ? $groupQuotation->conversion_rate : ($currencies->where('code', 'USD')->first()->conversion_rate ?? '') }}"
                                    readonly>
                                @error('conversion_rate')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 grid-cols-4">
                    <div class="mb-4">
                        <label for="markup_id" class="block mb-2 text-sm font-medium text-gray-900 test:text-white">
                            Markup Value Per Pax
                        </label>
                        <select name="markup_per_pax" id="markup_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500"
                            required>
                            <option value="">Select Markup</option>
                            @foreach ($markups as $markup)
                                <option value="{{ $markup->amount }}" data-amount="{{ $markup->amount }}"
                                    {{ (isset($groupQuotation) && $groupQuotation->markup_per_person == $markup->amount) ? 'selected' : '' }}>
                                    {{ $markup->name }} ({{ $markup->amount }})
                                </option>
                            @endforeach
                        </select>
                        @error('markup_per_pax')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Pax Slab</label>
                        <select name="pax_slab_id" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Pax Slab</option>
                            @foreach ($paxSlabs as $paxSlab)
                                <option value="{{ $paxSlab->id }}" 
                                    {{ (isset($groupQuotation) && $groupQuotation->pax_slab_id == $paxSlab->id) ? 'selected' : '' }}>
                                    {{ $paxSlab->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('pax_slab_id')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Driver</label>
                        <select name="driver_id" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Driver</option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}"
                                    {{ (isset($groupQuotation) && $groupQuotation->driver_id == $driver->id) ? 'selected' : '' }}>
                                    {{ $driver->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('driver_id')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Guide</label>
                        <select name="guide_id" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Guide</option>
                            @foreach ($guides as $guide)
                                <option value="{{ $guide->id }}"
                                    {{ (isset($groupQuotation) && $groupQuotation->guide_id == $guide->id) ? 'selected' : '' }}>
                                    {{ $guide->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('guide_id')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    @if (isset($navigation['back']))
                        <a href="{{ $navigation['back'] }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Back
                        </a>
                    @else
                        <div></div> {{-- Empty div to maintain spacing --}}
                    @endif

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        {{ $navigation['submit_text'] ?? 'Next Step' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Customer Modal -->
    <div id="customerModal"
        class="fixed inset-0 z-50 hidden overflow-auto bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-lg font-semibold mb-4">Add New Customer</h3>
            <form id="customerForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="customer_name"
                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="customer_email"
                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="number" name="phone" id="customer_phone"
                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Whatsapp</label>
                    <input type="number" name="whatsapp" id="customer_whatsapp"
                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Country</label>
                    <input type="text" name="country" id="customer_country"
                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                        onclick="closeCustomerModal()">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currencySelect = document.getElementById('currency_id');
            const conversionRateInput = document.getElementById('conversion_rate');

            function updateConversionRate() {
                const selectedOption = currencySelect.options[currencySelect.selectedIndex];
                const rate = selectedOption.getAttribute('data-rate');
                conversionRateInput.value = rate || "";
            }

            // Set initial rate
            updateConversionRate();

            // Update rate when currency changes
            currencySelect.addEventListener('change', updateConversionRate);
        });
    </script>

    <script>
        function openCustomerModal() {
            event.preventDefault(); // Prevent form submission
            document.getElementById('customerModal').classList.remove('hidden');
        }

        function closeCustomerModal() {
            document.getElementById('customerModal').classList.add('hidden');
        }

        document.getElementById('customerForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('customers.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let customerDropdown = document.getElementById('customer_id');
                        let newOption = document.createElement("option");
                        newOption.value = data.customer.id;
                        newOption.textContent = data.customer.name;
                        newOption.selected = true;
                        customerDropdown.appendChild(newOption);

                        closeCustomerModal();
                    } else {
                        alert("Error adding customer!");
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const startDateInput = document.querySelector("input[name='start_date']");
            const endDateInput = document.querySelector("input[name='end_date']");
            const daysInput = document.querySelector("input[name='no_of_days']");
            const nightsInput = document.querySelector("input[name='no_of_nights']");

            // Get today's date in YYYY-MM-DD format
            const today = new Date().toISOString().split('T')[0];

            // Set minimum date for both inputs
            startDateInput.min = today;
            endDateInput.min = today;

            function calculateDaysAndNights() {
                let startDate = new Date(startDateInput.value);
                let endDate = new Date(endDateInput.value);

                if (!isNaN(startDate) && !isNaN(endDate) && endDate >= startDate) {
                    let timeDiff = endDate.getTime() - startDate.getTime();
                    let days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) + 1;
                    let nights = days - 1;

                    daysInput.value = days;
                    nightsInput.value = nights;
                } else {
                    daysInput.value = "";
                    nightsInput.value = "";
                }
            }

            // Update end date minimum when start date changes
            startDateInput.addEventListener("change", function() {
                endDateInput.min = this.value;
                calculateDaysAndNights();
            });

            endDateInput.addEventListener("change", calculateDaysAndNights);
        });
    </script>
</x-app-layout>