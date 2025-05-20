<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Select Template for Group Quotation</h1>
            <p class="mt-2 text-sm text-gray-600">Choose a template to use as the basis for your new group quotation.</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Template Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($templates as $template)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:border-blue-500 transition">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h2 class="text-lg font-medium text-gray-900">{{ $template->template_name }}</h2>
                            <span class="px-2 py-1 text-xs rounded-full {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $template->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $template->description ?? 'No description available' }}</p>
                        
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="block text-xs text-gray-500">Accommodations</span>
                                <span class="font-medium">{{ count($template->accommodations ?? []) }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500">Travel Plans</span>
                                <span class="font-medium">{{ count($template->travel_plans ?? []) }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500">Site Seeings</span>
                                <span class="font-medium">{{ count($template->site_seeings ?? []) }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500">Extras</span>
                                <span class="font-medium">{{ count($template->extras ?? []) }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <form action="{{ route('process_template') }}" method="POST">
                                @csrf
                                <input type="hidden" name="template_id" value="{{ $template->id }}">
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                    Use This Template
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-600 text-lg mb-4">No templates available</p>
                    <p class="text-gray-500 text-sm mb-6">You need to create templates before creating a group quotation</p>
                    <a href="{{ route('process_template') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition">
                        Create Template
                    </a>
                </div>
            @endforelse
        </div>

        
    </div>
</x-app-layout>