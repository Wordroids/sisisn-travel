<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Edit Vehicle Type</h2>

        <form method="POST" action="{{ route('vehicle_types.update', $vehicleType->id) }}">
            @csrf
            @method('PUT')

            <label class="block text-sm font-medium text-gray-700">Vehicle Type</label>
            <input type="text" name="name" value="{{ $vehicleType->name }}" class="block w-full border-gray-300 rounded-md shadow-sm p-2" required>

            <label class="block text-sm font-medium text-gray-700 mt-4">Default Rate (USD)</label>
            <input type="number" step="0.01" name="default_rate" value="{{ $vehicleType->default_rate }}" class="block w-full border-gray-300 rounded-md shadow-sm p-2" required>

            <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-app-layout>
