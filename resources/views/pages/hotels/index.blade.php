<x-app-layout>
    <section class="py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div
                        class="flex flex-col py-3 space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 md:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">Hotels:</span>
                                <span>{{ $hotels->count() }}</span>
                            </h5>
                        </div>
                    </div>

                    <!-- Add New Hotel Button -->
                    <div
                        class="flex flex-col items-stretch justify-between py-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                        <a href="{{ route('hotels.create') }}"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            Add new hotel
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Hotel Name</th>
                                <th class="px-4 py-3">Location</th>
                                <th class="px-4 py-3">Star Rating</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hotels as $hotel)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $hotel->name }}</td>
                                    <td class="px-4 py-2">{{ $hotel->location }}</td>
                                    <td class="px-4 py-2">{{ $hotel->star_rating }} ⭐</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('hotels.edit', $hotel) }}"
                                            class="text-yellow-600 hover:underline mr-2">Edit</a>
                                        <form action="{{ route('hotels.destroy', $hotel) }}" method="POST"
                                            class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $hotels->links() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
