<!-- filepath: d:\Saruna\Work\sisisn-travel\resources\views\pages\allquotes\tour_plan\tour_plan_create.blade.php -->
<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Create Tour Plan</h2>
                        <a href="" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Back to Tour Plans
                        </a>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Group Quotation Details</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
                            <p class="text-blue-700"><span class="font-bold">Booking Reference:</span> {{ $main_ref }}</p>
                        </div>
                    </div>

                    <!-- Group quotation list -->
                    <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Booking Reference</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Duration</th>
                                    <th scope="col" class="px-6 py-3">Start Date</th>
                                    <th scope="col" class="px-6 py-3">End Date</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Customer</th>
                                    <th scope="col" class="px-6 py-3">Currency</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groupQuotation as $quote)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $quote->booking_reference }}</td>
                                    <td class="px-6 py-4">{{ $quote->name }}</td>
                                    <td class="px-6 py-4">{{ $quote->duration }} days</td>
                                    <td class="px-6 py-4">{{ $quote->start_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4">{{ $quote->end_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($quote->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $quote->customer ? $quote->customer->name : 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $quote->currency }}</td>
                                    <td class="px-6 py-4">
                                        <button type="button" class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                onclick="selectQuotationForPlan('{{ $quote->id }}')">
                                            Select for Plan
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white border-b">
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No approved quotations found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 bg-white shadow-md rounded-lg p-6 hidden" id="planDetailsSection">
    <form id="tourPlanForm" action="" method="POST">
        @csrf
        <input type="hidden" id="selectedQuotationId" name="group_quotation_id">
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Create Tour Plan</h3>
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-md">
                <p class="text-yellow-700">Complete the form below to create a tour plan for the selected quotation</p>
            </div>
        </div>

        
        
        
        <!-- Pax Slab Details Section -->
        <div class="mb-6">
            <h4 class="text-md font-medium text-gray-700 mb-3">Guest Information</h4>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h5 class="font-medium text-gray-700">Guest List</h5>
                        <button type="button" 
                                class="px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                onclick="addGuestRow()">
                            Add Guest
                        </button>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Guest Name</th>
                                <th scope="col" class="px-4 py-3">Age</th>
                                <th scope="col" class="px-4 py-3">Gender</th>
                                <th scope="col" class="px-4 py-3">Passport/ID</th>
                                <th scope="col" class="px-4 py-3">Special Requirements</th>
                                <th scope="col" class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="guestTableBody">
                            <tr class="bg-white border-b">
                                <td class="px-4 py-2">
                                    <input type="text" 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                           name="guests[0][name]" 
                                           placeholder="Full name">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                           name="guests[0][age]" 
                                           placeholder="Age">
                                </td>
                                <td class="px-4 py-2">
                                    <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                            name="guests[0][gender]">
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                           name="guests[0][passport]" 
                                           placeholder="Passport/ID">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                           name="guests[0][requirements]" 
                                           placeholder="Special requirements">
                                </td>
                                <td class="px-4 py-2">
                                    <button type="button" 
                                            class="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                            onclick="removeGuestRow(this)">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>
            <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                      id="description" 
                      name="description" 
                      rows="5" 
                      placeholder="Enter tour plan description"></textarea>
        </div>
        
        <!-- Additional plan details fields can be added here -->
        
        <div class="flex gap-4 mt-6">
            <button type="submit" 
                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Create Tour Plan
            </button>
            <button type="button" 
                    class="px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                    onclick="cancelPlan()">
                Cancel
            </button>
        </div>
    </form>
</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectQuotationForPlan(quotationId) {
            // Set the selected quotation ID in the hidden input
            document.getElementById('selectedQuotationId').value = quotationId;
            
            // Show the plan details section with animation
            const planSection = document.getElementById('planDetailsSection');
            planSection.classList.remove('hidden');
            planSection.classList.add('animate-fade-in');
            
            // Scroll to the plan details section with smooth scrolling
            planSection.scrollIntoView({behavior: 'smooth'});
        }
        
        function cancelPlan() {
            // Add fade-out class for animation
            const planSection = document.getElementById('planDetailsSection');
            planSection.classList.add('animate-fade-out');
            
            // Hide after animation completes
            setTimeout(() => {
                planSection.classList.add('hidden');
                planSection.classList.remove('animate-fade-out');
                
                // Clear the selected quotation ID
                document.getElementById('selectedQuotationId').value = '';
            }, 300);
        }
    </script>

    <style>
        /* Add simple fade animations */
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        .animate-fade-out {
            animation: fadeOut 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
    </style>
</x-app-layout>