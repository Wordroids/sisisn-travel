<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Manage Vehicle Types</h2>

        <a href="{{ route('vehicle_types.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">+ Add Vehicle Type</a>

        <table class="w-full mt-4 border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Vehicle Type</th>
                    <th class="border px-4 py-2">Default Rate (USD)</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicleTypes as $vehicleType)
                    <tr class="border hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $vehicleType->name }}</td>
                        <td class="border px-4 py-2">{{ number_format($vehicleType->default_rate, 2) }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('vehicle_types.edit', $vehicleType->id) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('vehicle_types.destroy', $vehicleType->id) }}" method="POST" class="inline-block ml-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Delete this vehicle type?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
