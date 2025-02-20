<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <!-- Progress Bar (Same as step-02.blade.php) -->
        <div>
            <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_one', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Reference <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </a>
                </li>
                <li class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_two', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </a>
                </li>
                <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_three', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">3</span>
                        Accommodation
                    </a>
                </li>
                
                <!-- Step 4 -->
                <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_four', $quotation->id) }}" class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">4</span>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan</span>
                    </a>
                </li>

                <!-- Step 5 -->
                <li class="flex items-center">
                    <a href="{{ route('quotations.edit_step_five', $quotation->id) }}" class="flex items-center">
                        <span class="me-2">5</span>
                        Sites <span class="hidden sm:inline-flex sm:ms-2">Details</span>
                    </a>
                </li>
            </ol>
        </div>

        <p class="text-gray-700 mt-16 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.update_step_two', $quotation->id) }}">
            @csrf
            @method('PUT')

            <!-- Pax Slab Table -->
            <div class="overflow-x-auto bg-gray-100 p-4 rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">Pax Slab</th>
                            <th class="px-4 py-2 text-center">Exact No. of Pax</th>
                            <th class="px-4 py-2 text-center">Vehicle Type</th>
                            <th class="px-4 py-2 text-center">Vehicle Payout Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paxSlabs as $paxSlab)
                            @php
                                $quotationPaxSlab = $quotation->paxSlabs->where('pax_slab_id', $paxSlab->id)->first();
                            @endphp
                            <tr>
                                <th class="px-4 py-2 text-center font-semibold">{{ $paxSlab->name }}</th>
                                <!-- Exact No. of Pax -->
                                <td class="px-4 py-2 text-center">
                                    <input type="number" 
                                        name="pax_slab[{{ $paxSlab->id }}][exact_pax]"
                                        value="{{ $quotationPaxSlab->exact_pax ?? '' }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm p-2 text-center" 
                                        required>
                                </td>

                                <!-- Vehicle Type -->
                                <td class="px-4 py-2 text-center">
                                    <select name="pax_slab[{{ $paxSlab->id }}][vehicle_type_id]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm vehicle-select p-2" 
                                        required>
                                        <option value="">Select Vehicle</option>
                                        @foreach ($vehicleTypes as $vehicleType)
                                            <option value="{{ $vehicleType->id }}" 
                                                data-rate="{{ $vehicleType->default_rate }}"
                                                {{ ($quotationPaxSlab && $quotationPaxSlab->vehicle_type_id == $vehicleType->id) ? 'selected' : '' }}>
                                                {{ $vehicleType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Vehicle Payout Rate -->
                                <td class="px-4 py-2 text-center">
                                    <input type="number" 
                                        name="pax_slab[{{ $paxSlab->id }}][vehicle_payout_rate]"
                                        value="{{ $quotationPaxSlab->vehicle_payout_rate ?? '' }}"
                                        class="block w-full border-gray-300 rounded-md shadow-sm payout-rate p-2 text-center" 
                                        readonly required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ $navigation['back'] }}" class="bg-gray-500 text-white py-2 px-4 rounded-md">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md">
                    Update & Next
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.vehicle-select').forEach(select => {
                select.addEventListener('change', function() {
                    let rate = this.options[this.selectedIndex].getAttribute('data-rate');
                    let payoutRateInput = this.closest('tr').querySelector('.payout-rate');
                    if (payoutRateInput) {
                        payoutRateInput.value = rate;
                    }
                });
            });
        });
    </script>
</x-app-layout>