<!-- filepath: d:\Saruna\Work\sisisn-travel\resources\views\pages\quotations_templates\show.blade.php -->
<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Quotation Template Details</h2>
            <div class="flex space-x-2">
                <a href="{{ route('quotations_templates.edit', $template) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    Edit Template
                </a>
                <a href="{{ route('quotations_templates.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
                    Back
                </a>
            </div>
        </div>

        <!-- Template Basic Info Card -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Template Information</h3>
                <span class="px-3 py-1 rounded-full text-sm {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $template->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-700">Template Name:</span>
                        <p class="mt-1">{{ $template->template_name }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-700">Description:</span>
                        <p class="mt-1">{{ $template->description ?: 'No description provided' }}</p>
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-700">Created By:</span>
                        <p class="mt-1">{{ $template->createdBy ? $template->createdBy->name : 'System' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-700">Created Date:</span>
                        <p class="mt-1">{{ $template->created_at->format('F d, Y') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-700">Last Updated:</span>
                        <p class="mt-1">{{ $template->updated_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accommodations Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Accommodations</h3>
            
            @if(count($template->accommodations) > 0)
                <div class="space-y-4">
                    @foreach($template->accommodations as $index => $accommodation)
                        <div class="bg-white rounded-lg p-4 border">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-gray-800">{{ $hotels->firstWhere('id', $accommodation['hotel_id'])->name ?? 'Unknown Hotel' }}</h4>
                                <span class="text-sm text-gray-500">Hotel #{{ $index + 1 }}</span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="mb-3">
                                        <span class="text-sm font-medium text-gray-700">Meal Plan:</span>
                                        <p class="text-gray-800">{{ $mealPlans->firstWhere('id', $accommodation['meal_plan_id'])->name ?? 'Unknown Plan' }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <span class="text-sm font-medium text-gray-700">Room Category:</span>
                                        <p class="text-gray-800">{{ $roomCategories->firstWhere('id', $accommodation['room_category_id'])->name ?? 'Unknown Category' }}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="mb-3">
                                        <span class="text-sm font-medium text-gray-700">Room Rates (USD):</span>
                                        <ul class="mt-1 list-disc list-inside text-gray-800">
                                            @if(isset($accommodation['room_types']['single']['per_night_cost']))
                                                <li>Single: ${{ number_format($accommodation['room_types']['single']['per_night_cost'], 2) }} per night</li>
                                            @endif
                                            
                                            @if(isset($accommodation['room_types']['double']['per_night_cost']))
                                                <li>Double: ${{ number_format($accommodation['room_types']['double']['per_night_cost'], 2) }} per night</li>
                                            @endif
                                            
                                            @if(isset($accommodation['room_types']['triple']['per_night_cost']))
                                                <li>Triple: ${{ number_format($accommodation['room_types']['triple']['per_night_cost'], 2) }} per night</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No accommodations defined for this template.</p>
            @endif
        </div>

        <!-- Travel Plans Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Travel Plans</h3>
            
            @if(count($template->travel_plans) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left border-b">#</th>
                                <th class="py-3 px-4 text-left border-b">Route</th>
                                <th class="py-3 px-4 text-left border-b">Vehicle Type</th>
                                <th class="py-3 px-4 text-left border-b">Mileage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($template->travel_plans as $index => $travelPlan)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 border-b">{{ $routes->firstWhere('id', $travelPlan['route_id'])->name ?? 'Unknown Route' }}</td>
                                    <td class="py-3 px-4 border-b">{{ $vehicleTypes->firstWhere('id', $travelPlan['vehicle_type_id'])->name ?? 'Unknown Vehicle' }}</td>
                                    <td class="py-3 px-4 border-b">{{ $travelPlan['mileage'] }} km</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic">No travel plans defined for this template.</p>
            @endif
        </div>

        <!-- Site Seeings Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Site Seeings</h3>
            
            @if(count($template->site_seeings) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left border-b">Site Name</th>
                                <th class="py-3 px-4 text-left border-b">Unit Price (USD)</th>
                                <th class="py-3 px-4 text-left border-b">Quantity</th>
                                <th class="py-3 px-4 text-left border-b">Price Per Adult (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($template->site_seeings as $siteSeing)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ $siteSeing['name'] }}</td>
                                    <td class="py-3 px-4 border-b">${{ number_format($siteSeing['unit_price'], 2) }}</td>
                                    <td class="py-3 px-4 border-b">{{ $siteSeing['quantity'] }}</td>
                                    <td class="py-3 px-4 border-b">${{ number_format($siteSeing['price_per_adult'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic">No site seeings defined for this template.</p>
            @endif
        </div>

        <!-- Site Extras Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Site Extras</h3>
            
            @if(count($template->site_extras) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left border-b">Extra Name</th>
                                <th class="py-3 px-4 text-left border-b">Unit Price (USD)</th>
                                <th class="py-3 px-4 text-left border-b">Quantity</th>
                                <th class="py-3 px-4 text-left border-b">Price Per Adult (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($template->site_extras as $siteExtra)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ $siteExtra['name'] }}</td>
                                    <td class="py-3 px-4 border-b">${{ number_format($siteExtra['unit_price'], 2) }}</td>
                                    <td class="py-3 px-4 border-b">{{ $siteExtra['quantity'] }}</td>
                                    <td class="py-3 px-4 border-b">${{ number_format($siteExtra['price_per_adult'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic">No site extras defined for this template.</p>
            @endif
        </div>

        <!-- Quotation Extras Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quotation Extras</h3>
            
            @if(count($template->extras) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left border-b">Description</th>
                                <th class="py-3 px-4 text-left border-b">Unit Price (USD)</th>
                                <th class="py-3 px-4 text-left border-b">Quantity Per Pax</th>
                                <th class="py-3 px-4 text-left border-b">Total Price (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($template->extras as $extra)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ $extra['description'] }}</td>
                                    <td class="py-3 px-4 border-b">${{ number_format($extra['unit_price'], 2) }}</td>
                                    <td class="py-3 px-4 border-b">{{ $extra['quantity_per_pax'] }}</td>
                                    <td class="py-3 px-4 border-b">${{ number_format($extra['total_price'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic">No extras defined for this template.</p>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mt-8">
            <div class="flex space-x-4">
                <form method="POST" action="{{ route('quotations_templates.toggle_status', $template) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 rounded-md {{ $template->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                        {{ $template->is_active ? 'Deactivate Template' : 'Activate Template' }}
                    </button>
                </form>
                
                <form method="POST" action="{{ route('quotations_templates.destroy', $template) }}" onsubmit="return confirm('Are you sure you want to delete this template? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
                        Delete Template
                    </button>
                </form>
            </div>
            
            <div>
                <a href="" class="bg-purple-500 text-white py-2 px-4 rounded-md hover:bg-purple-600 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                    </svg>
                    Create Quotation from Template
                </a>
            </div>
        </div>
    </div>
</x-app-layout>