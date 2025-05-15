<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}">
        @csrf
        @isset($driver)
            @method('PUT')
        @endisset

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Driver Name</label>
            <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('name', $driver->name ?? '') }}" required>
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input type="number" name="contact_no" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('contact_no', $driver->contact_no ?? '') }}" required>
            @error('contact_no') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <textarea name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                      required>{{ old('address', $driver->address ?? '') }}</textarea>
            @error('address') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('email', $driver->email ?? '') }}" required>
            @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Per Day Charge (Rs.)</label>
            <input type="number" name="per_day_charge" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('per_day_charge', $driver->per_day_charge ?? '') }}" required>
            @error('per_day_charge') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
            {{ isset($driver) ? 'Update Driver' : 'Create Driver' }}
        </button>
    </form>
</div>