<!-- filepath: d:\Saruna\Work\sisisn-travel\resources\views\pages\allquotes\hotel_voucher\hotel_vouchers.blade.php -->
<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                Hotel Vouchers for {{ $groupQuotation->name }}
            </h2>
            <a href="{{ route('group_quotations.show', $groupQuotation->id) }}" 
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                Back to Quotation
            </a>
        </div>
        
        <!-- Group Accommodations Section -->
        @if($groupQuotation->accommodations->count() > 0)
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Main Group Hotels</h3>
                <div class="bg-white shadow overflow-hidden rounded-lg">
                    <div class="divide-y divide-gray-200">
                        @foreach($groupQuotation->accommodations as $accommodation)
                            <div class="px-4 py-5 sm:p-6 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-800">
                                            {{ $accommodation->hotel->name }}
                                        </h4>
                                        <div class="mt-2 text-sm text-gray-600 space-y-1">
                                            <p>Check-in: {{ $accommodation->start_date->format('d M Y') }}</p>
                                            <p>Check-out: {{ $accommodation->end_date->format('d M Y') }}</p>
                                            <p>Nights: {{ $accommodation->nights }}</p>
                                            <p>Meal Plan: {{ $accommodation->mealPlan->name }}</p>
                                            <p>Room Category: {{ $accommodation->roomCategory->name }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('group_quotations.edit_hotel_voucher', ['quotation' => $groupQuotation->id, 'accommodation' => $accommodation->id]) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                                            <path fill-rule="evenodd" d="M8 11a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5z" clip-rule="evenodd"></path>
                                        </svg>
                                        Generate Voucher
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Sub-Quotations Accommodations Section -->
        @if(isset($subQuotations) && $subQuotations->isNotEmpty())
            <div class="mt-10">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Individual Tour Hotels</h3>
                
                @foreach($subQuotations as $subQuotation)
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-indigo-600 mb-2">
                            {{ $subQuotation->name ?? 'Quotation #' . $subQuotation->id }} 
                            <span class="text-gray-500 text-sm">(Reference: {{ $subQuotation->booking_reference }})</span>
                        </h4>
                        
                        @if($subQuotation->accommodations->count() > 0)
                            <div class="bg-white shadow overflow-hidden rounded-lg">
                                <div class="divide-y divide-gray-200">
                                    @foreach($subQuotation->accommodations as $accommodation)
                                        <div class="px-4 py-5 sm:p-6 hover:bg-gray-50">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h5 class="text-lg font-semibold text-gray-800">
                                                        {{ $accommodation->hotel->name }}
                                                    </h5>
                                                    <div class="mt-2 text-sm text-gray-600 space-y-1">
                                                        <p>Check-in: {{ $accommodation->start_date->format('d M Y') }}</p>
                                                        <p>Check-out: {{ $accommodation->end_date->format('d M Y') }}</p>
                                                        <p>Nights: {{ $accommodation->nights }}</p>
                                                        <p>Meal Plan: {{ $accommodation->mealPlan->name }}</p>
                                                        <p>Room Type: {{ $accommodation->room_type }}</p>
                                                    </div>
                                                </div>
                                                <a href="{{ route('quotations.edit_hotel_voucher', ['quotation' => $subQuotation->id, 'accommodation' => $accommodation->id]) }}"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                                                        <path fill-rule="evenodd" d="M8 11a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Generate Voucher
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-md text-gray-500 text-sm">
                                No hotels found for this quotation.
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
        
        @if($groupQuotation->accommodations->count() == 0 && (!isset($subQuotations) || $subQuotations->isEmpty() || $subQuotations->every(function($q) { return $q->accommodations->count() == 0; })))
            <div class="bg-white shadow overflow-hidden rounded-lg p-6 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No accommodations found</h3>
                <p class="mt-1 text-gray-500">This group quotation does not have any hotel accommodations.</p>
            </div>
        @endif
    </div>
</x-app-layout>