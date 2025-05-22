<x-app-layout>
    <section class="py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div
                        class="flex flex-col py-3 space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 md:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">Manage Pax Slabs</span>
                                {{-- If you have a count, you can add it here like: <span>{{ $paxSlabs->count() }}</span> --}}
                            </h5>
                        </div>
                        {{-- Potential place for filters or search --}}
                    </div>

                    <div
                        class="flex flex-col items-stretch justify-between py-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                        <a href="{{ route('pax_slabs.create') }}"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add Pax Slab
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
                                <th scope="col" class="px-4 py-3">Name</th>
                                <th scope="col" class="px-4 py-3">No Of Pax For Quoting</th>
                                <th scope="col" class="px-4 py-3">Max Pax</th>
                               
                                <th scope="col" class="px-4 py-3 text-left">Actions</th> {{-- Text-left for actions header --}}
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @forelse($paxSlabs as $paxSlab)
                                <tr class="border-b hover:bg-gray-100" data-id="{{ $paxSlab->id }}">
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">{{ $paxSlab->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $paxSlab->min_pax }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $paxSlab->max_pax }}</td>
                                    
                                    <td class="px-4 py-2 whitespace-nowrap text-left">
                                        <a href="{{ route('pax_slabs.edit', $paxSlab->id) }}"
                                            class="text-yellow-600 hover:underline mr-2">Edit</a>
                                        <form action="{{ route('pax_slabs.destroy', $paxSlab->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Are you sure you want to delete this pax slab?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" {{-- Adjusted colspan --}}
                                        class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                                            </svg>
                                            <p class="text-lg font-medium text-gray-700">No pax slabs found</p>
                                            <p class="text-sm text-gray-500 mb-4">Get started by adding a new pax slab.</p>
                                            <a href="{{ route('pax_slabs.create') }}"
                                                class="mt-2 flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                                </svg>
                                                Add Pax Slab
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pax Slabs are usually not paginated in the same way as other resources. If you do paginate them, add the links here. --}}
                {{-- <div class="p-4 border-t border-gray-200">
                    {{ $paxSlabs->links() }}
                </div> --}}
            </div>
        </div>
    </section>
</x-app-layout>