<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-700">
                            <div class="font-medium">Please correct the following errors:</div>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">
                            Hotel Voucher for {{ $accommodation->hotel->name }}
                        </h2>
                        <a href="{{ route('quotations.hotel_vouchers', $quotation->id) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Back to Hotel Vouchers
                        </a>
                    </div>

                    <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Create a hotel voucher for {{ $quotation->booking_reference }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('quotations.store_hotel_voucher', ['quotation' => $quotation->id, 'accommodation' => $accommodation->id]) }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Basic Voucher Info -->
                            <div>
                                <label for="voucher_date" class="block text-sm font-medium text-gray-700">Voucher Date</label>
                                <input type="date" name="voucher_date" id="voucher_date"
                                    value="{{ old('voucher_date', $voucher->voucher_date ? $voucher->voucher_date->format('Y-m-d') : date('Y-m-d')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="booking_name" class="block text-sm font-medium text-gray-700">Booking Name</label>
                                <input type="text" name="booking_name" id="booking_name"
                                    value="{{ old('booking_name', $voucher->booking_name ?? ($quotation->customer ? $quotation->customer->name : '')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="arrival_date" class="block text-sm font-medium text-gray-700">Arrival Date</label>
                                <input type="date" name="arrival_date" id="arrival_date"
                                    value="{{ old('arrival_date', $voucher->arrival_date ? $voucher->arrival_date->format('Y-m-d') : ($accommodation->start_date ? (is_string($accommodation->start_date) ? $accommodation->start_date : $accommodation->start_date->format('Y-m-d')) : '')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="departure_date" class="block text-sm font-medium text-gray-700">Departure Date</label>
                                <input type="date" name="departure_date" id="departure_date"
                                    value="{{ old('departure_date', $voucher->departure_date ? $voucher->departure_date->format('Y-m-d') : ($accommodation->end_date ? (is_string($accommodation->end_date) ? $accommodation->end_date : $accommodation->end_date->format('Y-m-d')) : '')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="total_nights" class="block text-sm font-medium text-gray-700">Total Nights</label>
                                <input type="number" name="total_nights" id="total_nights" min="1"
                                    value="{{ old('total_nights', $voucher->total_nights ?? $accommodation->nights) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="hotel_address" class="block text-sm font-medium text-gray-700">Hotel Address</label>
                                <textarea name="hotel_address" id="hotel_address" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('hotel_address', $voucher->hotel_address ?? ($accommodation->hotel ? $accommodation->hotel->location : '')) }}</textarea>
                            </div>

                            <div>
                                <label for="room_category" class="block text-sm font-medium text-gray-700">Room Category</label>
                                <input type="text" name="room_category" id="room_category"
                                    value="{{ old('room_category', $voucher->room_category ?? ($accommodation->roomCategory ? $accommodation->roomCategory->name : '')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="meal_plan" class="block text-sm font-medium text-gray-700">Meal Plan</label>
                                <select name="meal_plan" id="meal_plan" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="BB" {{ (old('meal_plan', $voucher->meal_plan) == 'BB') ? 'selected' : '' }}>Bed & Breakfast (BB)</option>
                                    <option value="HB" {{ (old('meal_plan', $voucher->meal_plan) == 'HB') ? 'selected' : '' }}>Half Board (HB)</option>
                                    <option value="FB" {{ (old('meal_plan', $voucher->meal_plan) == 'FB') ? 'selected' : '' }}>Full Board (FB)</option>
                                    <option value="AI" {{ (old('meal_plan', $voucher->meal_plan) == 'AI') ? 'selected' : '' }}>All Inclusive (AI)</option>
                                    <option value="RO" {{ (old('meal_plan', $voucher->meal_plan) == 'RO') ? 'selected' : '' }}>Room Only (RO)</option>
                                </select>
                            </div>

                            <div>
                                <label for="adults" class="block text-sm font-medium text-gray-700">Adults</label>
                                <input type="number" name="adults" id="adults" min="1"
                                    value="{{ old('adults', $voucher->adults ?? ($quotation->adults ?? 1)) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="children" class="block text-sm font-medium text-gray-700">Children</label>
                                <input type="number" name="children" id="children" min="0"
                                    value="{{ old('children', $voucher->children ?? ($quotation->children ?? 0)) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="contact_person" class="block text-sm font-medium text-gray-700">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    value="{{ old('contact_person', $voucher->contact_person ?? '') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Room Details -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-800 mb-3">Room Details</h3>
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                @php
                                    $roomCounts = old('room_counts', json_decode($voucher->room_counts ?? '{}', true) ?? [
                                        'single' => 0,
                                        'double' => 0,
                                        'twin' => 0,
                                        'triple' => 0,
                                        'extra_bed' => 0
                                    ]);
                                @endphp

                                <div>
                                    <label for="room_counts_single" class="block text-sm font-medium text-gray-700">Single</label>
                                    <input type="number" name="room_counts[single]" id="room_counts_single" min="0"
                                        value="{{ $roomCounts['single'] ?? 0 }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="room_counts_double" class="block text-sm font-medium text-gray-700">Double</label>
                                    <input type="number" name="room_counts[double]" id="room_counts_double" min="0"
                                        value="{{ $roomCounts['double'] ?? 0 }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="room_counts_twin" class="block text-sm font-medium text-gray-700">Twin</label>
                                    <input type="number" name="room_counts[twin]" id="room_counts_twin" min="0"
                                        value="{{ $roomCounts['twin'] ?? 0 }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="room_counts_triple" class="block text-sm font-medium text-gray-700">Triple</label>
                                    <input type="number" name="room_counts[triple]" id="room_counts_triple" min="0"
                                        value="{{ $roomCounts['triple'] ?? 0 }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="room_counts_extra_bed" class="block text-sm font-medium text-gray-700">Extra Bed</label>
                                    <input type="number" name="room_counts[extra_bed]" id="room_counts_extra_bed" min="0"
                                        value="{{ $roomCounts['extra_bed'] ?? 0 }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Notes and Instructions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                            <div>
                                <label for="special_notes" class="block text-sm font-medium text-gray-700">Special Notes</label>
                                <textarea name="special_notes" id="special_notes" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('special_notes', $voucher->special_notes ?? '') }}</textarea>
                            </div>

                            <div>
                                <label for="billing_instructions" class="block text-sm font-medium text-gray-700">Billing Instructions</label>
                                <textarea name="billing_instructions" id="billing_instructions" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('billing_instructions', $voucher->billing_instructions ?? 'Extras to be collected from client directly.') }}</textarea>
                            </div>

                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('remarks', $voucher->remarks ?? '') }}</textarea>
                            </div>

                            <div>
                                <label for="reservation_note" class="block text-sm font-medium text-gray-700">Reservation Note</label>
                                <textarea name="reservation_note" id="reservation_note" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('reservation_note', $voucher->reservation_note ?? 'Please reserve and confirm the above arrangements. Client will arrive for the given meal against the day. Please return duplicate duly singed as confirmation, and triplicate along with your bill.') }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            @if(isset($voucher->id))
                            <a href="{{ route('quotations.download_hotel_voucher', $voucher->id) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 border border-green-600 rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download PDF
                            </a>
                            @endif
                            
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Save Hotel Voucher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-calculate nights when dates change
            const arrivalDateInput = document.getElementById('arrival_date');
            const departureDateInput = document.getElementById('departure_date');
            const totalNightsInput = document.getElementById('total_nights');

            function updateTotalNights() {
                const arrivalDate = new Date(arrivalDateInput.value);
                const departureDate = new Date(departureDateInput.value);

                if (arrivalDate && departureDate && !isNaN(arrivalDate) && !isNaN(departureDate)) {
                    const timeDiff = departureDate.getTime() - arrivalDate.getTime();
                    const nightsDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    
                    if (nightsDiff >= 0) {
                        totalNightsInput.value = nightsDiff;
                    }
                }
            }

            arrivalDateInput.addEventListener('change', updateTotalNights);
            departureDateInput.addEventListener('change', updateTotalNights);
        });
    </script>
</x-app-layout>