<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Hotel Details</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-600">Hotel Name</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $hotel->name }}</p>
            </div>

            <div>
                <h4 class="text-gray-600">Location</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $hotel->location }}</p>
            </div>

            <div>
                <h4 class="text-gray-600">Star Rating</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $hotel->star_rating }} ⭐</p>
            </div>

            <div>
                <h4 class="text-gray-600">Description</h4>
                <p class="text-lg text-gray-900">{{ $hotel->description ?: 'N/A' }}</p>
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <a href="{{ route('hotels.edit', $hotel) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Edit Hotel
            </a>

            <a href="{{ route('hotels.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Back to List
            </a>
        </div>
    </div>
</x-app-layout>
