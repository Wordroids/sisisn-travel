<x-app-layout>
    <section class="bg-gray-50 py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div class="flex flex-col py-3 md:flex-row md:items-center md:justify-between">
                        <h5 class="text-gray-500">Travel Routes: <span>{{ $travelRoutes->count() }}</span></h5>
                        <a href="{{ route('travel_routes.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-800">
                            Add new travel route
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Route Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Mileage (KM)</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($travelRoutes as $travelRoute)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $travelRoute->name }}</td>
                                <td class="px-4 py-2">{{ $travelRoute->description ?: 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $travelRoute->mileage ?: 'N/A' }} KM</td>
                                <td class="px-4 py-2">
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
</x-app-layout>