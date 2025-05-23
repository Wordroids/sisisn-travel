<x-app-layout>
    <section class="py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div class="flex flex-col py-3 md:flex-row md:items-center md:justify-between">
                        <h5 class="text-gray-500">Room Types: <span>{{ $roomTypes->count() }}</span></h5>
                        <a href="{{ route('room_types.create') }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-800">
                            Add new room type
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Room Type Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomTypes as $roomType)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $roomType->name }}</td>
                                    <td class="px-4 py-2">{{ $roomType->description ?: 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('room_types.edit', $roomType) }}"
                                            class="text-yellow-600 hover:underline">Edit</a>
                                        <form action="{{ route('room_types.destroy', $roomType) }}" method="POST"
                                            class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline"
                                                onclick="return confirm('Delete this room type?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $roomTypes->links() }}</div>
            </div>
        </div>
    </section>
</x-app-layout>
