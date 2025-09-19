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
            <strong>{{ $groupQuotation->quote_reference }}</strong>
        </p>

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
                                        value="{{ $groupQuotation->paxSlabs->where('pax_slab_id', $paxSlab->id)->first()->exact_pax ?? '' }}">
                                </td>

                                <!-- Vehicle Type -->
                                <td class="px-4 py-2 text-center">
                                    <select name="pax_slab[{{ $paxSlab->id }}][vehicle_type_id]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm vehicle-select p-2">
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
                                    <input type="text" name="pax_slab[{{ $paxSlab->id }}][vehicle_payout_rate]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm payout-rate p-2 text-center"
                                        value="{{ $groupQuotation->paxSlabs->where('pax_slab_id', $paxSlab->id)->first()->vehicle_payout_rate ?? '' }}">
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
        // Replace the existing member grouping script with this enhanced version
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

            // --- Enhanced Members Details Script ---
            const membersContainer = document.getElementById('members-container');
            const addMemberBtn = document.getElementById('add-member-btn');
            let memberIndex = 0;
            let memberGroups = []; // Array to store group names
            let groupColors = {}; // Map group names to colors

            // Add sorting controls
            const sortingControls = document.createElement('div');
            sortingControls.className = 'flex justify-between items-center mb-4 p-2 bg-gray-100 rounded';
            sortingControls.innerHTML = `
        <div class="font-semibold text-gray-700">Member Organization</div>
        <div class="flex space-x-2">
            <button type="button" id="create-group-btn" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Create New Group
            </button>
            
        </div>
    `;
            membersContainer.parentNode.insertBefore(sortingControls, membersContainer);

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

            // Generate distinct color for a group
            function generateGroupColor(groupName) {
                if (!groupColors[groupName]) {
                    // Use a hash function to generate consistent colors for the same group name
                    let hash = 0;
                    for (let i = 0; i < groupName.length; i++) {
                        hash = groupName.charCodeAt(i) + ((hash << 5) - hash);
                    }
                    const h = hash % 360;
                    groupColors[groupName] = `hsl(${h}, 70%, 80%)`;
                }
                return groupColors[groupName];
            }

            // Get group options for select dropdown
            function getGroupOptions(selectedGroup = '') {
                let options = '';
                memberGroups.forEach(group => {
                    const selected = group === selectedGroup ? 'selected' : '';
                    const color = generateGroupColor(group);
                    options +=
                        `<option value="${escapeHtml(group)}" ${selected} data-color="${color}">${escapeHtml(group)}</option>`;
                });
                return options;
            }

            // Create a new group
            function createNewGroup() {
                const groupName = prompt('Enter a name for the new group:');

                if (groupName && groupName.trim() !== '') {
                    // Add to our groups array if not exists
                    if (!memberGroups.includes(groupName.trim())) {
                        memberGroups.push(groupName.trim());
                        generateGroupColor(groupName.trim());

                        // Create a new group container
                        createOrUpdateGroupContainer(groupName.trim());

                        // Update all group dropdowns
                        updateAllGroupDropdowns();
                    }
                }
            }

            // Update all group dropdowns
            function updateAllGroupDropdowns() {
                document.querySelectorAll('.member-group-select').forEach(select => {
                    const currentValue = select.value;
                    select.innerHTML = `<option value="">No Group</option>` + getGroupOptions(currentValue);

                    // Restore selected value
                    if (currentValue) {
                        select.value = currentValue;
                    }
                });
            }

            // Create or update a group container
            function createOrUpdateGroupContainer(groupName) {
                let groupContainer = document.getElementById(`group-container-${groupName.replace(/\s+/g, '-')}`);

                if (!groupContainer) {
                    const color = generateGroupColor(groupName);

                    // Create new group container
                    groupContainer = document.createElement('div');
                    groupContainer.className = 'group-container mb-6';
                    groupContainer.id = `group-container-${groupName.replace(/\s+/g, '-')}`;
                    groupContainer.innerHTML = `
                <div class="group-header flex items-center justify-between p-3 rounded cursor-pointer mb-2" 
                     style="background-color: ${color}; border-left: 6px solid ${adjustColor(color, -30)}">
                    <div class="flex items-center">
                        <span class="toggle-indicator mr-2">▼</span>
                        <h3 class="font-bold text-gray-800">${escapeHtml(groupName)}</h3>
                        <span class="member-count ml-2 px-2 py-0.5 bg-white rounded-full text-xs font-medium">0 members</span>
                    </div>
                    <div class="group-actions">
                        <button type="button" class="rename-group-btn px-2 py-1 bg-white text-gray-700 rounded mr-2 text-sm">
                            Rename
                        </button>
                        <button type="button" class="delete-group-btn px-2 py-1 bg-white text-red-600 rounded text-sm">
                            Delete Group
                        </button>
                    </div>
                </div>
                <div class="group-members pl-4 space-y-2"></div>
            `;

                    membersContainer.appendChild(groupContainer);

                    // Add event listeners
                    const header = groupContainer.querySelector('.group-header');
                    const members = groupContainer.querySelector('.group-members');
                    const toggleIndicator = header.querySelector('.toggle-indicator');

                    header.addEventListener('click', function(e) {
                        // Don't toggle if clicked on buttons
                        if (e.target.closest('.group-actions')) return;

                        members.classList.toggle('hidden');
                        toggleIndicator.textContent = members.classList.contains('hidden') ? '►' : '▼';
                    });

                    groupContainer.querySelector('.rename-group-btn').addEventListener('click', function() {
                        const newName = prompt('Enter new name for the group:', groupName);
                        if (newName && newName.trim() !== '' && newName !== groupName) {
                            renameGroup(groupName, newName.trim());
                        }
                    });

                    groupContainer.querySelector('.delete-group-btn').addEventListener('click', function() {
                        if (confirm(
                                `Are you sure you want to delete the group "${groupName}"? Members will be moved to "No Group".`
                                )) {
                            deleteGroup(groupName);
                        }
                    });

                    // Setup drag and drop for this container
                    setupDragDropForGroup(groupContainer);
                }

                return groupContainer;
            }

            // Adjust color brightness (positive value to lighten, negative to darken)
            function adjustColor(color, amount) {
                // For HSL colors
                if (color.startsWith('hsl')) {
                    const matches = color.match(/hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)/);
                    if (matches) {
                        const h = parseInt(matches[1]);
                        const s = parseInt(matches[2]);
                        const l = Math.min(100, Math.max(0, parseInt(matches[3]) + amount));
                        return `hsl(${h}, ${s}%, ${l}%)`;
                    }
                }
                return color;
            }

            // Set up drag and drop functionality
            function setupDragDropForGroup(groupContainer) {
                const groupMembers = groupContainer.querySelector('.group-members');

                // Allow dropping
                groupMembers.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    this.classList.add('bg-blue-50', 'border', 'border-dashed', 'border-blue-300');
                });

                groupMembers.addEventListener('dragleave', function() {
                    this.classList.remove('bg-blue-50', 'border', 'border-dashed', 'border-blue-300');
                });

                groupMembers.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('bg-blue-50', 'border', 'border-dashed', 'border-blue-300');

                    const memberId = e.dataTransfer.getData('text/plain');
                    const memberElement = document.getElementById(memberId);
                    if (memberElement) {
                        // Move the member to this group
                        this.appendChild(memberElement);

                        // Update the member's group select
                        const groupName = groupContainer.querySelector('.group-header h3').textContent;
                        const select = memberElement.querySelector('.member-group-select');
                        select.value = groupName;

                        // Update member styling
                        updateMemberStyling(memberElement, groupName);

                        // Update member counts
                        updateAllMemberCounts();
                    }
                });
            }

            // Rename a group
            function renameGroup(oldName, newName) {
                // Update memberGroups array
                const index = memberGroups.indexOf(oldName);
                if (index > -1) {
                    memberGroups[index] = newName;
                }

                // Transfer color to new name
                groupColors[newName] = groupColors[oldName];

                // Update group container
                const groupContainer = document.getElementById(`group-container-${oldName.replace(/\s+/g, '-')}`);
                if (groupContainer) {
                    groupContainer.id = `group-container-${newName.replace(/\s+/g, '-')}`;
                    groupContainer.querySelector('.group-header h3').textContent = newName;
                }

                // Update all members in this group
                document.querySelectorAll(`.member-group-select option[value="${oldName}"]`).forEach(option => {
                    option.value = newName;
                    option.textContent = newName;
                });

                document.querySelectorAll(`.member-group-select`).forEach(select => {
                    if (select.value === oldName) {
                        select.value = newName;
                    }
                });

                // Update all dropdowns
                updateAllGroupDropdowns();
            }

            // Delete a group
            function deleteGroup(groupName) {
                // Remove from memberGroups array
                const index = memberGroups.indexOf(groupName);
                if (index > -1) {
                    memberGroups.splice(index, 1);
                }

                // Move all members to "No Group"
                const groupContainer = document.getElementById(`group-container-${groupName.replace(/\s+/g, '-')}`);
                if (groupContainer) {
                    const members = Array.from(groupContainer.querySelectorAll('.member-entry'));

                    members.forEach(member => {
                        // Change group select to "No Group"
                        const select = member.querySelector('.member-group-select');
                        select.value = '';

                        // Reset styling
                        member.style.borderLeft = '1px solid #d1d5db';
                        member.style.backgroundColor = '#f9fafb';

                        // Move to ungrouped container
                        getOrCreateUngroupedContainer().appendChild(member);
                    });

                    // Remove the group container
                    groupContainer.remove();
                    delete groupColors[groupName];
                }

                // Update all dropdowns
                updateAllGroupDropdowns();

                // Update member counts
                updateAllMemberCounts();
            }

            // Get or create ungrouped container
            function getOrCreateUngroupedContainer() {
                let container = document.getElementById('ungrouped-container');

                if (!container) {
                    container = document.createElement('div');
                    container.id = 'ungrouped-container';
                    container.className = 'ungrouped-container mb-6';
                    container.innerHTML = `
                <div class="group-header flex items-center justify-between p-3 bg-gray-200 rounded cursor-pointer mb-2">
                    <div class="flex items-center">
                        <span class="toggle-indicator mr-2">▼</span>
                        <h3 class="font-bold text-gray-800">Ungrouped Members</h3>
                        <span class="member-count ml-2 px-2 py-0.5 bg-white rounded-full text-xs font-medium">0 members</span>
                    </div>
                </div>
                <div class="group-members pl-4 space-y-2"></div>
            `;

                    membersContainer.appendChild(container);

                    // Add event listeners
                    const header = container.querySelector('.group-header');
                    const members = container.querySelector('.group-members');
                    const toggleIndicator = header.querySelector('.toggle-indicator');

                    header.addEventListener('click', function(e) {
                        members.classList.toggle('hidden');
                        toggleIndicator.textContent = members.classList.contains('hidden') ? '►' : '▼';
                    });

                    // Setup drag and drop
                    setupDragDropForGroup(container);
                }

                return container.querySelector('.group-members');
            }

            // Update styling for a member based on its group
            function updateMemberStyling(memberElement, groupName) {
                if (groupName) {
                    const color = generateGroupColor(groupName);
                    memberElement.style.borderLeft = `5px solid ${color}`;
                    memberElement.style.backgroundColor = `${color}20`;

                    // Update or add group indicator
                    let indicator = memberElement.querySelector('.group-indicator');
                    if (!indicator) {
                        indicator = document.createElement('div');
                        indicator.className = 'group-indicator ml-2 px-2 py-1 text-sm rounded-full text-gray-700';
                        const headerSection = memberElement.querySelector('.flex.justify-between');
                        headerSection.insertBefore(indicator, headerSection.querySelector('button'));
                    }

                    indicator.style.backgroundColor = color;
                    indicator.textContent = `Group: ${groupName}`;
                } else {
                    memberElement.style.borderLeft = '1px solid #d1d5db';
                    memberElement.style.backgroundColor = '#f9fafb';

                    // Remove group indicator if exists
                    const indicator = memberElement.querySelector('.group-indicator');
                    if (indicator) {
                        indicator.remove();
                    }
                }
            }

            // Update member counts for all groups
            function updateAllMemberCounts() {
                // Count group members
                document.querySelectorAll('.group-container').forEach(container => {
                    const count = container.querySelectorAll('.member-entry').length;
                    container.querySelector('.member-count').textContent =
                        `${count} member${count !== 1 ? 's' : ''}`;
                });

                // Count ungrouped members
                const ungroupedContainer = document.getElementById('ungrouped-container');
                if (ungroupedContainer) {
                    const count = ungroupedContainer.querySelectorAll('.member-entry').length;
                    ungroupedContainer.querySelector('.member-count').textContent =
                        `${count} member${count !== 1 ? 's' : ''}`;
                }
            }

            // Add a new member row
            function addMemberRow(memberData = null) {
                const currentRowIndex = memberIndex;
                const memberRow = document.createElement('div');
                memberRow.classList.add('member-entry', 'p-4', 'border', 'border-gray-300', 'rounded-lg',
                    'bg-gray-50', 'shadow-sm', 'mb-2');
                memberRow.setAttribute('id', `member-row-${currentRowIndex}`);
                memberRow.draggable = true; // Make draggable

                const memberIdInput = memberData && memberData.id ?
                    `<input type="hidden" name="members[${currentRowIndex}][id]" value="${escapeHtml(memberData.id)}">` :
                    '';

                // Header section with member name and remove button
                const headerSection = `
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center">
                    <input type="checkbox" class="member-checkbox mr-2 h-4 w-4 text-blue-600 rounded">
                    <h4 class="text-lg font-medium text-gray-700">Member #${currentRowIndex + 1}</h4>
                    <div class="drag-handle ml-2 cursor-move text-gray-400" title="Drag to move">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>
                    </div>
                </div>
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
                    </div>
                </div>
            </div>
        `;

                // Add drag-and-drop functionality
                memberRow.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', memberRow.id);
                    this.classList.add('opacity-50');
                });

                memberRow.addEventListener('dragend', function() {
                    this.classList.remove('opacity-50');
                });

                // Add to appropriate container
                if (memberData && memberData.member_group) {
                    // Get or create the group container
                    const groupContainer = createOrUpdateGroupContainer(memberData.member_group);
                    groupContainer.querySelector('.group-members').appendChild(memberRow);
                    updateMemberStyling(memberRow, memberData.member_group);
                } else {
                    // Add to ungrouped container
                    getOrCreateUngroupedContainer().appendChild(memberRow);
                }

                // Add event listeners
                memberRow.querySelector('.remove-member-btn').addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove this member?')) {
                        memberRow.remove();
                        updateAllMemberCounts();
                    }
                });

                memberRow.querySelector('.member-group-select').addEventListener('change', function() {
                    const newGroup = this.value;

                    // Move member to appropriate container
                    if (newGroup) {
                        const groupContainer = createOrUpdateGroupContainer(newGroup);
                        groupContainer.querySelector('.group-members').appendChild(memberRow);
                        updateMemberStyling(memberRow, newGroup);
                    } else {
                        getOrCreateUngroupedContainer().appendChild(memberRow);
                        updateMemberStyling(memberRow, '');
                    }

                    updateAllMemberCounts();
                });

                memberIndex++;
                updateAllMemberCounts();

                return memberRow;
            }

            // Load existing members
            function loadExistingMembers() {
                const existingMembers = @json($groupQuotation->members ?? []);

                if (existingMembers && existingMembers.length > 0) {
                    // Extract groups first
                    existingMembers.forEach(member => {
                        if (member.member_group && !memberGroups.includes(member.member_group)) {
                            memberGroups.push(member.member_group);
                            generateGroupColor(member.member_group);
                        }
                    });

                    // Create all group containers first
                    memberGroups.forEach(group => {
                        createOrUpdateGroupContainer(group);
                    });

                    // Then add all members
                    existingMembers.forEach(member => {
                        addMemberRow(member);
                    });
                }
            }

            // Setup bulk actions
            function setupBulkActions() {
                const bulkActionSelect = document.getElementById('bulk-action-select');
                const bulkActionBtn = document.getElementById('bulk-action-btn');

                bulkActionBtn.addEventListener('click', function() {
                    const action = bulkActionSelect.value;

                    switch (action) {
                        case 'select-all':
                            document.querySelectorAll('.member-checkbox').forEach(checkbox => {
                                checkbox.checked = true;
                            });
                            break;

                        case 'deselect-all':
                            document.querySelectorAll('.member-checkbox').forEach(checkbox => {
                                checkbox.checked = false;
                            });
                            break;

                        case 'delete-selected':
                            const selectedMembers = document.querySelectorAll('.member-checkbox:checked');
                            if (selectedMembers.length === 0) {
                                alert('Please select members to delete.');
                                return;
                            }

                            if (confirm(
                                    `Are you sure you want to delete ${selectedMembers.length} member(s)?`
                                    )) {
                                selectedMembers.forEach(checkbox => {
                                    checkbox.closest('.member-entry').remove();
                                });
                                updateAllMemberCounts();
                            }
                            break;

                        case 'move-to-group':
                            const selectedForMove = document.querySelectorAll('.member-checkbox:checked');
                            if (selectedForMove.length === 0) {
                                alert('Please select members to move.');
                                return;
                            }

                            // Create dropdown for group selection
                            const groupOptions = ['<option value="">No Group</option>'];
                            memberGroups.forEach(group => {
                                groupOptions.push(
                                    `<option value="${escapeHtml(group)}">${escapeHtml(group)}</option>`
                                    );
                            });

                            const groupSelect = document.createElement('div');
                            groupSelect.className =
                                'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50';
                            groupSelect.innerHTML = `
                        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Move Members to Group</h3>
                            <select id="move-to-group-select" class="w-full p-2 border rounded mb-4">
                                ${groupOptions.join('')}
                            </select>
                            <div class="flex justify-end space-x-2">
                                <button id="cancel-move" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                <button id="confirm-move" class="px-4 py-2 bg-blue-500 text-white rounded">Move</button>
                            </div>
                        </div>
                    `;

                            document.body.appendChild(groupSelect);

                            document.getElementById('cancel-move').addEventListener('click', () => {
                                groupSelect.remove();
                            });

                            document.getElementById('confirm-move').addEventListener('click', () => {
                                const targetGroup = document.getElementById('move-to-group-select')
                                    .value;

                                selectedForMove.forEach(checkbox => {
                                    const memberRow = checkbox.closest('.member-entry');
                                    const groupSelect = memberRow.querySelector(
                                        '.member-group-select');
                                    groupSelect.value = targetGroup;

                                    // Trigger change event
                                    const event = new Event('change');
                                    groupSelect.dispatchEvent(event);
                                });

                                groupSelect.remove();
                            });
                            break;

                        default:
                            if (action) {
                                alert('Please select an action to perform.');
                            }
                    }

                    // Reset select
                    bulkActionSelect.value = '';
                });
            }

            // Setup event handlers
            function setupEventHandlers() {
                // Add member button
                addMemberBtn.addEventListener('click', function() {
                    addMemberRow();
                });

                // Create group button
                document.getElementById('create-group-btn').addEventListener('click', createNewGroup);

                // Setup bulk actions
                setupBulkActions();

                // Add dynamic bulk action for moving to group
                const bulkActionSelect = document.getElementById('bulk-action-select');
                const moveToGroupOption = document.createElement('option');
                moveToGroupOption.value = 'move-to-group';
                moveToGroupOption.textContent = 'Move Selected to Group';
                bulkActionSelect.appendChild(moveToGroupOption);
            }

            // Initialize 
            loadExistingMembers();
            setupEventHandlers();

            // Add CSS for better styling
            const style = document.createElement('style');
            style.textContent = `
        .member-entry {
            transition: all 0.3s ease;
        }
        
        .group-indicator {
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
        }
        
        .group-members {
            transition: max-height 0.3s ease;
        }
        
        .drag-handle:hover {
            color: #4B5563;
        }
        
        .member-checkbox:checked + h4 {
            text-decoration: underline;
        }
    `;
            document.head.appendChild(style);
        });
    </script>
</x-app-layout>
