<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Customer Details</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <h4 class="text-gray-600">Full Name</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $customer->name }}</p>
            </div>

            <!-- Email -->
            <div>
                <h4 class="text-gray-600">Email</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $customer->email }}</p>
            </div>

            <!-- Phone -->
            <div>
                <h4 class="text-gray-600">Phone</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $customer->phone }}</p>
            </div>

            <!-- WhatsApp -->
            <div>
                <h4 class="text-gray-600">WhatsApp</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $customer->whatsapp }}</p>
            </div>

            <!-- Country -->
            <div>
                <h4 class="text-gray-600">Country</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $customer->country }}</p>
            </div>

            <!-- Created At -->
            <div>
                <h4 class="text-gray-600">Created At</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $customer->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('customers.edit', $customer) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Edit Customer
            </a>

            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Delete Customer
                </button>
            </form>

            <a href="{{ route('customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Back to List
            </a>
        </div>
    </div>
</x-app-layout>
