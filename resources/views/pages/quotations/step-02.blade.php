<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Step 2: Pax Slab Details</h2>
        <p class="text-gray-700">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

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
                                    class="block w-full border-gray-300 rounded-md shadow-sm p-2 text-center" required>
                            </td>

                            <!-- Vehicle Type -->
                            <td class="px-4 py-2 text-center">
                                <select name="pax_slab[{{ $paxSlab->id }}][vehicle_type_id]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm vehicle-select p-2" required>
                                    <option value="">Select Vehicle</option>
                                    @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{ $vehicleType->id }}" data-rate="{{ $vehicleType->default_rate }}">
                                        {{ $vehicleType->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>

                            <!-- Vehicle Payout Rate -->
                            <td class="px-4 py-2 text-center">
                                <input type="number" name="pax_slab[{{ $paxSlab->id }}][vehicle_payout_rate]"
                                    class="block w-full border-gray-300 rounded-md shadow-sm payout-rate p-2 text-center" readonly required>
                            </td>
                        </tr>
                        @endforeach
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