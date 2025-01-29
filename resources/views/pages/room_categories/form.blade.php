<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}">
        @csrf
        @isset($roomCategory)
            @method('PUT')
        @endisset

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Room Category Name</label>
            <input type="text" name="name" class="block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('name', $roomCategory->name ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $roomCategory->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
            {{ isset($roomCategory) ? 'Update Room Category' : 'Create Room Category' }}
        </button>
    </form>
</div>
