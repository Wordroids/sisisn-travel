<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">

        <!-- Progress Bar  -->
        <div>
            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 test:text-gray-400 sm:text-base">
                <!-- Step 1: Reference Info -->
                <li
                    class="flex md:w-full items-center text-blue-600 test:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-500 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 test:after:border-gray-700">
                    <a href="{{ route('group_quotations.step_01', $groupQuotation->id) }}"
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

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-gray-700 mt-16 mb-8">Group Quotation Reference:
            <strong>{{ $groupQuotation->quote_reference }}</strong></p>

        <form method="POST" action="{{ route('group_quotations.store_step_02', $groupQuotation->id) }}">
            @csrf
            @method('PUT')

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
                                        value="{{ $groupQuotation->paxSlabs->where('pax_slab_id', $paxSlab->id)->first()->exact_pax ?? '' }}"
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
                                                data-rate="{{ $vehicleType->default_rate }}"
                                                {{ isset($groupQuotation->paxSlabs->where('pax_slab_id', $paxSlab->id)->first()->vehicle_type_id) &&
                                                $groupQuotation->paxSlabs->where('pax_slab_id', $paxSlab->id)->first()->vehicle_type_id == $vehicleType->id
                                                    ? 'selected'
                                                    : '' }}>
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
                                        value="{{ $groupQuotation->paxSlabs->where('pax_slab_id', $paxSlab->id)->first()->vehicle_payout_rate ?? '' }}"
                                        required>
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
                    {{-- Ensure $groupQuotation->members is loaded in your controller, e.g., $groupQuotation->load('members'); --}}
                </div>
                <button type="button" id="add-member-btn"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Add Member
                </button>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('group_quotations.step_01', $groupQuotation->id) }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Back
                </a>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Save & Next
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Set initial values for payout rates
            document.querySelectorAll('.vehicle-select').forEach(select => {
                if (select.value) {
                    let rate = select.options[select.selectedIndex].getAttribute('data-rate');
                    let payoutRateInput = select.closest('tr').querySelector('.payout-rate');

                    // Only set if there's no existing value
                    if (payoutRateInput && !payoutRateInput.value) {
                        payoutRateInput.value = rate;
                    }
                }
            });

            // Add event listeners for vehicle select changes
            document.querySelectorAll('.vehicle-select').forEach(select => {
                select.addEventListener('change', function() {
                    let rate = this.options[this.selectedIndex].getAttribute('data-rate');

                    // Find the correct payout rate input field within the same row
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
            let memberGroups = []; // Array to store group names

            // Helper to escape HTML special characters
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

            // Get group options for select dropdown
            function getGroupOptions(selectedGroup = '') {
                let options = '';
                memberGroups.forEach(group => {
                    const selected = group === selectedGroup ? 'selected' : '';
                    options +=
                        `<option value="${escapeHtml(group)}" ${selected}>${escapeHtml(group)}</option>`;
                });
                return options;
            }

            // Create a new group
            function createNewGroup(currentRowIndex) {
                const groupName = prompt('Enter a name for the new group:');

                if (groupName && groupName.trim() !== '') {
                    // Add to our groups array if not exists
                    if (!memberGroups.includes(groupName.trim())) {
                        memberGroups.push(groupName.trim());
                    }

                    // Update all group dropdowns
                    document.querySelectorAll('.member-group-select').forEach(select => {
                        const currentValue = select.value;
                        select.innerHTML = `<option value="">No Group</option>` + getGroupOptions(
                            currentValue);

                        // If this is the one that triggered the new group, select it
                        if (select.id === `member_group_${currentRowIndex}`) {
                            select.value = groupName.trim();
                        } else if (currentValue) {
                            select.value = currentValue;
                        }
                    });

                    // Apply simple color coding
                    applyGroupColors();
                }
            }

            // Simple function to apply colors to grouped members
            function applyGroupColors() {
                const groupColors = {}; // Simple cache for colors

                document.querySelectorAll('.member-entry').forEach(entry => {
                    const select = entry.querySelector('.member-group-select');
                    if (select && select.value) {
                        const group = select.value;

                        // Generate a color if we don't have one for this group
                        if (!groupColors[group]) {
                            // Use a simple hash function for consistent colors
                            let hash = 0;
                            for (let i = 0; i < group.length; i++) {
                                hash = group.charCodeAt(i) + ((hash << 5) - hash);
                            }
                            const hue = hash % 360;
                            groupColors[group] = `hsl(${hue}, 70%, 90%)`;
                        }

                        // Apply left border with group color
                        entry.style.borderLeft = `5px solid ${groupColors[group]}`;
                    } else {
                        // Reset border for no group
                        entry.style.borderLeft = '1px solid #d1d5db';
                    }
                });
            }

            function addMemberRow(memberData = null) {
                const currentRowIndex = memberIndex;
                const memberRow = document.createElement('div');
                memberRow.classList.add('member-entry', 'p-4', 'border', 'border-gray-300', 'rounded-lg',
                    'bg-gray-50', 'shadow-sm');
                memberRow.setAttribute('id', `member-row-${currentRowIndex}`);

                const memberIdInput = memberData && memberData.id ?
                    `<input type="hidden" name="members[${currentRowIndex}][id]" value="${escapeHtml(memberData.id)}">` :
                    '';

                // Header section with member name and remove button
                const headerSection = `
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium text-gray-700">Member #${currentRowIndex + 1}</h4>
                        <button type="button" class="remove-member-btn inline-flex items-center px-3 py-1.5 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Remove
                        </button>
                    </div>
                `;

                memberRow.innerHTML = `
                    ${memberIdInput}
                    ${headerSection}
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
                        <div>
                            <label for="member_group_${currentRowIndex}" class="block text-sm font-medium text-gray-700">Member Group</label>
                            <div class="flex space-x-2 items-center">
                                <select name="members[${currentRowIndex}][member_group]" id="member_group_${currentRowIndex}"
                                    class="member-group-select mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">No Group</option>
                                    ${getGroupOptions(memberData && memberData.member_group ? memberData.member_group : '')}
                                </select>
                                <button type="button" class="add-new-group-btn mt-1 px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    New
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                if (membersContainer) {
                    membersContainer.appendChild(memberRow);
                    memberRow.querySelector('.remove-member-btn').addEventListener('click', function() {
                        memberRow.remove();
                    });

                    memberRow.querySelector('.add-new-group-btn').addEventListener('click', function() {
                        createNewGroup(currentRowIndex);
                    });

                    // Add change event to update colors when group changes
                    memberRow.querySelector('.member-group-select').addEventListener('change', applyGroupColors);
                }
                memberIndex++;
            }

            // Extract existing groups and load members
            function loadExistingMembers() {
                const existingMembers = @json($groupQuotation->members ?? []);

                if (existingMembers && existingMembers.length > 0) {
                    // Extract groups first
                    existingMembers.forEach(member => {
                        if (member.member_group && !memberGroups.includes(member.member_group)) {
                            memberGroups.push(member.member_group);
                        }
                    });

                    // Then add member rows
                    existingMembers.forEach(member => {
                        addMemberRow(member);
                    });

                    // Apply colors to show groups
                    applyGroupColors();
                }
            }

            // Add member button click handler
            if (addMemberBtn) {
                addMemberBtn.addEventListener('click', function() {
                    addMemberRow();
                });
            }

            // Load existing members
            if (membersContainer) {
                loadExistingMembers();
            }
        });
    </script>
</x-app-layout>
