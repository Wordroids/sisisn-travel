<!-- filepath: d:\Saruna\Work\sisisn-travel\resources\views\pages\group_quotations\edit_hotel_voucher.blade.php -->
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
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Voucher Information
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Review and add additional information for the hotel voucher.
                </p>
            </div>

            <form action="#" method="POST">
                @csrf
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column - Hotel and Stay Information (non-editable) -->
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
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $hotel->address ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Check-in</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $accommodation->start_date->format('d M Y') }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Check-out</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $accommodation->end_date->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nights</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $accommodation->nights }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Meal Plan</label>
                                    <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                        {{ $mealPlan }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Room Information (non-editable) -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">Room Information</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Room Category</label>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded-md">
                                    {{ $roomCategory }}
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Room Breakdown</label>
                                <div class="mt-1 grid grid-cols-5 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Single</label>
                                        <input type="number" name="room_counts[single]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="{{ $roomCounts['single'] ?? 0 }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Double</label>
                                        <input type="number" name="room_counts[double]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="{{ $roomCounts['double'] ?? 0 }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Twin</label>
                                        <input type="number" name="room_counts[twin]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="{{ $roomCounts['twin'] ?? 0 }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Triple</label>
                                        <input type="number" name="room_counts[triple]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="{{ $roomCounts['triple'] ?? 0 }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Guide</label>
                                        <input type="number" name="room_counts[guide]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="{{ $roomCounts['guide'] ?? 0 }}">
                                    </div>
                                </div>
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
                            <textarea id="special_notes" name="special_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $specialNotes ?? '' }}</textarea>
                        </div>
                        
                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea id="remarks" name="remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $remarks ?? '' }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Example: HB SGL USD 85, HB DBL USD 90, HB TPL USD 130 (Reservation Code – ST2025)</p>
                        </div>
                        
                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700">Contact Person</label>
                            <input type="text" id="contact_person" name="contact_person" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $contactPerson ?? auth()->user()->name . ' - ' . (auth()->user()->phone ?? '') }}">
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
</x-app-layout>