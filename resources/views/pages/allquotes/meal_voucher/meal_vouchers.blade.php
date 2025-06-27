<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">
                            Meal Vouchers for {{ $mainRef }}
                        </h2>
                        <div class="flex space-x-4">
                            <a href="{{ route('meal_vouchers.create', $mainRef) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Meal Voucher
                            </a>
                            
                            <a href="{{ route('group_quotations.group_vouchers', ['main_ref' => $mainRef]) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Back to Voucher Selection
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($mealVouchers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voucher Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hotel</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meal Plan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Market</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tours & Dates</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($mealVouchers as $voucher)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $voucher->voucher_date->format('d M, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $voucher->hotel_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $voucher->meal_plan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $voucher->market ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                @php
                                                    $tourData = json_decode($voucher->selected_tours_data, true) ?? [];
                                                    $totalPacks = 0;
                                                    $totalTours = count($tourData);
                                                    $tourSummary = [];
                                                    
                                                    foreach ($tourData as $tourNo => $tour) {
                                                        $dates = [];
                                                        $tourPacks = 0;
                                                        
                                                        if (isset($tour['mealDates'])) {
                                                            foreach ($tour['mealDates'] as $mealDate) {
                                                                $packCount = intval($mealDate['noOfPacks'] ?? 0);
                                                                $dates[] = date('d M', strtotime($mealDate['date'])) . ' (' . $packCount . ' pax)';
                                                                $tourPacks += $packCount;
                                                                $totalPacks += $packCount;
                                                            }
                                                        }
                                                        
                                                        $tourSummary[] = [
                                                            'tourNo' => $tourNo,
                                                            'guestName' => $tour['guestName'] ?? 'N/A',
                                                            'dates' => $dates,
                                                            'packs' => $tourPacks
                                                        ];
                                                    }
                                                @endphp
                                                
                                                <div class="space-y-2">
                                                    @foreach($tourSummary as $tour)
                                                        <div class="border-l-4 border-blue-300 pl-2">
                                                            <div class="font-medium">{{ $tour['tourNo'] }} - {{ $tour['guestName'] }}</div>
                                                            <div class="text-xs text-gray-500">
                                                                @if(count($tour['dates']) > 0)
                                                                    {{ implode(', ', $tour['dates']) }}
                                                                @else
                                                                    No meal dates
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    @if($totalTours > 0)
                                                        <div class="mt-1 text-xs font-medium text-gray-700">
                                                            Total: {{ $totalTours }} tour(s), {{ $totalPacks }} pax
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-3">
                                                    <a href="{{ route('meal_vouchers.edit', ['main_ref' => $mainRef, 'id' => $voucher->id]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    
                                                    <form action="{{ route('meal_vouchers.destroy', ['main_ref' => $mainRef, 'id' => $voucher->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this voucher?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No meal vouchers yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new meal voucher.</p>
                            <div class="mt-6">
                                <a href="{{ route('meal_vouchers.create', $mainRef) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Create Meal Voucher
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>