<x-app-layout>
    <section class="py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div
                        class="flex flex-col py-3 space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 md:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">All Quotation Templates</span>
                                <span>{{ $templates->total() }}</span>
                            </h5>
                        </div>
                        {{-- Potential place for filters or search --}}
                    </div>

                    <div
                        class="flex flex-col items-stretch justify-between py-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                        <a href="{{ route('quotations_templates.create') }}"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Create New Template
                        </a>
                        {{-- Potential place for bulk actions --}}
                    </div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-4 rounded"
                        role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-4 rounded" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Template Name</th>
                                <th scope="col" class="px-4 py-3">Quote Reference</th>
                                <th scope="col" class="px-4 py-3">Booking Reference</th>
                                <th scope="col" class="px-4 py-3">Description</th>
                                <th scope="col" class="px-4 py-3">Created By</th>
                                <th scope="col" class="px-4 py-3">Created Date</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($templates as $template)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $template->template_name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $template->quote_reference }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $template->booking_reference }}</td>
                                    <td class="px-4 py-2">{{ Str::limit($template->description, 50) }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $template->createdBy ? $template->createdBy->name : 'System' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $template->created_at->format('d M, Y') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <div
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <span
                                                class="w-2 h-2 mr-1.5 rounded-full {{ $template->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            {{ $template->is_active ? 'Active' : 'Inactive' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-left">
                                        <a href="{{ route('quotations_templates.show', $template) }}"
                                            class="text-blue-600 hover:underline mr-2" title="View">View</a>
                                        <a href="{{ route('quotations_templates.edit', $template) }}"
                                            class="text-yellow-600 hover:underline mr-2" title="Edit">Edit</a>
                                        <form method="POST"
                                            action="{{ route('quotations_templates.toggle_status', $template) }}"
                                            class="inline-block mr-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="{{ $template->is_active ? 'text-gray-600 hover:text-gray-900' : 'text-green-600 hover:text-green-900' }} hover:underline"
                                                title="{{ $template->is_active ? 'Deactivate' : 'Activate' }}">
                                                @if ($template->is_active)
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                        </path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('quotations_templates.destroy', $template) }}"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this template?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 hover:underline"
                                                title="Delete">
                                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400 mb-3"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-lg font-medium text-gray-700">No templates found</p>
                                            <p class="text-sm text-gray-500 mb-4">Get started by creating a new quotation
                                                template.</p>
                                            <a href="{{ route('quotations_templates.create') }}"
                                                class="mt-2 flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                                </svg>
                                                Create New Template
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-200">
                    {{ $templates->links() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>