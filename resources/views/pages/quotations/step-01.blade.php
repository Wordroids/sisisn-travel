<x-app-layout>

    <div class="max-w-7xl mx-auto mt-10">

        <!-- Progress Bar  -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Reference <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </span>
                </li>
                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">2</span>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab </span> <span
                            class="hidden sm:inline-flex sm:ms-2"> Details</span>
                    </span>
                </li>

                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">2</span>
                        Accommodation <span class="hidden sm:inline-flex sm:ms-2"> </span> <span
                            class="hidden sm:inline-flex sm:ms-2"> </span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">3</span>
                    Travel <span class="hidden sm:inline-flex sm:ms-2"> Plan </span>
                </li>
            </ol>
        </div>

        <div class="pt-16">
            <form action="{{ route('quotations.store_step_one') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="grid gap-6 grid-cols-4">
                    <div class="mb-4">
                        <label for="quote_reference"
                            class="block mb-2 text-sm font-medium text-gray-900 test:text-white">Quote Reference</label>
                        <input disabled type="text" value="{{ $quoteReference }}" name="" id=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                        <input hidden type="text" value="{{ $quoteReference }}" name="quote_reference"
                            id="quote_reference"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                    </div>

                    <div class="mb-4">
                        <label for="booking_reference"
                            class="block mb-2 text-sm font-medium text-gray-900 test:text-white">Booking
                            Reference</label>
                        <input disabled type="text" value="{{ $bookingReference }}" name="" id=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                        <input hidden type="text" value="{{ $bookingReference }}" name="booking_reference"
                            id="booking_reference"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                    </div>
                </div>

                <div class="grid gap-6 grid-cols-4">
                    <!-- Market Drop Down -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Market</label>
                        <select name="market_id" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Market</option>
                            @foreach ($markets as $market)
                                <option value="{{ $market->id }}">{{ $market->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Customer Drop Down -->
                    <div class="mb-4 grid grid-cols-4">
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Customer</label>
                            <select id="customer_id" name="customer_id"
                                class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="text-center items-center justify-center flex mt-5">
                            <button class="bg-blue-700 text-white p-2 text-sm" onclick="openCustomerModal()">+
                                Add</button>
                        </div>
                    </div>

                    <!-- Date Range  -->
                    <div class="mb-4 col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Date Range</label>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="date" name="start_date"
                                class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <input type="date" name="end_date"
                                class="block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                    </div>
                </div>


                <div class="grid gap-6 grid-cols-4">

                    <div class="mb-4">
                        <label for="no_of_days" class="block mb-2 text-sm font-medium text-gray-900 test:text-white">N.O
                            Of days</label>
                        <input type="text" name="no_of_days" id="no_of_days"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                    </div>

                    <div class="mb-4">
                        <label for="no_of_nights"
                            class="block mb-2 text-sm font-medium text-gray-900 test:text-white">N.O Of Nights</label>
                        <input type="text" name="no_of_nights" id="no_of_nights"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Currency</label>
                        <select name="currency_id" id="currency_id"
                            class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" data-rate="{{ $currency->conversion_rate }}"
                                    {{ $currency->code == 'USD' ? 'selected' : '' }}>
                                    {{ $currency->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <div class="mb-4">
                            <label for="conversion_rate"
                                class="block mb-2 text-sm font-medium text-gray-900">Conversion Rate</label>
                            <input type="text" name="conversion_rate" id="conversion_rate"
                                class="block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ $currencies->where('code', 'USD')->first()->conversion_rate ?? '' }}"
                                readonly>
                        </div>
                        <div class="w-1/2">
                            <label for="markup_per_pax"
                                class="block mb-2 text-sm font-medium text-gray-900 test:text-white">Markup per
                                Pax</label>
                            <input type="text" name="markup_per_pax" id="markup_per_pax"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 test:bg-gray-700 test:border-gray-600 test:placeholder-gray-400 test:text-white test:focus:ring-primary-500 test:focus:border-primary-500">
                        </div>
                    </div>


                </div>

                <div class="grid gap-6 grid-cols-4">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Pax Slab</label>
                        <select name="pax_slab_id" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Pax Slab</option>
                            @foreach ($paxSlabs as $paxSlab)
                                <option value="{{ $paxSlab->id }}">{{ $paxSlab->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    @if(isset($navigation['back']))
                        <a href="{{ $navigation['back'] }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Back
                        </a>
                    @else
                        <div></div> {{-- Empty div to maintain spacing --}}
                    @endif
                
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        {{ $navigation['submit_text'] ?? 'Start Quote' }}
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
                    <input type="text" name="phone" id="customer_phone"
                        class="block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Whatsapp</label>
                    <input type="text" name="whatsapp" id="customer_whatsapp"
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
            const currencySelect = document.querySelector("#currency_id");
            const conversionRateInput = document.querySelector("#conversion_rate");

            function updateConversionRate() {
                let selectedOption = currencySelect.options[currencySelect.selectedIndex];
                let rate = selectedOption.getAttribute("data-rate");
                conversionRateInput.value = rate || "";
            }

            // Auto-set conversion rate on page load
            updateConversionRate();

            // Update conversion rate when selecting a currency
            currencySelect.addEventListener("change", updateConversionRate);
        });
    </script>

    <script>
        function openCustomerModal() {
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
                        "X-Requested-With": "XMLHttpRequest" // ✅ Important!
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data);
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
