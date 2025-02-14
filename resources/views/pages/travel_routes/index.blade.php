<x-app-layout>
    <head>    
        <!-- Add Fancybox CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    </head>
    <section class="bg-gray-50 py-3 sm:py-5">
        <div class="px-3">
            <!-- Removed overflow-hidden from parent div -->
            <div class="relative h-full bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div class="flex flex-col py-3 md:flex-row md:items-center md:justify-between">
                        <h5 class="text-gray-500">Travel Routes: <span>{{ $travelRoutes->count() }}</span></h5>
                        <a href="{{ route('travel_routes.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-800">
                            Add new travel route
                        </a>
                    </div>
                </div>

                <!-- Added min-height to ensure table has enough space -->
                <div class="min-h-[400px]">
                    <table class="w-full text-sm text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Route Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Mileage (KM)</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($travelRoutes as $travelRoute)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-3">
                                    @php
                                        $featuredAsset = $travelRoute->assets()->where('is_featured', true)->first();
                                        $allAssets = $travelRoute->assets;
                                    @endphp
                                    
                                    @if($featuredAsset)
                                        <div class="relative group">
                                            <!-- Display featured image thumbnail -->
                                            <a href="{{ asset('storage/' . $featuredAsset->file_path) }}" 
                                               data-fancybox="gallery-{{ $travelRoute->id }}"
                                               data-caption="{{ $travelRoute->name }} - Featured Image">
                                                <img src="{{ asset('storage/' . $featuredAsset->file_path) }}" 
                                                     alt="{{ $travelRoute->name }}"
                                                     class="w-20 h-20 object-cover rounded-lg hover:opacity-75 transition-opacity">
                                            </a>
                                
                                            <!-- Hidden links for other images in the same gallery group -->
                                            @foreach($allAssets as $asset)
                                                @if(!$asset->is_featured)
                                                    <a href="{{ asset('storage/' . $asset->file_path) }}" 
                                                       data-fancybox="gallery-{{ $travelRoute->id }}"
                                                       data-caption="{{ $travelRoute->name }} - Additional Image"
                                                       class="hidden">
                                                    </a>
                                                @endif
                                            @endforeach
                                
                                            <!-- Image count badge -->
                                            @if($allAssets->count() > 1)
                                                <span class="absolute bottom-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                                                    {{ $allAssets->count() }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400">No image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $travelRoute->name }}</td>
                                <td class="px-4 py-3">
                                    <div class="relative">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <!-- Truncated description -->
                                            <span class="truncate max-w-[300px]">
                                                {{ $travelRoute->description ?: 'N/A' }}
                                            </span>
                                            
                                            @if($travelRoute->description)
                                                <button data-popover-target="desc-{{ $travelRoute->id }}" 
                                                        data-popover-placement="right" 
                                                        type="button">
                                                    <svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" 
                                                         aria-hidden="true" 
                                                         fill="currentColor" 
                                                         viewBox="0 0 20 20" 
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" 
                                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" 
                                                              clip-rule="evenodd">
                                                        </path>
                                                    </svg>
                                                    <span class="sr-only">Show description</span>
                                                </button>
                                
                                                <!-- Flowbite popover content -->
                                                <div data-popover 
                                                     id="desc-{{ $travelRoute->id }}" 
                                                     role="tooltip" 
                                                     class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-96">
                                                    <div class="p-3 space-y-2">
                                                        <h3 class="font-semibold text-gray-900">{{ $travelRoute->name }}</h3>
                                                        <p>{{ $travelRoute->description }}</p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            @endif
                                        </p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $travelRoute->mileage ?: 'N/A' }} KM</td>
                                <td class="px-4 py-3 space-x-2">
                                    <a href="{{ route('travel_routes.edit', $travelRoute) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('travel_routes.destroy', $travelRoute) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this travel route?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $travelRoutes->links() }}</div>
            </div>
        </div>
    </section>
    <!-- Add Fancybox JS before closing body tag -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <!-- Initialize Fancybox -->
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Custom options if needed
        });
    </script>

</x-app-layout>