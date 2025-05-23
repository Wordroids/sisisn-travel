<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}">
        @csrf
        @isset($hotel)
            @method('PUT')
        @endisset

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Hotel Name</label>
            <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('name', $hotel->name ?? '') }}" required>
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Location</label>
            <input type="text" name="location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('location', $hotel->location ?? '') }}" required>
            @error('location') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Star Rating</label>
            <select name="star_rating" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ isset($hotel) && $hotel->star_rating == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                @endfor
            </select>
            @error('star_rating') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
            {{ isset($hotel) ? 'Update Hotel' : 'Create Hotel' }}
        </button>
    </form>
</div>
