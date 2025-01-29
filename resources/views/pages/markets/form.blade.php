<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}">
        @csrf
        @isset($market)
            @method('PUT')
        @endisset

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Market Name</label>
            <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('name', $market->name ?? '') }}" required>
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
            {{ isset($market) ? 'Update Market' : 'Create Market' }}
        </button>
    </form>
</div>
