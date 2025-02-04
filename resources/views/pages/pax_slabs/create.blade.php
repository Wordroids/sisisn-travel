<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Add Pax Slab</h2>

        <form method="POST" action="{{ route('pax_slabs.store') }}">
            @csrf

            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" class="block w-full border-gray-300 rounded-md shadow-sm p-2" required>

            <label class="block text-sm font-medium text-gray-700 mt-4">Min Pax</label>
            <input type="number" name="min_pax" class="block w-full border-gray-300 rounded-md shadow-sm p-2" required>

            <label class="block text-sm font-medium text-gray-700 mt-4">Max Pax</label>
            <input type="number" name="max_pax" class="block w-full border-gray-300 rounded-md shadow-sm p-2" required>

            <label class="block text-sm font-medium text-gray-700 mt-4">Order</label>
            <input type="number" name="order" class="block w-full border-gray-300 rounded-md shadow-sm p-2" required>

            <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Save</button>
        </form>
    </div>
</x-app-layout>
