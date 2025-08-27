<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                Hotel Vouchers for {{ $quotation->booking_reference }}
            </h2>
            <a href="{{ route('quotations.generate_voucher', $quotation->booking_reference) }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Back
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Generate hotel vouchers for tour: {{ $quotation->booking_reference }}
                    </p>
                </div>
            </div>
        </div>

        @if (isset($hotelGroups) && count($hotelGroups) > 0)
            <div class="space-y-8">
                @foreach ($hotelGroups as $hotelId => $hotelGroup)
                    <div class="bg-white shadow overflow-hidden rounded-lg">
                        <div class="px-4 py-5 sm:px-6 flex justify-between items-center bg-gray-50">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $hotelGroup['hotel']->name ?? 'Unknown Hotel' }}
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    {{ $hotelGroup['hotel']->location ?? 'No location available' }}
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('quotations.edit_hotel_voucher', [
                                    'quotation' => $quotation->id,
                                    'accommodation' => $hotelGroup['accommodations'][0]->id,
                                ]) }}"
                                    class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Create/Edit Voucher
                                </a>
                            </div>
                        </div>

                        <div class="border-t border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Check In
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Check Out
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nights
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Meal Plan
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Room Category
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($hotelGroup['accommodations'] as $accommodation)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if (is_string($accommodation->start_date))
                                                    {{ $accommodation->start_date }}
                                                @else
                                                    {{ $accommodation->start_date ? $accommodation->start_date->format('d M Y') : 'N/A' }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if (is_string($accommodation->end_date))
                                                    {{ $accommodation->end_date }}
                                                @else
                                                    {{ $accommodation->end_date ? $accommodation->end_date->format('d M Y') : 'N/A' }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @php
                                                    // Convert dates to Carbon if they're not already
                                                    $startDate = is_string($accommodation->start_date)
                                                        ? \Carbon\Carbon::parse($accommodation->start_date)
                                                        : $accommodation->start_date;
                                                    $endDate = is_string($accommodation->end_date)
                                                        ? \Carbon\Carbon::parse($accommodation->end_date)
                                                        : $accommodation->end_date;

                                                    // Calculate nights by subtracting end date from start date
                                                    if ($startDate && $endDate) {
                                                        // Use abs() to ensure the result is always positive
                                                        echo abs($endDate->diffInDays($startDate));
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                @endphp
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $accommodation->mealPlan ? $accommodation->mealPlan->name : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $accommodation->roomCategory ? $accommodation->roomCategory->name : 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white shadow overflow-hidden rounded-lg p-6 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No accommodations found</h3>
                <p class="mt-1 text-gray-500">There are no hotel accommodations in this quotation.</p>
            </div>
        @endif
    </div>
</x-app-layout>
