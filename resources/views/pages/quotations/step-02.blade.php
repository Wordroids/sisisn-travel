<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Step 2: Pax Slab Details</h2>
        <p class="text-gray-700">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step2.store', $quotation->id) }}">
            @csrf

            <!-- Pax Slab Table -->
            <div class="overflow-x-auto bg-gray-100 p-4 rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-gray-700 bg-gray-200">
                        <tr>
                            @for ($i = 1; $i <= $selectedPaxSlab->max_pax; $i++)
                                <th class="px-4 py-2 text-center font-semibold">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }} Pax</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exact No. of Pax Row -->
                        <tr>
                            @for ($i = 1; $i <= $selectedPaxSlab->max_pax; $i++)
                                <td class="px-4 py-2 text-center">
                                    <input type="number" name="pax_slab[{{ $i }}][exact_pax]" 
                                           class="block w-full border-gray-300 rounded-md shadow-sm p-2 text-center" required>
                                </td>
                            @endfor
                        </tr>

                        <!-- Vehicle Type Row -->
                        <tr>
                            @for ($i = 1; $i <= $selectedPaxSlab->max_pax; $i++)
                                <td class="px-4 py-2 text-center">
                                    <select name="pax_slab[{{ $i }}][vehicle_type]" 
                                            class="block w-full border-gray-300 rounded-md shadow-sm vehicle-select p-2" required>
                                        <option value="">Select Vehicle</option>
                                        @foreach ($vehicleTypes as $vehicle => $rate)
                                            <option value="{{ $vehicle }}" data-rate="{{ $rate }}">{{ $vehicle }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            @endfor
                        </tr>

                        <!-- Vehicle Payout Rate Row -->
                        <tr>
                            @for ($i = 1; $i <= $selectedPaxSlab->max_pax; $i++)
                                <td class="px-4 py-2 text-center">
                                    <input type="number" name="pax_slab[{{ $i }}][vehicle_payout_rate]" 
                                           class="block w-full border-gray-300 rounded-md shadow-sm payout-rate p-2 text-center" required>
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('quotations.step_one') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back</a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Save & Next
                </button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.vehicle-select').forEach(select => {
            select.addEventListener('change', function() {
                let rate = this.options[this.selectedIndex].getAttribute('data-rate');
                this.closest('td').querySelector('.payout-rate').value = rate;
            });
        });
    </script>
</x-app-layout>
