<x-app-layout>
    <section class="py-3 sm:py-5">
        <div class="px-3"> {{-- Match outer div from quotations index --}}
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y"> {{-- Match inner div structure --}}
                    <div
                        class="flex flex-col py-3 space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 md:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">All Group Quotations:</span>
                                {{-- Assuming $groupQuotations is a paginator, use total() --}}
                                <span>{{ $groupQuotations->total() }}</span>
                            </h5>
                        </div>
                    </div>

                    <!-- Add New Group Quotation Button -->
                    <div
                        class="flex flex-col items-stretch justify-between py-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                        {{-- @can('make-group-quotations') --}} {{-- Assuming a similar permission or remove if not needed --}}
                        <a href="{{ route('select_template') }}"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            New Group Quotation
                        </a>
                        {{-- @endcan --}}
                    </div>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-4 rounded" role="alert"> {{-- Added margin for consistency --}}
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500"> {{-- Match table classes --}}
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50"> {{-- Match thead classes --}}
                            <tr>
                                <th scope="col" class="px-4 py-3">Quote Reference</th>
                                <th scope="col" class="px-4 py-3">Booking Reference</th>
                                <th scope="col" class="px-4 py-3">Market</th>
                                <th scope="col" class="px-4 py-3">Customer</th>
                                <th scope="col" class="px-4 py-3">Travel Period</th>
                                <th scope="col" class="px-4 py-3">Status</th> {{-- For Badge --}}
                                <th scope="col" class="px-4 py-3">Update Status</th> {{-- For Dropdown --}}
                                
                                <th scope="col" class="px-4 py-3 text-left"> {{-- Match actions column header style --}}
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($groupQuotations as $quotation)
                                <tr class="border-b hover:bg-gray-100"> {{-- Match tr classes --}}
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap"> {{-- Match td classes --}}
                                        {{ $quotation->quote_reference }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-500"> {{-- Adjusted for consistency, booking ref might have different style in target --}}
                                        {{ $quotation->booking_reference ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-500">
                                        {{ $quotation->market->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-500">
                                        {{ $quotation->customer->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-500">
                                        {{ $quotation->start_date ? $quotation->start_date->format('d M Y') : 'N/A' }}
                                        -
                                        {{ $quotation->end_date ? $quotation->end_date->format('d M Y') : 'N/A' }}
                                    </td>
                                    <!-- Status Badge -->
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <div
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-lg 
                                            {{ $quotation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($quotation->status === 'approved' ? 'bg-green-100 text-green-800' : ($quotation->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            <span
                                                class="w-2 h-2 mr-1 rounded-full 
                                                {{ $quotation->status === 'pending' ? 'bg-yellow-500' : ($quotation->status === 'approved' ? 'bg-green-500' : ($quotation->status === 'rejected' ? 'bg-red-500' : 'bg-gray-500')) }}">
                                            </span>
                                            {{ ucfirst($quotation->status) }}
                                        </div>
                                    </td>
                                    <!-- Status Dropdown -->
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <select class="status-dropdown py-1 text-sm border rounded-lg"
                                            data-id="{{ $quotation->id }}">
                                            
                                            <option value="pending"
                                                {{ $quotation->status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="approved"
                                                {{ $quotation->status == 'approved' ? 'selected' : '' }}>Approved
                                            </option>
                                            <option value="rejected"
                                                {{ $quotation->status == 'rejected' ? 'selected' : '' }}>Rejected
                                            </option>
                                        </select>
                                    </td>
                                    
                                    <td class="px-4 py-2 whitespace-nowrap text-left"> {{-- Match actions td style --}}
                                        <a href="{{ route('group_quotations.show', $quotation->id) }}"
                                            class="text-blue-600 hover:underline mr-2">View</a>
                                        <a href="{{ route('group_quotations.step_01', $quotation->id) }}"
                                            class="text-yellow-600 hover:underline mr-2">Edit</a>
                                        {{-- Add other actions if necessary --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" {{-- Adjusted colspan --}}
                                        class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p>No group quotations found</p>
                                            <a href="{{ route('select_template') }}"
                                                class="mt-2 flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                                                Create your first group quotation
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-200"> {{-- Match pagination wrapper --}}
                    {{ $groupQuotations->links() }}
                </div>
            </div>
        </div>
    </section>

    <!-- AJAX Script for Updating Status -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".status-dropdown").forEach((dropdown) => {
                dropdown.addEventListener("change", function() {
                    let quotationId = this.getAttribute("data-id");
                    let newStatus = this.value;
                    
                    // The original form submitted to `group_quotations.updateStatus`. We can use that.

                    fetch(`/group-quotations/update-status/${quotationId}`, { // Adjusted URL
                            method: "POST", // Ensure your route `group_quotations.updateStatus` accepts POST for AJAX
                                            // Or create a new route specifically for AJAX that returns JSON
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute("content")
                            },
                            body: JSON.stringify({
                                status: newStatus,
                                
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => { throw err; });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success || response.ok) { // Check for success property or just ok response
                                // alert("Status updated successfully!"); // Optional: for debugging
                                location.reload(); // Reload to see changes reflected everywhere
                            } else {
                                alert(data.message || "Failed to update status.");
                            }
                        })
                        .catch(error => {
                            console.error("Error updating status:", error);
                            let errorMsg = "Error updating status.";
                            if (error && error.message) {
                                errorMsg += " " + error.message;
                            } else if (typeof error === 'object' && error !== null) {
                                errorMsg += " " + JSON.stringify(error);
                            }
                            alert(errorMsg);
                        });
                });
            });
        });
    </script>
</x-app-layout>