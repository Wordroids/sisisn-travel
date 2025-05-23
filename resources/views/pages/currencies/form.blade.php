<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}">
        @csrf
        @isset($currency)
            @method('PUT')
        @endisset

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Currency Name</label>
            <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('name', $currency->name ?? '') }}" required>
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Currency Code</label>
            <input type="text" name="code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('code', $currency->code ?? '') }}" required>
            @error('code') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Conversion Rate</label>
            <input type="number" step="0.0001" name="conversion_rate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('conversion_rate', $currency->conversion_rate ?? '') }}" required>
            @error('conversion_rate') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
            {{ isset($currency) ? 'Update Currency' : 'Create Currency' }}
        </button>
    </form>
</div>
