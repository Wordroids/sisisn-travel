<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">

        <!-- Progress Bar  -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <!-- Step 1: Reference Info -->
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('quotations.edit_step_one', $quotation->id) }}"
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-blue-200 test:after:text-blue-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Reference <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </a>
                </li>
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Pax <span class="hidden sm:inline-flex sm:ms-2">Slab</span>
                    </span>
                </li>

                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">3</span>
                        Accommodation <span class="hidden sm:inline-flex sm:ms-2"> </span> <span
                            class="hidden sm:inline-flex sm:ms-2"> </span>
                    </span>
                </li>
                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 test:after:text-gray-500">
                        <span class="me-2">4</span>
                        Travel <span class="hidden sm:inline-flex sm:ms-2">Plan </span> <span
                            class="hidden sm:inline-flex sm:ms-2"> </span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">5</span>
                    Site <span class="hidden sm:inline-flex ">|Extra</span>
                </li>
            </ol>
        </div>


        <p class="text-gray-700 mt-16 mb-8">Quotation Reference: <strong>{{ $quotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('quotations.step2.store', $quotation->id) }}">
            @csrf

            <!-- Pax Slab Table -->
            <div class="overflow-x-auto bg-gray-100 p-4 rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">Pax Slab</th>
                            <th class="px-4 py-2 text-center">Exact No. of Pax</th>
                            <th class="px-4 py-2 text-center">Vehicle Type</th>
                            <th class="px-4 py-2 text-center">Vehicle Payout Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paxSlabs as $paxSlab)
                            <tr>
                                <th class="px-4 py-2 text-center font-semibold">{{ $paxSlab->name }}</th>
                                <!-- Exact No. of Pax -->
                                <td class="px-4 py-2 text-center">
                                    <input type="number" name="pax_slab[{{ $paxSlab->id }}][exact_pax]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm p-2 text-center"
                                        required>
                                </td>

                                <!-- Vehicle Type -->
                                <td class="px-4 py-2 text-center">
                                    <select name="pax_slab[{{ $paxSlab->id }}][vehicle_type_id]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm vehicle-select p-2"
                                        required>
                                        <option value="">Select Vehicle</option>
                                        @foreach ($vehicleTypes as $vehicleType)
                                            <option value="{{ $vehicleType->id }}"
                                                data-rate="{{ $vehicleType->default_rate }}">
                                                {{ $vehicleType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_type_id')
                                        <p class="text-red-500 text-xs">{{ $message }}</p>
                                    @enderror
                                </td>

                                <!-- Vehicle Payout Rate -->
                                <td class="px-4 py-2 text-center">
                                    <input type="number" name="pax_slab[{{ $paxSlab->id }}][vehicle_payout_rate]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm payout-rate p-2 text-center"
                                        readonly required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Members Details Section -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Members Details</h3>
                <div id="members-container" class="space-y-6">
                    {{-- Member rows will be populated here by JavaScript --}}
                </div>
                <button type="button" id="add-member-btn" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Member
                </button>
            </div>

            <div class="flex justify-between mt-6">
                @if (isset($navigation['back']))
                    <a href="{{ $navigation['back'] }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Back
                    </a>
                @else
                    <div></div> {{-- Empty div to maintain spacing --}}
                @endif

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    {{ $navigation['submit_text'] ?? 'Start Quote' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize payout rates for existing vehicle selects
            document.querySelectorAll('.vehicle-select').forEach(select => {
                if (select.value) { // If a vehicle is already selected
                    let rate = select.options[select.selectedIndex].getAttribute('data-rate');
                    let payoutRateInput = select.closest('tr').querySelector('.payout-rate');
                    if (payoutRateInput && !payoutRateInput.value) { // Only set if not already filled
                        payoutRateInput.value = rate;
                    }
                }
                // Add change listener
                select.addEventListener('change', function() {
                    let rate = this.options[this.selectedIndex].getAttribute('data-rate');
                    let payoutRateInput = this.closest('tr').querySelector('.payout-rate');
                    if (payoutRateInput) {
                        payoutRateInput.value = rate;
                    }
                });
            });

            // --- Members Details Script ---
            const membersContainer = document.getElementById('members-container');
            const addMemberBtn = document.getElementById('add-member-btn');
            let memberIndex = 0; 

            function escapeHtml(unsafe) {
                if (unsafe === null || typeof unsafe === 'undefined') {
                    return '';
                }
                return unsafe
                    .toString()
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function addMemberRow(memberData = null) {
                const currentRowIndex = memberIndex;
                const memberRow = document.createElement('div');
                memberRow.classList.add('member-entry', 'p-4', 'border', 'border-gray-300', 'rounded-lg', 'bg-gray-50', 'shadow-sm');
                memberRow.setAttribute('id', `member-row-${currentRowIndex}`);

                const memberIdInput = memberData && memberData.id ?
                    `<input type="hidden" name="members[${currentRowIndex}][id]" value="${escapeHtml(memberData.id)}">` : '';

                memberRow.innerHTML = `
                    ${memberIdInput}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                        <div>
                            <label for="member_name_${currentRowIndex}" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="members[${currentRowIndex}][name]" id="member_name_${currentRowIndex}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="${memberData && memberData.name ? escapeHtml(memberData.name) : ''}" required>
                        </div>
                        <div>
                            <label for="member_email_${currentRowIndex}" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="members[${currentRowIndex}][email]" id="member_email_${currentRowIndex}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="${memberData && memberData.email ? escapeHtml(memberData.email) : ''}">
                        </div>
                        <div>
                            <label for="member_phone_${currentRowIndex}" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="members[${currentRowIndex}][phone]" id="member_phone_${currentRowIndex}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="${memberData && memberData.phone ? escapeHtml(memberData.phone) : ''}">
                        </div>
                        <div>
                            <label for="member_whatsapp_${currentRowIndex}" class="block text-sm font-medium text-gray-700">WhatsApp</label>
                            <input type="text" name="members[${currentRowIndex}][whatsapp]" id="member_whatsapp_${currentRowIndex}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="${memberData && memberData.whatsapp ? escapeHtml(memberData.whatsapp) : ''}">
                        </div>
                        <div>
                            <label for="member_country_${currentRowIndex}" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" name="members[${currentRowIndex}][country]" id="member_country_${currentRowIndex}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="${memberData && memberData.country ? escapeHtml(memberData.country) : ''}">
                        </div>
                        <div class="flex items-end justify-start sm:justify-end lg:col-span-1">
                            <button type="button" class="remove-member-btn inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Remove
                            </button>
                        </div>
                    </div>
                `;
                
                if (membersContainer) {
                    membersContainer.appendChild(memberRow);
                    memberRow.querySelector('.remove-member-btn').addEventListener('click', function() {
                        memberRow.remove();
                    });
                }
                memberIndex++;
            }

            function loadExistingMembers() {
                const existingMembers = @json($quotation->members ?? []); 
                if (existingMembers && existingMembers.length > 0) {
                    existingMembers.forEach(member => {
                        addMemberRow(member);
                    });
                }
            }

            if (addMemberBtn) {
                addMemberBtn.addEventListener('click', function() {
                    addMemberRow();
                });
            }
            
            if (membersContainer) {
                 //loadExistingMembers();
            }
            // --- End of Members Details Script ---
        });
    </script>
</x-app-layout>
