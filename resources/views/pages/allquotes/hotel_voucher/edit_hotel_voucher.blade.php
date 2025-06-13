<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                Edit Hotel Voucher - {{ $hotel->name }}
            </h2>
            <a href="{{ route('group_quotations.hotel_vouchers', $quotation->id) }}" 
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                Back to Hotels
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                
                    <h4 class="text-base font-semibold text-center mt-4">HOTEL RESERVATION VOUCHER AMENDMENT 1</h4>

            </div>

            <form action="{{ route('hotel_voucher.store_amendment', ['quotation' => $quotation->id, 'hotel' => $hotel->id]) }}" method="POST">
                @csrf
                <div class="px-4 py-5 sm:p-6">
                    <!-- Tour Information -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-3">Tour Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tour No</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $quotation->template->booking_reference }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tour Name</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $quotation->name }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Market</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $quotation->market ? $quotation->market->name : 'N/A' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Booking Name</label>
                                <input type="text" name="booking_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $quotation->name }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Voucher Date</label>
                                <input type="date" name="voucher_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column - Hotel and Stay Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">Hotel Information</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hotel Name</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $hotel->name }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="hotel_address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $hotel->location ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Arrival Date</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        @php
                                            // Get earliest arrival date from all related accommodations
                                            $earliestDate = $relatedAccommodations->min('start_date');
                                            $arrivalDate = $earliestDate ? $earliestDate : $accommodation->start_date;
                                            
                                            // Calculate total nights
                                            $latestDate = $relatedAccommodations->max('end_date');
                                            $departureDate = $latestDate ? $latestDate : $accommodation->end_date;
                                            $totalNights = $arrivalDate->diffInDays($departureDate);
                                        @endphp
                                        {{ $arrivalDate->format('d/m/Y') }}
                                        <input type="hidden" name="arrival_date" value="{{ $arrivalDate->format('Y-m-d') }}">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Departure Date</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $departureDate->format('d/m/Y') }}
                                        <input type="hidden" name="departure_date" value="{{ $departureDate->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Nights</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $totalNights }}
                                        <input type="hidden" name="total_nights" value="{{ $totalNights }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Room Category</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $roomCategory }}
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Meal Plan</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $mealPlan }}
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Room Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">Room Information</h4>
                            
                            <!-- Room counts -->
                            <div class="grid grid-cols-5 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Single</label>
                                    <input type="number" name="room_counts[single]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center" value="{{ $roomCounts['single'] ?? 0 }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Double</label>
                                    <input type="number" name="room_counts[double]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center" value="{{ $roomCounts['double'] ?? 0 }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Twin</label>
                                    <input type="number" name="room_counts[twin]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center" value="{{ $roomCounts['twin'] ?? 0 }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Triple</label>
                                    <input type="number" name="room_counts[triple]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center" value="{{ $roomCounts['triple'] ?? 0 }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Guide</label>
                                    <input type="number" name="room_counts[guide]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center" value="{{ $roomCounts['guide'] ?? 0 }}">
                                </div>
                            </div>
                            
                            <!-- Meal plan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Selected Meal Plan</label>
                                <select name="meal_plan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="BB" {{ $mealPlan == 'BB' ? 'selected' : '' }}>Bed & Breakfast (BB)</option>
                                    <option value="HB" {{ $mealPlan == 'HB' ? 'selected' : '' }}>Half Board (HB)</option>
                                    <option value="FB" {{ $mealPlan == 'FB' ? 'selected' : '' }}>Full Board (FB)</option>
                                    <option value="AI" {{ $mealPlan == 'AI' ? 'selected' : '' }}>All Inclusive (AI)</option>
                                    <option value="RO" {{ $mealPlan == 'RO' ? 'selected' : '' }}>Room Only (RO)</option>
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. of Adults</label>
                                    <input type="number" name="adults" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $adults }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. of Children</label>
                                    <input type="number" name="children" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $children ?? 0 }}">
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="mt-8 space-y-4">
                        <h4 class="text-md font-medium text-gray-700">Additional Information</h4>
                        
                        <div>
                            <label for="special_notes" class="block text-sm font-medium text-gray-700">Special Notes</label>
                            <textarea id="special_notes" name="special_notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $specialNotes ?? '-' }}</textarea>
                        </div>
                        
                        <div>
                            <label for="billing_instructions" class="block text-sm font-medium text-gray-700">Billing Instructions</label>
                            <textarea id="billing_instructions" name="billing_instructions" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $billingInstructions ?? 'Extras to be collected from client directly.' }}</textarea>
                        </div>
                        
                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea id="remarks" name="remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $remarks ?? 'HB SGL USD 85, HB DBL USD 90, HB TPL USD 130 (Reservation Code – ST2025)' }}</textarea>
                        </div>
                        
                        <div>
                            <label for="reservation_note" class="block text-sm font-medium text-gray-700">Reservation Note</label>
                            <textarea id="reservation_note" name="reservation_note" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $reservationNote ?? 'Please reserve and confirm the above arrangements. Client will arrive for the given meal against the day.
Please return duplicate duly singed as confirmation, and triplicate along with your bill.' }}</textarea>
                        </div>
                        
                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700">Contact Person</label>
                            <input type="text" id="contact_person" name="contact_person" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $contactPerson ?? 'Nethini Guruge - 0777343748' }}">
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Generate Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // You can add client-side validation or other functionality here
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                // Prevent double submission
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = 'Generating...';
            });
        });
    </script>
    @endpush
</x-app-layout>