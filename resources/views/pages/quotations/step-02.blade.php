<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">

        <!-- Progress Bar  -->
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
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </span>
                </li>

                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">3</span>
                        Accommodation <span class="hidden sm:inline-flex sm:ms-2"> </span> <span
                            class="hidden sm:inline-flex sm:ms-2"> </span>
                    </span>
                </li>
                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">4</span>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan </span> <span
                            class="hidden sm:inline-flex sm:ms-2"> </span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">5</span>
                    Site <span class="hidden sm:inline-flex ">|Extra</span>
                </li>
            </ol>
        </div>


        <p class="text-gray-700 mt-16 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step2.store', $quotation->id) }}">
            @csrf

            <!-- Pax Slab Table -->
            <div class="overflow-x-auto bg-gray-100 p-4 rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">

                    <tbody>
                        @foreach ($paxSlabs as $paxSlab)
                            <tr>
                                <th class="px-4 py-2 text-center font-semibold">{{ $paxSlab->name }}</th>
                                <!-- Exact No. of Pax -->
                                <td class="px-4 py-2 text-center">
                                    <input type="number" name="pax_slab[{{ $paxSlab->id }}][exact_pax]"
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
                                                data-rate="{{ $vehicleType->default_rate }}">
                                                {{ $vehicleType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Vehicle Payout Rate -->
                                <td class="px-4 py-2 text-center">
                                    <input type="number" name="pax_slab[{{ $paxSlab->id }}][vehicle_payout_rate]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm payout-rate p-2 text-center"
                                        readonly required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    {{ $navigation['submit_text'] ?? 'Start Quote' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.vehicle-select').forEach(select => {
                select.addEventListener('change', function() {
                    let rate = this.options[this.selectedIndex].getAttribute('data-rate');

                    // Find the correct payout rate input field within the same row
                    let payoutRateInput = this.closest('tr').querySelector('.payout-rate');
                    if (payoutRateInput) {
                        payoutRateInput.value = rate;
                    }
                });
            });
        });
    </script>
</x-app-layout>
